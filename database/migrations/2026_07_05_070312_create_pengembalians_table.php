<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->string('id_kembali', 6)->primary();
            $table->string('id_pinjam', 6);
            $table->string('id_pengguna', 6);
            $table->string('id_denda', 6)->nullable();
            $table->date('tanggal_kembali');
            $table->text('kondisi_buku')->nullable();
            $table->string('status_kembali')->default('dikembalikan');
            $table->timestamps();

            $table->foreign('id_pinjam')->references('id_pinjam')->on('peminjaman');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};