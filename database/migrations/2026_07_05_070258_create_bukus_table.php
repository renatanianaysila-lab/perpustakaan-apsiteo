<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->string('id_buku', 6)->primary();
            $table->string('id_kategori', 6);
            $table->string('id_rak', 6);
            $table->string('id_pengguna', 6);
            $table->string('judul_buku', 150);
            $table->string('pengarang', 100);
            $table->string('penerbit', 100);
            $table->year('tahun_terbit');
            $table->integer('stok_buku');
            $table->integer('stok_tersedia');
            $table->string('status_buku')->default('tersedia');
            $table->timestamps();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori');
            $table->foreign('id_rak')->references('id_rak')->on('rak');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};