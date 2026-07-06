<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('q');

        $anggota = Anggota::with('pengguna')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('id_anggota', 'like', "%{$keyword}%")
                      ->orWhereHas('pengguna', function ($q) use ($keyword) {
                          $q->where('nama_pengguna', 'like', "%{$keyword}%")
                            ->orWhere('email', 'like', "%{$keyword}%");
                      });
            })
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.anggota.index', compact('anggota', 'keyword'));
    }

    public function create()
    {
        return view('admin.anggota.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_anggota'   => 'required|string|max:6|unique:anggota,id_anggota',
            'nama'         => 'required|string|max:100',
            'username'     => 'required|string|max:50|unique:pengguna,username',
            'email'        => 'required|email|max:100|unique:pengguna,email',
            'password'     => 'required|string|min:6',
            'no_telepon'   => 'required|string|max:15',
            'alamat'       => 'required|string',
            'status'       => 'required|in:aktif,nonaktif',
        ]);

        // Buat id_pengguna otomatis
        $idPengguna = $this->generateIdPengguna();

        DB::transaction(function () use ($data, $idPengguna) {
            // 1. Buat akun pengguna dengan role anggota
            Pengguna::create([
                'id_pengguna'     => $idPengguna,
                'nama_pengguna'   => $data['nama'],
                'username'        => $data['username'],
                'password'        => Hash::make($data['password']),
                'role'            => 'anggota',
                'email'           => $data['email'],
                'no_telepon'      => $data['no_telepon'],
                'status_pengguna' => $data['status'],
            ]);

            // 2. Buat data keanggotaan
            Anggota::create([
                'id_anggota'     => $data['id_anggota'],
                'id_pengguna'    => $idPengguna,
                'alamat'         => $data['alamat'],
                'tanggal_daftar' => now(),
                'status_anggota' => $data['status'],
            ]);
        });

        return redirect()->route('admin.anggota.index')
            ->with('success', 'Anggota berhasil didaftarkan & Kartu Anggota Digital telah diterbitkan.');
    }

    public function edit(Anggota $anggota)
    {
        $anggota->load('pengguna');
        return view('admin.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $anggota->load('pengguna');
        $idPengguna = $anggota->id_pengguna;

        $data = $request->validate([
            'nama'       => 'required|string|max:100',
            'email'      => 'required|email|max:100|unique:pengguna,email,' . $idPengguna . ',id_pengguna',
            'no_telepon' => 'required|string|max:15',
            'alamat'     => 'required|string',
            'status'     => 'required|in:aktif,nonaktif',
        ]);

        DB::transaction(function () use ($data, $anggota) {
            $anggota->pengguna->update([
                'nama_pengguna'   => $data['nama'],
                'email'           => $data['email'],
                'no_telepon'      => $data['no_telepon'],
                'status_pengguna' => $data['status'],
            ]);

            $anggota->update([
                'alamat'         => $data['alamat'],
                'status_anggota' => $data['status'],
            ]);
        });

        return redirect()->route('admin.anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Anggota $anggota)
    {
        DB::transaction(function () use ($anggota) {
            $pengguna = $anggota->pengguna;
            $anggota->delete();
            if ($pengguna) {
                $pengguna->delete();
            }
        });

        return redirect()->route('admin.anggota.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }

    // Generate id_pengguna otomatis: PG0001, PG0002, ...
    private function generateIdPengguna()
    {
        $last = Pengguna::where('id_pengguna', 'like', 'PG%')
            ->orderBy('id_pengguna', 'desc')
            ->first();

        $nomor = $last ? ((int) substr($last->id_pengguna, 2)) + 1 : 1;
        return 'PG' . str_pad($nomor, 4, '0', STR_PAD_LEFT);
    }
}