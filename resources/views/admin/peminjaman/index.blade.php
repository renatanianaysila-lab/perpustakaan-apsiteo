{{-- resources/views/admin/peminjaman/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Transaksi Peminjaman - Sistem Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
<div class="flex min-h-screen">

    @include('admin.partials.sidebar', ['active' => 'peminjaman'])

    <main class="ml-64 flex-1 p-8">

        {{-- Header --}}
        <div class="flex items-start justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Kelola Transaksi Peminjaman</h2>
                <p class="text-sm text-slate-500">Input data peminjaman buku baru dan monitoring sirkulasi aktif.</p>
            </div>
            <a href="{{ route('admin.peminjaman.create') }}"
               class="flex items-center gap-2 px-4 py-2.5 bg-blue-900 hover:bg-blue-950 text-white text-sm font-medium rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Peminjaman
            </a>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="mb-5 px-4 py-3 rounded-lg bg-emerald-50 text-emerald-700 text-sm border border-emerald-100">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-5 px-4 py-3 rounded-lg bg-red-50 text-red-700 text-sm border border-red-100">{{ session('error') }}</div>
        @endif

        {{-- Summary card --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-11 h-11 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Total Dipinjam</p>
                    <p class="text-xl font-bold text-slate-800">{{ $totalDipinjam }} Buku</p>
                </div>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-11 h-11 bg-cyan-100 text-cyan-600 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Menunggu Kembali</p>
                    <p class="text-xl font-bold text-slate-800">{{ $menungguKembali }} Transaksi</p>
                </div>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-11 h-11 bg-rose-100 text-rose-600 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Terlambat</p>
                    <p class="text-xl font-bold text-red-600">{{ $terlambat }} Buku</p>
                </div>
            </div>
        </div>

        {{-- Tabel peminjaman aktif --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800">Peminjaman Aktif</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-left">
                            <th class="px-6 py-3 font-medium">Nama Anggota</th>
                            <th class="px-6 py-3 font-medium">Judul Buku</th>
                            <th class="px-6 py-3 font-medium">Tgl Pinjam</th>
                            <th class="px-6 py-3 font-medium">Jatuh Tempo</th>
                            <th class="px-6 py-3 font-medium text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjaman as $item)
                            @php
                                $nama = $item->anggota->pengguna->nama_pengguna ?? '-';
                                $terlambatRow = \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->isPast();
                            @endphp
                            <tr class="border-t border-slate-100 hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-800">{{ $nama }}</p>
                                    <p class="text-xs text-slate-400">{{ $item->id_anggota }}</p>
                                </td>
                                <td class="px-6 py-4 text-slate-600">{{ $item->buku->judul_buku ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                                <td class="px-6 py-4 font-medium {{ $terlambatRow ? 'text-red-600' : 'text-slate-700' }}">
                                    {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($terlambatRow)
                                        <span class="px-2.5 py-1 text-xs font-medium bg-red-50 text-red-600 rounded-full">Terlambat</span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-medium bg-cyan-50 text-cyan-700 rounded-full">Dipinjam</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-400">Belum ada peminjaman aktif.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100">
                <p class="text-sm text-slate-500">
                    Menampilkan {{ $peminjaman->firstItem() ?? 0 }} - {{ $peminjaman->lastItem() ?? 0 }} dari {{ $peminjaman->total() }} transaksi aktif
                </p>
                <div>{{ $peminjaman->links() }}</div>
            </div>
        </div>

    </main>
</div>
</body>
</html>