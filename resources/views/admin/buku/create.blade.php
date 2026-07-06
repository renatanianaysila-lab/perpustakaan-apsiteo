{{-- resources/views/admin/buku/create.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - Sistem Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
<div class="flex min-h-screen">

    @include('admin.partials.sidebar', ['active' => 'buku'])

    <main class="ml-64 flex-1 p-8">

        <div class="mb-6">
            <a href="{{ route('admin.buku.index') }}" class="text-sm text-blue-700 hover:underline">&larr; Kembali ke Data Buku</a>
            <h2 class="text-2xl font-bold text-slate-800 mt-2">Tambah Buku Baru</h2>
            <p class="text-sm text-slate-500">Lengkapi data buku di bawah ini.</p>
        </div>

        {{-- Error validasi --}}
        @if($errors->any())
            <div class="mb-5 px-4 py-3 rounded-lg bg-red-50 text-red-700 text-sm border border-red-100">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 max-w-3xl">
            <form method="POST" action="{{ route('admin.buku.store') }}" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kode Buku</label>
                        <input type="text" name="id_buku" value="{{ old('id_buku') }}" placeholder="BK-001"
                               class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                        <p class="text-xs text-slate-400 mt-1">Maksimal 6 karakter, harus unik.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" placeholder="2024"
                               class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Judul Buku</label>
                    <input type="text" name="judul_buku" value="{{ old('judul_buku') }}"
                           class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Pengarang</label>
                        <input type="text" name="pengarang" value="{{ old('pengarang') }}"
                               class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Penerbit</label>
                        <input type="text" name="penerbit" value="{{ old('penerbit') }}"
                               class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                        <select name="id_kategori" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                            <option value="">-- Pilih --</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id_kategori }}" @selected(old('id_kategori') == $k->id_kategori)>{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Rak</label>
                        <select name="id_rak" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                            <option value="">-- Pilih --</option>
                            @foreach($rak as $r)
                                <option value="{{ $r->id_rak }}" @selected(old('id_rak') == $r->id_rak)>{{ $r->nama_rak }} ({{ $r->lokasi_rak }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Stok</label>
                        <input type="number" name="stok_buku" value="{{ old('stok_buku', 1) }}" min="0"
                               class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-blue-900 hover:bg-blue-950 text-white text-sm font-medium rounded-lg transition">
                        Simpan
                    </button>
                    <a href="{{ route('admin.buku.index') }}" class="px-5 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50">
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </main>
</div>
</body>
</html>