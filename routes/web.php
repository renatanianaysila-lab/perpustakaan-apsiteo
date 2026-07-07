<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\Anggota\KartuController;
use App\Http\Controllers\Anggota\KatalogController;
use App\Http\Controllers\Anggota\RiwayatController;

/*
|--------------------------------------------------------------------------
| Route Tamu (belum login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
});

/*
|--------------------------------------------------------------------------
| Route Setelah Login (butuh middleware auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // ================= AREA ADMIN =================
    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('buku', BukuController::class)->except(['show']);
        Route::resource('kategori', KategoriController::class)->except(['show']);
        Route::resource('rak', RakController::class)->except(['show']);

        // anggota: paksa nama parameter jadi {anggota} (biar tidak jadi {anggotum})
        Route::resource('anggota', AnggotaController::class)
            ->except(['show'])
            ->parameters(['anggota' => 'anggota']);
        Route::get('/anggota/{anggota}/kartu', [AnggotaController::class, 'kartu'])->name('anggota.kartu');

        // transaksi
        Route::resource('peminjaman', PeminjamanController::class)->only(['index', 'create', 'store']);
        Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
        Route::post('/pengembalian/{peminjaman}/proses', [PengembalianController::class, 'proses'])->name('pengembalian.proses');
    });

    // ================= AREA ANGGOTA =================
    Route::prefix('anggota-area')->name('anggota_area.')->group(function () {
        Route::get('/kartu', [KartuController::class, 'index'])->name('kartu');

        Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');
    Route::post('/katalog/{buku}/pinjam', [KatalogController::class, 'pinjam'])->name('katalog.pinjam');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    });

});

/*
|--------------------------------------------------------------------------
| Redirect halaman awal ke /login
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});