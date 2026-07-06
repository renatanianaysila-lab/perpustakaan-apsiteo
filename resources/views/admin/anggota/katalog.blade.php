{{-- resources/views/anggota/katalog.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku Digital - Sistem Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">

    {{-- NAVBAR --}}
    <nav class="bg-blue-950 text-white">
        <div class="max-w-6xl mx-auto px-6 flex items-center justify-between h-16">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-cyan-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                <span class="font-bold">Sistem Perpustakaan</span>
            </div>
            <div class="flex items-center gap-6 text-sm">
                <a href="#" class="text-blue-200 hover:text-white">Beranda</a>
                <a href="{{ route('anggota_area.katalog') }}" class="text-white font-semibold border-b-2 border-cyan-300 pb-1">Katalog</a>
                <a href="{{ route('anggota_area.kartu') }}" class="text-blue-200 hover:text-white">Kartu Anggota</a>
                <a href="#" class="text-blue-200 hover:text-white">Riwayat</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-blue-200 hover:text-red-300">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-10">

        {{-- Header --}}
        <div class="flex items-end justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-blue-900">Katalog Buku Digital</h1>
                <p class="text-sm text-slate-500 mt-1">Telusuri koleksi buku terbaru kami dari referensi akademik hingga karya fiksi populer.</p>
            </div>
            <span class="text-sm bg-blue-100 text-blue-800 px-3 py-1.5 rounded-full font-medium">{{ $totalBuku }} Buku Tersedia</span>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="mb-5 px-4 py-3 rounded-lg bg-emerald-50 text-emerald-700 text-sm border border-emerald-100">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-5 px-4 py-3 rounded-lg bg-red-50 text-red-700 text-sm border border-red-100">{{ session('error') }}</div>
        @endif

        {{-- Pencarian + filter --}}
        <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100 mb-6">
            <form method="GET" action="{{ route('anggota_area.katalog') }}" class="flex flex-col md:flex-row items-center gap-3">
                <div class="relative flex-1 w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input type="text" name="q" value="{{ $keyword ?? '' }}" placeholder="Cari judul atau pengarang..."
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>
                <select name="kategori" class="w-full md:w-52 px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id_kategori }}" @selected($kategoriId == $k->id_kategori)>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
                <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-blue-900 text-white text-sm font-medium rounded-lg hover:bg-blue-950 transition">Cari</button>
            </form>
        </div>

        {{-- Grid kartu buku --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($buku as $item)
                <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                    {{-- cover placeholder --}}
                    <div class="h-40 bg-gradient-to-br from-blue-900 to-blue-700 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <p class="text-xs text-cyan-600 font-semibold uppercase mb-1">{{ $item->kategori->nama_kategori ?? 'Umum' }}</p>
                        <h3 class="font-bold text-slate-800 leading-snug mb-1">{{ $item->judul_buku }}</h3>
                        <p class="text-sm text-slate-500 mb-3">{{ $item->pengarang }}</p>

                        <div class="mt-auto flex items-center justify-between">
                            @if($item->stok_tersedia > 0)
                                <span class="text-xs font-medium bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-full">Tersedia</span>
                                <form method="POST" action="{{ route('anggota_area.katalog.pinjam', $item->id_buku) }}"
                                      onsubmit="return confirm('Pinjam buku &quot;{{ $item->judul_buku }}&quot;?')">
                                    @csrf
                                    <button type="submit" class="px-4 py-1.5 bg-blue-900 hover:bg-blue-950 text-white text-xs font-medium rounded-lg transition">Pinjam</button>
                                </form>
                            @else
                                <span class="text-xs font-medium bg-slate-100 text-slate-500 px-2.5 py-1 rounded-full">Dipinjam</span>
                                <button disabled class="px-4 py-1.5 bg-slate-200 text-slate-400 text-xs font-medium rounded-lg cursor-not-allowed">Antre</button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-slate-400">Tidak ada buku ditemukan.</div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-8">{{ $buku->links() }}</div>

    </main>
</body>
</html>