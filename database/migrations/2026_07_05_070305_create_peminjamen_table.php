<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->string('id_pinjam', 6)->primary();
            $table->string('id_pengguna', 6);
            $table->string('id_buku', 6);
            $table->string('id_anggota', 6);
            $table->string('id_kembali', 6)->nullable();
            $table->date('tanggal_pinjam');
            $table->date('tanggal_jatuh_tempo');
            $table->string('status_pinjam')->default('dipinjam');
            $table->timestamps();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna');
            $table->foreign('id_buku')->references('id_buku')->on('buku');
            $table->foreign('id_anggota')->references('id_anggota')->on('anggota');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};