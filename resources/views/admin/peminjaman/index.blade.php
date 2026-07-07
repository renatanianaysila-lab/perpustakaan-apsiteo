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

        <div class="flex items-start justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Kelola Transaksi Peminjaman</h2>
                <p class="text-sm text-slate-500">Input data peminjaman buku baru dan monitoring sirkulasi aktif.</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                <p class="text-xs text-slate-400">{{ \Carbon\Carbon::now()->format('H:i') }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-5 px-4 py-3 rounded-lg bg-emerald-50 text-emerald-700 text-sm border border-emerald-100">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-5 px-4 py-3 rounded-lg bg-red-50 text-red-700 text-sm border border-red-100">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-11 h-11 bg-cyan-100 text-cyan-600 rounded-lg flex items-center justify-center">
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
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-11 h-11 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Peminjam Baru Hari Ini</p>
                    <p class="text-xl font-bold text-slate-800">{{ $peminjamBaruHariIni }} Transaksi</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
                    <h3 class="font-semibold text-slate-800 mb-4">Form Input Peminjaman</h3>
                    <form method="POST" action="{{ route('admin.peminjaman.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Anggota</label>
                            <select name="id_anggota" required class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                                <option value="">-- Pilih Anggota --</option>
                                @foreach($anggota as $a)
                                    <option value="{{ $a->id_anggota }}">{{ $a->id_anggota }} - {{ $a->pengguna->nama_pengguna ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Buku</label>
                            <select name="id_buku" required class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                                <option value="">-- Pilih Buku --</option>
                                @foreach($bukuTersedia as $b)
                                    <option value="{{ $b->id_buku }}">{{ $b->judul_buku }} (stok: {{ $b->stok_tersedia }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-3 text-xs text-slate-600 space-y-1">
                            <p>Tanggal pinjam otomatis hari ini.</p>
                            <p>Jatuh tempo 7 hari dari tanggal pinjam.</p>
                            <p>Maksimal 3 buku per anggota.</p>
                        </div>
                        <button type="submit" class="w-full px-4 py-2.5 bg-blue-900 hover:bg-blue-950 text-white text-sm font-medium rounded-lg transition">Proses Peminjaman</button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h3 class="font-semibold text-slate-800">Peminjaman Aktif Hari Ini</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 text-left">
                                    <th class="px-4 py-3 font-medium">Nama Anggota</th>
                                    <th class="px-4 py-3 font-medium">Judul Buku</th>
                                    <th class="px-4 py-3 font-medium">Tgl Pinjam</th>
                                    <th class="px-4 py-3 font-medium">Jatuh Tempo</th>
                                    <th class="px-4 py-3 font-medium text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjaman as $item)
                                    @php
                                        $jatuhTempo = \Carbon\Carbon::parse($item->tanggal_jatuh_tempo);
                                        $telat = \Carbon\Carbon::today()->gt($jatuhTempo);
                                    @endphp
                                    <tr class="border-t border-slate-100 hover:bg-slate-50">
                                        <td class="px-4 py-4 font-medium text-slate-800">{{ $item->anggota->pengguna->nama_pengguna ?? '-' }}</td>
                                        <td class="px-4 py-4 text-slate-600">{{ $item->buku->judul_buku ?? '-' }}</td>
                                        <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d M Y') }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap {{ $telat ? 'text-red-600 font-semibold' : 'text-slate-600' }}">{{ $jatuhTempo->translatedFormat('d M Y') }}</td>
                                        <td class="px-4 py-4 text-center">
                                            @if($telat)
                                                <span class="px-2.5 py-1 text-xs font-medium bg-red-50 text-red-600 rounded-full">Terlambat</span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-medium bg-cyan-50 text-cyan-600 rounded-full">Dipinjam</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-4 py-10 text-center text-slate-400">Belum ada peminjaman aktif.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100">
                        <p class="text-sm text-slate-500">Menampilkan {{ $peminjaman->firstItem() ?? 0 }} - {{ $peminjaman->lastItem() ?? 0 }} dari {{ $peminjaman->total() }} transaksi</p>
                        <div>{{ $peminjaman->links() }}</div>
                    </div>
                </div>
            </div>
        </div>

    </main>
</div>
</body>
</html>
