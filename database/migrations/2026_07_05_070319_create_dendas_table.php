<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('denda', function (Blueprint $table) {
            $table->string('id_denda', 6)->primary();
            $table->string('id_pengguna', 6);
            $table->string('id_kembali', 6);
            $table->integer('jumlah_hari_terlambat');
            $table->decimal('tarif_per_hari', 10, 2);
            $table->decimal('total_denda', 10, 2);
            $table->text('alasan_denda')->nullable();
            $table->string('status_bayar')->default('belum lunas');
            $table->date('tanggal_bayar')->nullable();
            $table->timestamps();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna');
            $table->foreign('id_kembali')->references('id_kembali')->on('pengembalian');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('denda');
    }
};