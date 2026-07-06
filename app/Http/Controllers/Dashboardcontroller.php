<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Denda;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ================= SUMMARY CARDS =================

        // Total buku (jumlah semua judul/eksemplar)
        $totalBuku = Buku::sum('stok_buku');

        // Anggota dengan status aktif
        $anggotaAktif = Anggota::where('status_anggota', 'Aktif')->count();

        // Buku yang statusnya masih dipinjam (belum dikembalikan)
        $bukuDipinjam = Peminjaman::where('status_pinjam', 'Dipinjam')->count();

        // Total denda yang belum dibayar
        $totalDendaBelumLunas = Denda::where('status_bayar', 'Belum Lunas')->sum('total_denda');
        // Format ke jt/rb biar sesuai tampilan (opsional, boleh dihapus kalau mau angka penuh)
        $dendaBelumLunas = $totalDendaBelumLunas >= 1000000
            ? number_format($totalDendaBelumLunas / 1000000, 1) . 'jt'
            : number_format($totalDendaBelumLunas / 1000, 0) . 'rb';

        // ================= PERSENTASE PERUBAHAN (opsional, contoh sederhana) =================
        // Bandingkan bulan ini vs bulan lalu. Sesuaikan logic ini dengan kebutuhanmu.
        $bukuBulanIni = Buku::whereMonth('created_at', now()->month)->count();
        $bukuBulanLalu = Buku::whereMonth('created_at', now()->subMonth()->month)->count();
        $persenBukuBaru = $bukuBulanLalu > 0
            ? round((($bukuBulanIni - $bukuBulanLalu) / $bukuBulanLalu) * 100)
            : 0;

        $anggotaBulanIni = Anggota::whereMonth('tanggal_daftar', now()->month)->count();
        $anggotaBulanLalu = Anggota::whereMonth('tanggal_daftar', now()->subMonth()->month)->count();
        $persenAnggotaBaru = $anggotaBulanLalu > 0
            ? round((($anggotaBulanIni - $anggotaBulanLalu) / $anggotaBulanLalu) * 100)
            : 0;

        $persenBukuDipinjam = 0; // placeholder, isi logic pembanding kalau perlu

        // ================= GRAFIK TREN PEMINJAMAN (7 hari terakhir) =================
        $labelHari = [];
        $dataPeminjaman = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subDays($i);
            $labelHari[] = $tanggal->translatedFormat('D'); // Sen, Sel, Rab, dst
            $dataPeminjaman[] = Peminjaman::whereDate('tanggal_pinjam', $tanggal->toDateString())->count();
        }

        // ================= AKTIVITAS TERAKHIR =================
        // Gabungan aktivitas dari peminjaman, pengembalian, denda, dan anggota baru.
        // Contoh sederhana ambil dari peminjaman terbaru saja - silakan kembangkan sesuai kebutuhan.
        $aktivitas = Peminjaman::with(['anggota', 'buku'])
            ->latest('created_at')
            ->take(4)
            ->get()
            ->map(function ($item) {
                return [
                    'teks'  => ($item->anggota->nama_anggota ?? 'Anggota') . ' meminjam "' . ($item->buku->judul_buku ?? '-') . '"',
                    'waktu' => $item->created_at->diffForHumans(),
                    'warna' => 'biru',
                ];
            })->toArray();

        // ================= TABEL PEMINJAMAN TERBARU =================
        $peminjamanTerbaru = Peminjaman::with(['anggota', 'buku'])
            ->latest('tanggal_pinjam')
            ->take(5)
            ->get()
            ->map(function ($item) {
                $nama = $item->anggota->nama_anggota ?? '-';
                $inisial = collect(explode(' ', $nama))->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->implode('');

                // Tentukan status terlambat berdasarkan tanggal jatuh tempo
                $status = $item->status_pinjam;
                if ($status === 'Dipinjam' && Carbon::parse($item->tanggal_jatuh_tempo)->isPast()) {
                    $status = 'Terlambat';
                }

                return [
                    'inisial'        => $inisial ?: '?',
                    'nama'           => $nama,
                    'judul_buku'     => $item->buku->judul_buku ?? '-',
                    'tanggal_pinjam' => Carbon::parse($item->tanggal_pinjam)->translatedFormat('d M Y'),
                    'jatuh_tempo'    => Carbon::parse($item->tanggal_jatuh_tempo)->translatedFormat('d M Y'),
                    'status'         => $status,
                ];
            })->toArray();

        return view('admin.dashboard', compact(
            'totalBuku',
            'anggotaAktif',
            'bukuDipinjam',
            'dendaBelumLunas',
            'persenBukuBaru',
            'persenAnggotaBaru',
            'persenBukuDipinjam',
            'labelHari',
            'dataPeminjaman',
            'aktivitas',
            'peminjamanTerbaru'
        ));
    }
}