<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use Illuminate\Http\Request;

class RakController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('q');

        $rak = Rak::withCount('buku')
            ->when($keyword, fn($query) =>
                $query->where('nama_rak', 'like', "%{$keyword}%")
                      ->orWhere('lokasi_rak', 'like', "%{$keyword}%")
            )
            ->orderBy('nama_rak')
            ->paginate(10)
            ->withQueryString();

        // Statistik untuk summary card
        $totalRak = Rak::count();

        return view('admin.rak.index', compact('rak', 'keyword', 'totalRak'));
    }

    public function create()
    {
        return view('admin.rak.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_rak'     => 'required|string|max:6|unique:rak,id_rak',
            'nama_rak'   => 'required|string|max:100',
            'lokasi_rak' => 'required|string|max:100',
        ]);

        Rak::create($data);

        return redirect()->route('admin.rak.index')
            ->with('success', 'Rak berhasil ditambahkan.');
    }

    public function edit(Rak $rak)
    {
        return view('admin.rak.edit', compact('rak'));
    }

    public function update(Request $request, Rak $rak)
    {
        $data = $request->validate([
            'nama_rak'   => 'required|string|max:100',
            'lokasi_rak' => 'required|string|max:100',
        ]);

        $rak->update($data);

        return redirect()->route('admin.rak.index')
            ->with('success', 'Rak berhasil diperbarui.');
    }

    public function destroy(Rak $rak)
    {
        if ($rak->buku()->count() > 0) {
            return redirect()->route('admin.rak.index')
                ->with('error', 'Rak tidak dapat dihapus karena masih menyimpan buku.');
        }

        $rak->delete();

        return redirect()->route('admin.rak.index')
            ->with('success', 'Rak berhasil dihapus.');
    }
}