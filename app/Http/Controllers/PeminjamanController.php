<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    const DURASI_PINJAM = 7;   // hari
    const MAX_PINJAM    = 3;   // buku per anggota

    public function index()
    {
        // Summary card
        $totalDipinjam = Peminjaman::where('status_pinjam', 'dipinjam')->count();
        $terlambat = Peminjaman::where('status_pinjam', 'dipinjam')
            ->whereDate('tanggal_jatuh_tempo', '<', now())->count();
        $peminjamBaruHariIni = Peminjaman::whereDate('tanggal_pinjam', today())->count();

        // Tabel peminjaman aktif hari ini
        $peminjaman = Peminjaman::with(['anggota.pengguna', 'buku'])
            ->where('status_pinjam', 'dipinjam')
            ->latest('created_at')
            ->paginate(10);

        // Dropdown form
        $anggota = Anggota::with('pengguna')->where('status_anggota', 'aktif')->get();
        $bukuTersedia = Buku::where('stok_tersedia', '>', 0)->orderBy('judul_buku')->get();

        return view('admin.peminjaman.index', compact(
            'totalDipinjam', 'terlambat', 'peminjamBaruHariIni',
            'peminjaman', 'anggota', 'bukuTersedia'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'id_buku'    => 'required|exists:buku,id_buku',
        ]);

        $buku = Buku::findOrFail($data['id_buku']);

        // Cek stok
        if ($buku->stok_tersedia < 1) {
            return back()->with('error', 'Stok buku tidak tersedia.');
        }

        // Cek batas maksimal 3 buku per anggota
        $jumlahPinjamAktif = Peminjaman::where('id_anggota', $data['id_anggota'])
            ->where('status_pinjam', 'dipinjam')->count();
        if ($jumlahPinjamAktif >= self::MAX_PINJAM) {
            return back()->with('error', 'Anggota sudah meminjam ' . self::MAX_PINJAM . ' buku (batas maksimal).');
        }

        DB::transaction(function () use ($data, $buku) {
            // Buat data peminjaman
            Peminjaman::create([
                'id_pinjam'           => $this->generateId(),
                'id_pengguna'         => Auth::user()->id_pengguna,
                'id_buku'             => $data['id_buku'],
                'id_anggota'          => $data['id_anggota'],
                'id_kembali'          => null,
                'tanggal_pinjam'      => Carbon::today(),
                'tanggal_jatuh_tempo' => Carbon::today()->addDays(self::DURASI_PINJAM),
                'status_pinjam'       => 'dipinjam',
            ]);

            // Kurangi stok
            $buku->decrement('stok_tersedia');
            if ($buku->fresh()->stok_tersedia < 1) {
                $buku->update(['status_buku' => 'kosong']);
            }
        });

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil diproses.');
    }

    // Generator ID: PJ0001, PJ0002, ...
    private function generateId()
    {
        $last = Peminjaman::where('id_pinjam', 'like', 'PJ%')
            ->orderBy('id_pinjam', 'desc')->first();
        $nomor = $last ? ((int) substr($last->id_pinjam, 2)) + 1 : 1;
        return 'PJ' . str_pad($nomor, 4, '0', STR_PAD_LEFT);
    }
}