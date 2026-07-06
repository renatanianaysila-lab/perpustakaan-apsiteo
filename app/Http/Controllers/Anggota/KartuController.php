<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Support\Facades\Auth;

class KartuController extends Controller
{
    public function index()
    {
        // Ambil data anggota berdasarkan user yang login
        $anggota = Anggota::with('pengguna')
            ->where('id_pengguna', Auth::user()->id_pengguna)
            ->first();

        if (!$anggota) {
            abort(403, 'Akun ini bukan anggota perpustakaan.');
        }

        return view('anggota.kartu', compact('anggota'));
    }
}