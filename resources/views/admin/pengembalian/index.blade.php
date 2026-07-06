{{-- resources/views/admin/pengembalian/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Transaksi Pengembalian - Sistem Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
<div class="flex min-h-screen">

    @include('admin.partials.sidebar', ['active' => 'pengembalian'])

    <main class="ml-64 flex-1 p-8">

        {{-- Header --}}
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-800">Kelola Transaksi Pengembalian</h2>
            <p class="text-sm text-slate-500">Proses pengembalian buku dan manajemen denda keterlambatan.</p>
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
                <div class="w-11 h-11 bg-cyan-100 text-cyan-600 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Pengembalian Hari Ini</p>
                    <p class="text-xl font-bold text-slate-800">{{ $transaksiHariIni }} Transaksi</p>
                </div>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-11 h-11 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Denda Terkumpul (Bulan Ini)</p>
                    <p class="text-xl font-bold text-slate-800">Rp {{ number_format($dendaBulanIni, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-11 h-11 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Pinjaman Aktif</p>
                    <p class="text-xl font-bold text-slate-800">{{ $pinjamanAktif->total() }} Buku</p>
                </div>
            </div>
        </div>

        {{-- Daftar Pinjaman Aktif --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800">Daftar Pinjaman Aktif</h3>
                <p class="text-xs text-slate-500">Klik "Proses Kembali" untuk memproses pengembalian. Denda dihitung otomatis jika terlambat (Rp 2.000/hari).</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-left">
                            <th class="px-4 py-3 font-medium">Anggota</th>
                            <th class="px-4 py-3 font-medium">Judul Buku</th>
                            <th class="px-4 py-3 font-medium">Tgl Pinjam</th>
                            <th class="px-4 py-3 font-medium">Jatuh Tempo</th>
                            <th class="px-4 py-3 font-medium text-center">Status</th>
                            <th class="px-4 py-3 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pinjamanAktif as $item)
                            @php
                                $jatuhTempo = \Carbon\Carbon::parse($item->tanggal_jatuh_tempo);
                                $telat = \Carbon\Carbon::today()->gt($jatuhTempo);
                                $hariTelat = $telat ? $jatuhTempo->diffInDays(\Carbon\Carbon::today()) : 0;
                            @endphp
                            <tr class="border-t border-slate-100 hover:bg-slate-50">
                                <td class="px-4 py-4 font-medium text-slate-800">{{ $item->anggota->pengguna->nama_pengguna ?? '-' }}</td>
                                <td class="px-4 py-4 text-slate-600">{{ $item->buku->judul_buku ?? '-' }}</td>
                                <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d M Y') }}</td>
                                <td class="px-4 py-4 whitespace-nowrap {{ $telat ? 'text-red-600 font-semibold' : 'text-slate-600' }}">
                                    {{ $jatuhTempo->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if($telat)
                                        <span class="px-2.5 py-1 text-xs font-medium bg-red-50 text-red-600 rounded-full">Terlambat {{ $hariTelat }} hari</span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-medium bg-cyan-50 text-cyan-600 rounded-full">Dipinjam</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <form method="POST" action="{{ route('admin.pengembalian.proses', $item->id_pinjam) }}"
                                          onsubmit="return confirm('Proses pengembalian buku &quot;{{ $item->buku->judul_buku ?? '' }}&quot;?{{ $telat ? ' Denda Rp ' . number_format($hariTelat * 2000, 0, ',', '.') . ' akan dikenakan.' : '' }}')">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium rounded-lg transition">
                                            Proses Kembali
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-400">Tidak ada pinjaman aktif saat ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100">
                <p class="text-sm text-slate-500">
                    Menampilkan {{ $pinjamanAktif->firstItem() ?? 0 }} - {{ $pinjamanAktif->lastItem() ?? 0 }} dari {{ $pinjamanAktif->total() }} pinjaman aktif
                </p>
                <div>{{ $pinjamanAktif->links() }}</div>
            </div>
        </div>

    </main>
</div>
</body>
</html>