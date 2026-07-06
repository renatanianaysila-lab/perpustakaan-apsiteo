<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_pinjam';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pinjam', 'id_pengguna', 'id_buku', 'id_anggota',
        'id_kembali', 'tanggal_pinjam', 'tanggal_jatuh_tempo', 'status_pinjam',
    ];

    public function getRouteKeyName()
    {
        return 'id_pinjam';
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'id_pinjam', 'id_pinjam');
    }
}