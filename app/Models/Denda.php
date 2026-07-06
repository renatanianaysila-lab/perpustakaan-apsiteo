<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $table = 'denda';
    protected $primaryKey = 'id_denda';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_denda', 'id_pengguna', 'id_kembali', 'jumlah_hari_terlambat',
        'tarif_per_hari', 'total_denda', 'alasan_denda', 'status_bayar', 'tanggal_bayar',
    ];
}