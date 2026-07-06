<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Kategori;
use App\Models\Rak;
use App\Models\Pengguna;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Denda;

class PerpustakaanSeeder extends Seeder
{
    public function run(): void
    {
        // 1. KATEGORI
        Kategori::create(['id_kategori' => 'KT0001', 'nama_kategori' => 'Teknologi', 'deskripsi' => 'Buku IT dan rekayasa']);
        Kategori::create(['id_kategori' => 'KT0002', 'nama_kategori' => 'Ekonomi', 'deskripsi' => 'Buku manajemen dan keuangan']);
        Kategori::create(['id_kategori' => 'KT0003', 'nama_kategori' => 'Sosial', 'deskripsi' => 'Sosiologi dan kemasyarakatan']);

        // 2. RAK
        Rak::create(['id_rak' => 'RK0001', 'nama_rak' => 'Rak A1', 'lokasi_rak' => 'Lantai 1 - Teknologi']);
        Rak::create(['id_rak' => 'RK0002', 'nama_rak' => 'Rak B2', 'lokasi_rak' => 'Lantai 1 - Ekonomi']);
        Rak::create(['id_rak' => 'RK0003', 'nama_rak' => 'Rak C3', 'lokasi_rak' => 'Lantai 2 - Sosial']);

        // 3. PENGGUNA (1 admin + 3 anggota)
        Pengguna::create([
            'id_pengguna' => 'PG0001',
            'nama_pengguna' => 'Admin Utama',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email' => 'admin@perpustakaan.ac.id',
            'no_telepon' => '081234567890',
            'status_pengguna' => 'aktif',
        ]);

        Pengguna::create([
            'id_pengguna' => 'PG0002',
            'nama_pengguna' => 'Budi Santoso',
            'username' => 'budi',
            'password' => Hash::make('password'),
            'role' => 'anggota',
            'email' => 'budi@mail.com',
            'no_telepon' => '081211112222',
            'status_pengguna' => 'aktif',
        ]);

        Pengguna::create([
            'id_pengguna' => 'PG0003',
            'nama_pengguna' => 'Siti Aminah',
            'username' => 'siti',
            'password' => Hash::make('password'),
            'role' => 'anggota',
            'email' => 'siti@mail.com',
            'no_telepon' => '081233334444',
            'status_pengguna' => 'aktif',
        ]);

        Pengguna::create([
            'id_pengguna' => 'PG0004',
            'nama_pengguna' => 'Ahmad Dahlan',
            'username' => 'ahmad',
            'password' => Hash::make('password'),
            'role' => 'anggota',
            'email' => 'ahmad@mail.com',
            'no_telepon' => '081255556666',
            'status_pengguna' => 'aktif',
        ]);

        // 4. ANGGOTA (terhubung ke pengguna dengan role anggota)
        Anggota::create([
            'id_anggota' => 'AG0001',
            'id_pengguna' => 'PG0002',
            'alamat' => 'Jl. Merdeka No. 45, Surabaya',
            'tanggal_daftar' => '2026-01-10',
            'status_anggota' => 'aktif',
        ]);

        Anggota::create([
            'id_anggota' => 'AG0002',
            'id_pengguna' => 'PG0003',
            'alamat' => 'Jl. Thamrin No. 12, Surabaya',
            'tanggal_daftar' => '2026-02-05',
            'status_anggota' => 'aktif',
        ]);

        Anggota::create([
            'id_anggota' => 'AG0003',
            'id_pengguna' => 'PG0004',
            'alamat' => 'Jl. Diponegoro No. 8, Surabaya',
            'tanggal_daftar' => '2026-03-01',
            'status_anggota' => 'aktif',
        ]);

        // 5. BUKU
        Buku::create([
            'id_buku' => 'BK0001', 'id_kategori' => 'KT0001', 'id_rak' => 'RK0001', 'id_pengguna' => 'PG0001',
            'judul_buku' => 'Algoritma & Struktur Data', 'pengarang' => 'Prof. Dr. Ir. Hadi', 'penerbit' => 'Informatika Press',
            'tahun_terbit' => 2023, 'stok_buku' => 12, 'stok_tersedia' => 12, 'status_buku' => 'tersedia',
        ]);

        Buku::create([
            'id_buku' => 'BK0002', 'id_kategori' => 'KT0002', 'id_rak' => 'RK0002', 'id_pengguna' => 'PG0001',
            'judul_buku' => 'Ekonomi Mikro Terapan', 'pengarang' => 'Siti Aminah, M.E.', 'penerbit' => 'Salemba Empat',
            'tahun_terbit' => 2022, 'stok_buku' => 5, 'stok_tersedia' => 4, 'status_buku' => 'tersedia',
        ]);

        Buku::create([
            'id_buku' => 'BK0003', 'id_kategori' => 'KT0001', 'id_rak' => 'RK0001', 'id_pengguna' => 'PG0001',
            'judul_buku' => 'Manajemen Basis Data', 'pengarang' => 'Budi Santoso', 'penerbit' => 'Gramedia',
            'tahun_terbit' => 2024, 'stok_buku' => 8, 'stok_tersedia' => 7, 'status_buku' => 'tersedia',
        ]);

        Buku::create([
            'id_buku' => 'BK0004', 'id_kategori' => 'KT0003', 'id_rak' => 'RK0003', 'id_pengguna' => 'PG0001',
            'judul_buku' => 'Psikologi Pendidikan', 'pengarang' => 'Drs. Ahmad Yani', 'penerbit' => 'Bumi Aksara',
            'tahun_terbit' => 2021, 'stok_buku' => 24, 'stok_tersedia' => 24, 'status_buku' => 'tersedia',
        ]);

        Buku::create([
            'id_buku' => 'BK0005', 'id_kategori' => 'KT0001', 'id_rak' => 'RK0001', 'id_pengguna' => 'PG0001',
            'judul_buku' => 'Jaringan Komputer Lanjut', 'pengarang' => 'Ir. Lukman Hakim', 'penerbit' => 'Andi Publisher',
            'tahun_terbit' => 2024, 'stok_buku' => 8, 'stok_tersedia' => 8, 'status_buku' => 'tersedia',
        ]);

        // 6. PEMINJAMAN (3 transaksi)
        // Transaksi 1: masih dipinjam (belum kembali)
        Peminjaman::create([
            'id_pinjam' => 'PJ0001', 'id_pengguna' => 'PG0001', 'id_buku' => 'BK0002', 'id_anggota' => 'AG0001',
            'tanggal_pinjam' => '2026-06-25', 'tanggal_jatuh_tempo' => '2026-07-02', 'status_pinjam' => 'dipinjam',
        ]);

        // Transaksi 2: masih dipinjam (belum kembali)
        Peminjaman::create([
            'id_pinjam' => 'PJ0002', 'id_pengguna' => 'PG0001', 'id_buku' => 'BK0003', 'id_anggota' => 'AG0002',
            'tanggal_pinjam' => '2026-06-28', 'tanggal_jatuh_tempo' => '2026-07-05', 'status_pinjam' => 'dipinjam',
        ]);

        // Transaksi 3: sudah lengkap (pinjam -> kembali telat -> kena denda)
        Peminjaman::create([
            'id_pinjam' => 'PJ0003', 'id_pengguna' => 'PG0001', 'id_buku' => 'BK0004', 'id_anggota' => 'AG0003',
            'tanggal_pinjam' => '2026-06-10', 'tanggal_jatuh_tempo' => '2026-06-17', 'status_pinjam' => 'dikembalikan',
        ]);

        // 7. PENGEMBALIAN (untuk transaksi PJ0003, telat 3 hari)
        Pengembalian::create([
            'id_kembali' => 'KB0001', 'id_pinjam' => 'PJ0003', 'id_pengguna' => 'PG0001',
            'tanggal_kembali' => '2026-06-20', 'kondisi_buku' => 'baik', 'status_kembali' => 'dikembalikan',
        ]);

        // Update PJ0003 supaya id_kembali terisi (melengkapi relasi melingkar)
        Peminjaman::where('id_pinjam', 'PJ0003')->update(['id_kembali' => 'KB0001']);

        // 8. DENDA (untuk pengembalian yang telat)
        Denda::create([
            'id_denda' => 'DN0001', 'id_pengguna' => 'PG0001', 'id_kembali' => 'KB0001',
            'jumlah_hari_terlambat' => 3, 'tarif_per_hari' => 2000, 'total_denda' => 6000,
            'alasan_denda' => 'Keterlambatan pengembalian', 'status_bayar' => 'belum lunas',
        ]);

        // Update pengembalian supaya id_denda terisi
        Pengembalian::where('id_kembali', 'KB0001')->update(['id_denda' => 'DN0001']);
    }
}