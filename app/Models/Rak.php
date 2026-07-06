<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    protected $table = 'rak';
    protected $primaryKey = 'id_rak';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_rak', 'nama_rak', 'lokasi_rak'];

    public function getRouteKeyName()
    {
        return 'id_rak';
    }

    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_rak', 'id_rak');
    }
}