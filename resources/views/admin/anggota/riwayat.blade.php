{{-- resources/views/anggota/riwayat.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Aktivitas Pribadi - Sistem Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">

    {{-- NAVBAR --}}
    <nav class="bg-white border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-6 flex items-center justify-between h-16">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                <span class="font-bold text-slate-800">Sistem Perpustakaan</span>
            </div>
            <div class="flex items-center gap-6 text-sm">
                <a href="#" class="text-slate-500 hover:text-slate-800">Beranda</a>
                <a href="{{ route('anggota_area.katalog') }}" class="text-slate-500 hover:text-slate-800">Katalog</a>
                <a href="{{ route('anggota_area.kartu') }}" class="text-slate-500 hover:text-slate-800">Kartu Anggota</a>
                <a href="{{ route('anggota_area.riwayat') }}" class="text-blue-900 font-semibold border-b-2 border-blue-900 pb-1">Riwayat</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-slate-500 hover:text-red-600">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-10">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-blue-900">Laporan Aktivitas Pribadi</h1>
            <p class="text-sm text-slate-500 mt-1">Pantau riwayat peminjaman dan status keanggotaan Anda secara real-time.</p>
        </div>

        {{-- Summary --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-11 h-11 bg-blue-100 text-blue-700 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Total Buku Dipinjam</p>
                    <p class="text-xl font-bold text-slate-800">{{ $totalDipinjam }} Eksemplar</p>
                </div>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-11 h-11 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Sedang Dipinjam</p>
                    <p class="text-xl font-bold text-slate-800">{{ $sedangDipinjam }} Aktif</p>
                </div>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
                <div class="w-11 h-11 bg-rose-100 text-rose-600 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Total Denda Belum Lunas</p>
                    <p class="text-xl font-bold text-rose-600">Rp {{ number_format($dendaBelumLunas, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Tabel riwayat --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-left">
                            <th class="px-4 py-3 font-medium">Judul Buku</th>
                            <th class="px-4 py-3 font-medium">Tanggal Pinjam</th>
                            <th class="px-4 py-3 font-medium">Jatuh Tempo</th>
                            <th class="px-4 py-3 font-medium text-center">Status</th>
                            <th class="px-4 py-3 font-medium text-right">Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $item)
                            @php
                                $denda = $item->pengembalian->denda ?? null;
                                $nominalDenda = $denda->total_denda ?? 0;
                                $jatuhTempo = \Carbon\Carbon::parse($item->tanggal_jatuh_tempo);
                                $telat = $item->status_pinjam === 'dipinjam' && \Carbon\Carbon::today()->gt($jatuhTempo);
                            @endphp
                            <tr class="border-t border-slate-100 hover:bg-slate-50">
                                <td class="px-4 py-4 font-semibold text-slate-800">{{ $item->buku->judul_buku ?? '-' }}</td>
                                <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d M Y') }}</td>
                                <td class="px-4 py-4 text-slate-600 whitespace-nowrap">{{ $jatuhTempo->translatedFormat('d M Y') }}</td>
                                <td class="px-4 py-4 text-center">
                                    @if($item->status_pinjam === 'dikembalikan')
                                        <span class="px-2.5 py-1 text-xs font-medium bg-emerald-50 text-emerald-600 rounded-full">Dikembalikan</span>
                                    @elseif($telat)
                                        <span class="px-2.5 py-1 text-xs font-medium bg-red-50 text-red-600 rounded-full">Terlambat</span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-medium bg-cyan-50 text-cyan-600 rounded-full">Dipinjam</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-right font-medium {{ $nominalDenda > 0 ? 'text-red-600' : 'text-slate-400' }}">
                                    {{ $nominalDenda > 0 ? 'Rp ' . number_format($nominalDenda, 0, ',', '.') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-slate-400">Belum ada riwayat aktivitas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100">
                <p class="text-sm text-slate-500">
                    Menampilkan {{ $riwayat->firstItem() ?? 0 }} - {{ $riwayat->lastItem() ?? 0 }} dari {{ $riwayat->total() }} riwayat
                </p>
                <div>{{ $riwayat->links() }}</div>
            </div>
        </div>

        {{-- Info peminjaman --}}
        <div class="mt-6 bg-white rounded-xl p-6 shadow-sm border border-slate-100 max-w-xl">
            <h3 class="font-semibold text-slate-800 mb-3">Informasi Peminjaman</h3>
            <ul class="text-sm text-slate-600 space-y-2">
                <li>&bull; Batas maksimal peminjaman adalah 3 buku sekaligus.</li>
                <li>&bull; Durasi peminjaman standar adalah 7 hari kalender.</li>
                <li>&bull; Denda keterlambatan sebesar Rp 2.000 / hari / buku.</li>
            </ul>
        </div>

    </main>
</body>
</html>