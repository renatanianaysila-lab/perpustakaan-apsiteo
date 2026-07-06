<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->string('id_anggota', 6)->primary();
            $table->string('id_pengguna', 6);
            $table->string('alamat', 100)->nullable();
            $table->date('tanggal_daftar');
            $table->string('status_anggota')->default('aktif');
            $table->timestamps();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};