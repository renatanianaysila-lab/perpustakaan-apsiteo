<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Denda;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    const TARIF_DENDA = 2000; // Rp per hari (sesuai aturan laporan)

    public function index()
    {
        // Daftar pinjaman aktif (yang belum dikembalikan)
        $pinjamanAktif = Peminjaman::with(['anggota.pengguna', 'buku'])
            ->where('status_pinjam', 'dipinjam')
            ->latest('created_at')
            ->paginate(10);

        // Statistik untuk summary card
        $transaksiHariIni = Pengembalian::whereDate('tanggal_kembali', today())->count();
        $dendaBulanIni = Denda::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_denda');

        return view('admin.pengembalian.index', compact(
            'pinjamanAktif', 'transaksiHariIni', 'dendaBulanIni'
        ));
    }

    // Preview denda sebelum proses (dipanggil saat admin cek 1 pinjaman)
    public function proses(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status_pinjam !== 'dipinjam') {
            return back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        DB::transaction(function () use ($peminjaman) {
            $tanggalKembali = Carbon::today();
            $jatuhTempo = Carbon::parse($peminjaman->tanggal_jatuh_tempo);

            // Hitung keterlambatan
            $hariTerlambat = 0;
            if ($tanggalKembali->gt($jatuhTempo)) {
                $hariTerlambat = $jatuhTempo->diffInDays($tanggalKembali);
            }

            $idKembali = $this->generateId(Pengembalian::class, 'id_kembali', 'KB');
            $idDenda = null;

            // 1. Buat data pengembalian
            $pengembalian = Pengembalian::create([
                'id_kembali'      => $idKembali,
                'id_pinjam'       => $peminjaman->id_pinjam,
                'id_pengguna'     => Auth::user()->id_pengguna,
                'id_denda'        => null,
                'tanggal_kembali' => $tanggalKembali,
                'kondisi_buku'    => 'baik',
                'status_kembali'  => 'selesai',
            ]);

            // 2. Kalau terlambat, buat denda
            if ($hariTerlambat > 0) {
                $idDenda = $this->generateId(Denda::class, 'id_denda', 'DN');
                $totalDenda = $hariTerlambat * self::TARIF_DENDA;

                Denda::create([
                    'id_denda'              => $idDenda,
                    'id_pengguna'           => Auth::user()->id_pengguna,
                    'id_kembali'            => $idKembali,
                    'jumlah_hari_terlambat' => $hariTerlambat,
                    'tarif_per_hari'        => self::TARIF_DENDA,
                    'total_denda'           => $totalDenda,
                    'alasan_denda'          => 'Keterlambatan pengembalian buku',
                    'status_bayar'          => 'belum',
                    'tanggal_bayar'         => null,
                ]);

                // hubungkan pengembalian ke denda
                $pengembalian->update(['id_denda' => $idDenda]);
            }

            // 3. Update status peminjaman + hubungkan ke pengembalian
            $peminjaman->update([
                'status_pinjam' => 'dikembalikan',
                'id_kembali'    => $idKembali,
            ]);

            // 4. Kembalikan stok buku
            $buku = Buku::find($peminjaman->id_buku);
            if ($buku) {
                $buku->increment('stok_tersedia');
                $buku->update(['status_buku' => 'tersedia']);
            }
        });

        return redirect()->route('admin.pengembalian.index')
            ->with('success', 'Pengembalian berhasil diproses.');
    }

    // Generator ID: KB0001, DN0001, dst
    private function generateId($model, $kolom, $prefix)
    {
        $last = $model::where($kolom, 'like', $prefix . '%')
            ->orderBy($kolom, 'desc')->first();
        $nomor = $last ? ((int) substr($last->$kolom, strlen($prefix))) + 1 : 1;
        return $prefix . str_pad($nomor, 4, '0', STR_PAD_LEFT);
    }
}