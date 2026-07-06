{{-- resources/views/admin/anggota/edit.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota - Sistem Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
<div class="flex min-h-screen">

    @include('admin.partials.sidebar', ['active' => 'anggota'])

    <main class="ml-64 flex-1 p-8">

        <div class="mb-6">
            <a href="{{ route('admin.anggota.index') }}" class="text-sm text-blue-700 hover:underline">&larr; Kembali ke Anggota</a>
            <h2 class="text-2xl font-bold text-slate-800 mt-2">Edit Anggota</h2>
            <p class="text-sm text-slate-500">Perbarui data anggota <span class="font-medium">{{ $anggota->pengguna->nama_pengguna ?? '' }}</span>.</p>
        </div>

        @if($errors->any())
            <div class="mb-5 px-4 py-3 rounded-lg bg-red-50 text-red-700 text-sm border border-red-100">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100 max-w-3xl">
            <form method="POST" action="{{ route('admin.anggota.update', $anggota->id_anggota) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">ID Anggota</label>
                        <input type="text" value="{{ $anggota->id_anggota }}" disabled
                               class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm bg-slate-100 text-slate-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                            <option value="aktif" @selected(old('status', $anggota->status_anggota) === 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(old('status', $anggota->status_anggota) === 'nonaktif')>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $anggota->pengguna->nama_pengguna ?? '') }}"
                           class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Alamat</label>
                    <textarea name="alamat" rows="2"
                              class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">{{ old('alamat', $anggota->alamat) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $anggota->pengguna->email ?? '') }}"
                               class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">No. Telepon</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon', $anggota->pengguna->no_telepon ?? '') }}"
                               class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>
                </div>

                <p class="text-xs text-slate-400">Username &amp; password tidak dapat diubah dari halaman ini.</p>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-blue-900 hover:bg-blue-950 text-white text-sm font-medium rounded-lg transition">Perbarui</button>
                    <a href="{{ route('admin.anggota.index') }}" class="px-5 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50">Batal</a>
                </div>
            </form>
        </div>

    </main>
</div>
</body>
</html>