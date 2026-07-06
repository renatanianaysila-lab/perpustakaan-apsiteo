<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';
    protected $primaryKey = 'id_kembali';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_kembali', 'id_pinjam', 'id_pengguna', 'id_denda',
        'tanggal_kembali', 'kondisi_buku', 'status_kembali',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_pinjam', 'id_pinjam');
    }

    public function denda()
    {
        return $this->belongsTo(Denda::class, 'id_denda', 'id_denda');
    }
}