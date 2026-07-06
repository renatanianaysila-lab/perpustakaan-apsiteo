<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Denda;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $anggota = Anggota::where('id_pengguna', Auth::user()->id_pengguna)->first();

        if (!$anggota) {
            abort(403, 'Akun ini bukan anggota perpustakaan.');
        }

        // Semua peminjaman anggota ini
        $riwayat = Peminjaman::with(['buku', 'pengembalian.denda'])
            ->where('id_anggota', $anggota->id_anggota)
            ->latest('tanggal_pinjam')
            ->paginate(10);

        // Statistik
        $totalDipinjam = Peminjaman::where('id_anggota', $anggota->id_anggota)->count();
        $sedangDipinjam = Peminjaman::where('id_anggota', $anggota->id_anggota)
            ->where('status_pinjam', 'dipinjam')->count();

        // Total denda belum lunas milik anggota ini
        $dendaBelumLunas = Denda::where('id_pengguna', Auth::user()->id_pengguna)
            ->where('status_bayar', 'belum')
            ->sum('total_denda');

        return view('anggota.riwayat', compact(
            'riwayat', 'totalDipinjam', 'sedangDipinjam', 'dendaBelumLunas'
        ));
    }
}