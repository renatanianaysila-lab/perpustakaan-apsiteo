{{-- resources/views/admin/kategori/create.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori - Sistem Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
<div class="flex min-h-screen">

    @include('admin.partials.sidebar', ['active' => 'kategori'])

    <main class="ml-64 flex-1 p-8">

        <div class="mb-6">
            <a href="{{ route('admin.kategori.index') }}" class="text-sm text-blue-700 hover:underline">&larr; Kembali ke Kategori</a>
            <h2 class="text-2xl font-bold text-slate-800 mt-2">Tambah Kategori Baru</h2>
            <p class="text-sm text-slate-500">Lengkapi data kategori di bawah ini.</p>
        </div>

        @if($errors->any())
            <div class="mb-5 px-4 py-3 rounded-lg bg-red-50 text-red-700 text-sm border border-red-100">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 max-w-2xl">
            <form method="POST" action="{{ route('admin.kategori.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kode Kategori</label>
                    <input type="text" name="id_kategori" value="{{ old('id_kategori') }}" placeholder="KT-001"
                           class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    <p class="text-xs text-slate-400 mt-1">Maksimal 6 karakter, harus unik.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kategori</label>
                    <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" placeholder="Teknologi"
                           class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" placeholder="Deskripsi singkat kategori..."
                              class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-blue-900 hover:bg-blue-950 text-white text-sm font-medium rounded-lg transition">Simpan</button>
                    <a href="{{ route('admin.kategori.index') }}" class="px-5 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50">Batal</a>
                </div>
            </form>
        </div>

    </main>
</div>
</body>
</html>