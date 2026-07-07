{{-- resources/views/admin/anggota/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Anggota - Sistem Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
<div class="flex min-h-screen">

    @include('admin.partials.sidebar', ['active' => 'anggota'])

    <main class="ml-64 flex-1 p-8">

        {{-- Header --}}
        <div class="flex items-start justify-between mb-6">
            <div>
                <p class="text-xs text-slate-400 mb-1">Manajemen / Anggota</p>
                <h2 class="text-2xl font-bold text-slate-800">Kelola Data Anggota</h2>
            </div>
            <a href="{{ route('admin.anggota.create') }}"
               class="flex items-center gap-2 px-4 py-2.5 bg-blue-900 hover:bg-blue-950 text-white text-sm font-medium rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Anggota
            </a>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="mb-5 px-4 py-3 rounded-lg bg-emerald-50 text-emerald-700 text-sm border border-emerald-100 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Pencarian --}}
        <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100 mb-6">
            <form method="GET" action="{{ route('admin.anggota.index') }}" class="flex items-center gap-3">
                <div class="relative flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input type="text" name="q" value="{{ $keyword ?? '' }}" placeholder="Cari nama, email, atau ID anggota..."
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>
                <button type="submit" class="px-5 py-2.5 bg-blue-900 text-white text-sm font-medium rounded-lg hover:bg-blue-950 transition">Cari</button>
                @if(!empty($keyword))
                    <a href="{{ route('admin.anggota.index') }}" class="px-4 py-2.5 text-sm text-slate-500 hover:text-slate-700">Reset</a>
                @endif
            </form>
        </div>

        {{-- Tabel --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-left">
                            <th class="px-4 py-3 font-medium">ID Anggota</th>
                            <th class="px-4 py-3 font-medium">Nama</th>
                            <th class="px-4 py-3 font-medium">Alamat</th>
                            <th class="px-4 py-3 font-medium">No. Telepon</th>
                            <th class="px-4 py-3 font-medium">Email</th>
                            <th class="px-4 py-3 font-medium text-center">Status</th>
                            <th class="px-4 py-3 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggota as $item)
                            @php
                                $nama = $item->pengguna->nama_pengguna ?? '-';
                                $inisial = collect(explode(' ', $nama))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
                            @endphp
                            <tr class="border-t border-slate-100 hover:bg-slate-50">
                                <td class="px-4 py-4 text-slate-500 whitespace-nowrap">{{ $item->id_anggota }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="w-8 h-8 rounded-full bg-cyan-100 text-cyan-700 text-xs font-semibold flex items-center justify-center flex-shrink-0">{{ $inisial }}</span>
                                        <span class="font-medium text-slate-800">{{ $nama }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-slate-600">{{ $item->alamat }}</td>
                                <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ $item->pengguna->no_telepon ?? '-' }}</td>
                                <td class="px-4 py-4 text-slate-600">{{ $item->pengguna->email ?? '-' }}</td>
                                <td class="px-4 py-4 text-center">
                                    @if($item->status_anggota === 'aktif')
                                        <span class="px-2.5 py-1 text-xs font-medium bg-emerald-50 text-emerald-600 rounded-full">Aktif</span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-medium bg-slate-100 text-slate-500 rounded-full">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('admin.anggota.edit', $item->id_anggota) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.anggota.destroy', $item->id_anggota) }}"
                                              onsubmit="return confirm('Yakin ingin menghapus anggota &quot;{{ $nama }}&quot;? Akun login-nya juga akan dihapus.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-slate-400">Tidak ada anggota ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100">
                <p class="text-sm text-slate-500">
                    Menampilkan {{ $anggota->firstItem() ?? 0 }} - {{ $anggota->lastItem() ?? 0 }} dari {{ $anggota->total() }} anggota
                </p>
                <div>{{ $anggota->links() }}</div>
            </div>
        </div>

    </main>
</div>
</body>
</html>