<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('q');

        $buku = Buku::with(['kategori', 'rak'])
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('id_buku', 'like', "%{$keyword}%")
                      ->orWhere('judul_buku', 'like', "%{$keyword}%")
                      ->orWhere('pengarang', 'like', "%{$keyword}%");
            })
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.buku.index', compact('buku', 'keyword'));
    }

    public function create()
    {
        return view('admin.buku.create', [
            'kategori' => Kategori::orderBy('nama_kategori')->get(),
            'rak'      => Rak::orderBy('nama_rak')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_buku'      => 'required|string|max:6|unique:buku,id_buku',
            'judul_buku'   => 'required|string|max:150',
            'pengarang'    => 'required|string|max:100',
            'penerbit'     => 'required|string|max:100',
            'tahun_terbit' => 'required|digits:4',
            'id_kategori'  => 'required|exists:kategori,id_kategori',
            'id_rak'       => 'required|exists:rak,id_rak',
            'stok_buku'    => 'required|integer|min:0',
        ]);

        $data['id_pengguna']  = Auth::user()->id_pengguna;
        $data['stok_tersedia'] = $data['stok_buku'];
        $data['status_buku']   = $data['stok_buku'] > 0 ? 'tersedia' : 'kosong';

        Buku::create($data);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Data buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        return view('admin.buku.edit', [
            'buku'     => $buku,
            'kategori' => Kategori::orderBy('nama_kategori')->get(),
            'rak'      => Rak::orderBy('nama_rak')->get(),
        ]);
    }

    public function update(Request $request, Buku $buku)
    {
        $data = $request->validate([
            'judul_buku'   => 'required|string|max:150',
            'pengarang'    => 'required|string|max:100',
            'penerbit'     => 'required|string|max:100',
            'tahun_terbit' => 'required|digits:4',
            'id_kategori'  => 'required|exists:kategori,id_kategori',
            'id_rak'       => 'required|exists:rak,id_rak',
            'stok_buku'    => 'required|integer|min:0',
        ]);

        // jaga stok_tersedia agar tidak melebihi stok baru
        $terpinjam = $buku->stok_buku - $buku->stok_tersedia;
        $data['stok_tersedia'] = max(0, $data['stok_buku'] - $terpinjam);
        $data['status_buku']   = $data['stok_tersedia'] > 0 ? 'tersedia' : 'kosong';

        $buku->update($data);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()->route('admin.buku.index')
            ->with('success', 'Data buku berhasil dihapus.');
    }
}