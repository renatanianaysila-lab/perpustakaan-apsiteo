<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KatalogController extends Controller
{
    const DURASI_PINJAM = 7;
    const MAX_PINJAM = 3;

    public function index(Request $request)
    {
        $keyword = $request->input('q');
        $kategoriId = $request->input('kategori');

        $buku = Buku::with(['kategori', 'rak'])
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('judul_buku', 'like', "%{$keyword}%")
                      ->orWhere('pengarang', 'like', "%{$keyword}%");
            })
            ->when($kategoriId, fn($q) => $q->where('id_kategori', $kategoriId))
            ->orderBy('judul_buku')
            ->paginate(12)
            ->withQueryString();

        $kategori = Kategori::orderBy('nama_kategori')->get();
        $totalBuku = Buku::count();

        return view('anggota.katalog', compact('buku', 'kategori', 'keyword', 'kategoriId', 'totalBuku'));
    }

    public function pinjam(Request $request, Buku $buku)
    {
        // Ambil data anggota dari user login
        $anggota = Anggota::where('id_pengguna', Auth::user()->id_pengguna)->first();

        if (!$anggota) {
            return back()->with('error', 'Akun ini bukan anggota perpustakaan.');
        }

        if ($anggota->status_anggota !== 'aktif') {
            return back()->with('error', 'Keanggotaan Anda tidak aktif.');
        }

        // Cek stok
        if ($buku->stok_tersedia < 1) {
            return back()->with('error', 'Stok buku tidak tersedia.');
        }

        // Cek batas maksimal
        $jumlahAktif = Peminjaman::where('id_anggota', $anggota->id_anggota)
            ->where('status_pinjam', 'dipinjam')->count();
        if ($jumlahAktif >= self::MAX_PINJAM) {
            return back()->with('error', 'Anda sudah meminjam ' . self::MAX_PINJAM . ' buku (batas maksimal).');
        }

        DB::transaction(function () use ($buku, $anggota) {
            Peminjaman::create([
                'id_pinjam'           => $this->generateId(),
                'id_pengguna'         => Auth::user()->id_pengguna,
                'id_buku'             => $buku->id_buku,
                'id_anggota'          => $anggota->id_anggota,
                'id_kembali'          => null,
                'tanggal_pinjam'      => Carbon::today(),
                'tanggal_jatuh_tempo' => Carbon::today()->addDays(self::DURASI_PINJAM),
                'status_pinjam'       => 'dipinjam',
            ]);

            $buku->decrement('stok_tersedia');
            if ($buku->fresh()->stok_tersedia < 1) {
                $buku->update(['status_buku' => 'kosong']);
            }
        });

        return back()->with('success', 'Permintaan pinjam berhasil! Buku "' . $buku->judul_buku . '" telah dipinjam.');
    }

    private function generateId()
    {
        $last = Peminjaman::where('id_pinjam', 'like', 'PJ%')
            ->orderBy('id_pinjam', 'desc')->first();
        $nomor = $last ? ((int) substr($last->id_pinjam, 2)) + 1 : 1;
        return 'PJ' . str_pad($nomor, 4, '0', STR_PAD_LEFT);
    }
}