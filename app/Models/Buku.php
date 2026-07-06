<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_buku', 'id_kategori', 'id_rak', 'id_pengguna',
        'judul_buku', 'pengarang', 'penerbit', 'tahun_terbit',
        'stok_buku', 'stok_tersedia', 'status_buku',
    ];

    // ▼▼▼ TARUH DI SINI ▼▼▼
    public function getRouteKeyName()
    {
        return 'id_buku';
    }
    // ▲▲▲ ▲▲▲

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class, 'id_rak', 'id_rak');
    }
}