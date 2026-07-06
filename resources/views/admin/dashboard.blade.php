<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body class="bg-slate-50">

    <div class="flex min-h-screen">

        {{-- ================= SIDEBAR ================= --}}
        <aside class="w-64 bg-blue-950 text-white flex flex-col justify-between fixed h-screen">
            <div>
                {{-- Brand --}}
                <div class="px-6 py-6 border-b border-blue-900">
                    <h1 class="text-lg font-bold">Admin Perpustakaan</h1>
                    <p class="text-xs text-blue-300">Manajemen Sistem</p>
                </div>

                {{-- Menu --}}
                <nav class="mt-4 space-y-1 px-3">
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-cyan-500/20 text-cyan-300 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.buku.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-blue-200 hover:bg-blue-900 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                        Data Buku
                    </a>

                    <a href="{{ route('admin.kategori.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-blue-200 hover:bg-blue-900 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 012.25-2.25h7.5A2.25 2.25 0 0118 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 004.5 9v.878m13.5-3A2.25 2.25 0 0119.5 9v.878m0 0a2.246 2.246 0 00-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0121 12v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6c0-.98.626-1.813 1.5-2.122" />
                        </svg>
                        Kategori
                    </a>

                    <a href="{{ route('admin.rak.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-blue-200 hover:bg-blue-900 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                        Rak
                    </a>

                    <a href="{{ route('admin.anggota.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-blue-200 hover:bg-blue-900 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                        Anggota
                    </a>

                    <a href="{{ route('admin.peminjaman.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-blue-200 hover:bg-blue-900 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        Transaksi Peminjaman
                    </a>

                    <a href="{{ route('admin.pengembalian.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-blue-200 hover:bg-blue-900 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.098 4.02 8.25 4.982 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                        Pengembalian
                    </a>
                </nav>
            </div>

            {{-- Profile --}}
            <div class="px-4 py-4 border-t border-blue-900 flex items-center gap-3">
                <img src="{{ auth()->user()->foto ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nama_pengguna ?? 'Admin') }}"
                     class="w-9 h-9 rounded-full object-cover" alt="Foto Admin">
                <div>
                    <p class="text-sm font-medium">{{ auth()->user()->nama_pengguna ?? 'Admin Utama' }}</p>
                    <p class="text-xs text-blue-300">{{ auth()->user()->role ?? 'Administrator' }}</p>
                </div>
            </div>
        </aside>

        {{-- ================= MAIN CONTENT ================= --}}
        <main class="ml-64 flex-1 p-8">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">Ringkasan Dashboard</h2>
                    <p class="text-sm text-slate-500">Pantau aktivitas perpustakaan hari ini secara real-time.</p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-800 text-sm font-medium rounded-lg border border-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                    </button>
                    <a href="{{ route('admin.peminjaman.create') }}"
                       class="flex items-center gap-2 px-4 py-2 bg-blue-900 hover:bg-blue-950 text-white text-sm font-medium rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Transaksi
                    </a>
                </div>
            </div>

            {{-- ===== Summary Cards ===== --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">

                {{-- Total Buku --}}
                <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 bg-cyan-100 text-cyan-600 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                            +{{ $persenBukuBaru ?? 12 }}%
                        </span>
                    </div>
                    <p class="text-sm text-slate-500">Total Buku</p>
                    <p class="text-2xl font-bold text-slate-800">{{ number_format($totalBuku ?? 12458) }}</p>
                </div>

                {{-- Anggota Aktif --}}
                <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                            +{{ $persenAnggotaBaru ?? 4 }}%
                        </span>
                    </div>
                    <p class="text-sm text-slate-500">Anggota Aktif</p>
                    <p class="text-2xl font-bold text-slate-800">{{ number_format($anggotaAktif ?? 3210) }}</p>
                </div>

                {{-- Buku Dipinjam --}}
                <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-red-500 bg-red-50 px-2 py-0.5 rounded-full">
                            {{ $persenBukuDipinjam ?? -2 }}%
                        </span>
                    </div>
                    <p class="text-sm text-slate-500">Buku Dipinjam</p>
                    <p class="text-2xl font-bold text-slate-800">{{ number_format($bukuDipinjam ?? 845) }}</p>
                </div>

                {{-- Denda Belum Lunas --}}
                <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 bg-rose-100 text-rose-600 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">Total</span>
                    </div>
                    <p class="text-sm text-slate-500">Denda Belum Lunas</p>
                    <p class="text-2xl font-bold text-slate-800">Rp {{ $dendaBelumLunas ?? '2.4jt' }}</p>
                </div>
            </div>

            {{-- ===== Grafik & Aktivitas ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

                {{-- Grafik Tren Peminjaman --}}
                <div class="lg:col-span-2 bg-white rounded-xl p-6 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-slate-800">Tren Peminjaman Mingguan</h3>
                        <select class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 text-slate-600">
                            <option>7 Hari Terakhir</option>
                            <option>30 Hari Terakhir</option>
                        </select>
                    </div>
                    <canvas id="chartPeminjaman" height="110"></canvas>
                </div>

                {{-- Aktivitas Terakhir --}}
                <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
                    <h3 class="font-semibold text-slate-800 mb-4">Aktivitas Terakhir</h3>
                    <ul class="space-y-4">
                        @forelse(($aktivitas ?? []) as $item)
                            <li class="flex gap-3">
                                <span class="mt-1.5 w-2 h-2 rounded-full flex-shrink-0 {{ $item['warna'] === 'merah' ? 'bg-red-500' : 'bg-blue-600' }}"></span>
                                <div>
                                    <p class="text-sm text-slate-700 font-medium">{{ $item['teks'] }}</p>
                                    <p class="text-xs text-slate-400">{{ $item['waktu'] }}</p>
                                </div>
                            </li>
                        @empty
                            {{-- Data contoh (hapus setelah terhubung ke database) --}}
                            <li class="flex gap-3">
                                <span class="mt-1.5 w-2 h-2 rounded-full bg-blue-600 flex-shrink-0"></span>
                                <div>
                                    <p class="text-sm text-slate-700 font-medium">Budi Santoso meminjam "Pemrograman Python"</p>
                                    <p class="text-xs text-slate-400">2 menit yang lalu</p>
                                </div>
                            </li>
                            <li class="flex gap-3">
                                <span class="mt-1.5 w-2 h-2 rounded-full bg-blue-600 flex-shrink-0"></span>
                                <div>
                                    <p class="text-sm text-slate-700 font-medium">Siti Aminah mengembalikan 2 buku</p>
                                    <p class="text-xs text-slate-400">15 menit yang lalu</p>
                                </div>
                            </li>
                            <li class="flex gap-3">
                                <span class="mt-1.5 w-2 h-2 rounded-full bg-red-500 flex-shrink-0"></span>
                                <div>
                                    <p class="text-sm text-slate-700 font-medium">Denda Terbayar: Rp 50.000 oleh Andi</p>
                                    <p class="text-xs text-slate-400">1 jam yang lalu</p>
                                </div>
                            </li>
                            <li class="flex gap-3">
                                <span class="mt-1.5 w-2 h-2 rounded-full bg-blue-600 flex-shrink-0"></span>
                                <div>
                                    <p class="text-sm text-slate-700 font-medium">Pendaftaran anggota baru: Rina Wijaya</p>
                                    <p class="text-xs text-slate-400">3 jam yang lalu</p>
                                </div>
                            </li>
                        @endforelse
                    </ul>
                    <a href="#" class="block text-center text-sm text-blue-700 font-medium mt-5 hover:underline">
                        Lihat Semua Aktivitas
                    </a>
                </div>
            </div>

            {{-- ===== Tabel Peminjaman Terbaru ===== --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-100">
                <div class="flex items-center justify-between px-6 py-5">
                    <h3 class="font-semibold text-slate-800">Peminjaman Terbaru</h3>
                    <a href="{{ route('admin.peminjaman.index') }}" class="text-sm text-blue-700 font-medium hover:underline">
                        Kelola Semua &rarr;
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-400 border-t border-slate-100">
                                <th class="px-6 py-3 font-medium">Nama Anggota</th>
                                <th class="px-6 py-3 font-medium">Judul Buku</th>
                                <th class="px-6 py-3 font-medium">Tanggal Pinjam</th>
                                <th class="px-6 py-3 font-medium">Jatuh Tempo</th>
                                <th class="px-6 py-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($peminjamanTerbaru ?? []) as $row)
                                <tr class="border-t border-slate-100">
                                    <td class="px-6 py-4 flex items-center gap-2">
                                        <span class="w-7 h-7 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold flex items-center justify-center">
                                            {{ $row['inisial'] }}
                                        </span>
                                        {{ $row['nama'] }}
                                    </td>
                                    <td class="px-6 py-4">{{ $row['judul_buku'] }}</td>
                                    <td class="px-6 py-4">{{ $row['tanggal_pinjam'] }}</td>
                                    <td class="px-6 py-4">{{ $row['jatuh_tempo'] }}</td>
                                    <td class="px-6 py-4">
                                        @if($row['status'] === 'Terlambat')
                                            <span class="px-2.5 py-1 text-xs font-medium bg-red-50 text-red-600 rounded-full">Terlambat</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-medium bg-cyan-50 text-cyan-600 rounded-full">Dipinjam</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                {{-- Data contoh (hapus setelah terhubung ke database) --}}
                                <tr class="border-t border-slate-100">
                                    <td class="px-6 py-4 flex items-center gap-2">
                                        <span class="w-7 h-7 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold flex items-center justify-center">JS</span>
                                        Joko Susilo
                                    </td>
                                    <td class="px-6 py-4">Arsitektur Modern Asia</td>
                                    <td class="px-6 py-4">20 Feb 2024</td>
                                    <td class="px-6 py-4">27 Feb 2024</td>
                                    <td class="px-6 py-4"><span class="px-2.5 py-1 text-xs font-medium bg-cyan-50 text-cyan-600 rounded-full">Dipinjam</span></td>
                                </tr>
                                <tr class="border-t border-slate-100">
                                    <td class="px-6 py-4 flex items-center gap-2">
                                        <span class="w-7 h-7 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold flex items-center justify-center">RA</span>
                                        Riana Ayu
                                    </td>
                                    <td class="px-6 py-4">Psikologi Pendidikan</td>
                                    <td class="px-6 py-4">19 Feb 2024</td>
                                    <td class="px-6 py-4">26 Feb 2024</td>
                                    <td class="px-6 py-4"><span class="px-2.5 py-1 text-xs font-medium bg-cyan-50 text-cyan-600 rounded-full">Dipinjam</span></td>
                                </tr>
                                <tr class="border-t border-slate-100">
                                    <td class="px-6 py-4 flex items-center gap-2">
                                        <span class="w-7 h-7 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold flex items-center justify-center">AD</span>
                                        Ahmad Dahlan
                                    </td>
                                    <td class="px-6 py-4">Ekonomi Makro Terapan</td>
                                    <td class="px-6 py-4">10 Feb 2024</td>
                                    <td class="px-6 py-4">17 Feb 2024</td>
                                    <td class="px-6 py-4"><span class="px-2.5 py-1 text-xs font-medium bg-red-50 text-red-600 rounded-full">Terlambat</span></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <script>
        // Grafik Tren Peminjaman Mingguan
        const ctx = document.getElementById('chartPeminjaman').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labelHari ?? ['Sen','Sel','Rab','Kam','Jum','Sab','Min']) !!},
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: {!! json_encode($dataPeminjaman ?? [12, 19, 14, 25, 18, 9, 15]) !!},
                    borderColor: '#1e3a8a',
                    backgroundColor: 'rgba(30, 58, 138, 0.08)',
                    tension: 0.35,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#1e3a8a'
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</body>
</html>