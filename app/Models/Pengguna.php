<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pengguna',
        'nama_pengguna',
        'username',
        'password',
        'role',
        'email',
        'no_telepon',
        'status_pengguna',
    ];

    protected $hidden = [
        'password',
    ];

    // Relasi: satu pengguna (admin) bisa input banyak buku
    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_pengguna');
    }

    // Relasi: satu pengguna (anggota) punya satu data anggota
    public function anggota()
    {
        return $this->hasOne(Anggota::class, 'id_pengguna');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_pengguna');
    }

    public function pengembalian()
    {
        return $this->hasMany(Pengembalian::class, 'id_pengguna');
    }

    public function denda()
    {
        return $this->hasMany(Denda::class, 'id_pengguna');
    }
}