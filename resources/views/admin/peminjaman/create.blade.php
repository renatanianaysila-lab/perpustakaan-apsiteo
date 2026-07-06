{{-- resources/views/admin/peminjaman/create.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Peminjaman - Sistem Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
<div class="flex min-h-screen">

    @include('admin.partials.sidebar', ['active' => 'peminjaman'])

    <main class="ml-64 flex-1 p-8">

        <div class="mb-6">
            <a href="{{ route('admin.peminjaman.index') }}" class="text-sm text-blue-700 hover:underline">&larr; Kembali ke Peminjaman</a>
            <h2 class="text-2xl font-bold text-slate-800 mt-2">Form Input Peminjaman</h2>
            <p class="text-sm text-slate-500">Catat peminjaman buku baru.</p>
        </div>

        @if($errors->any())
            <div class="mb-5 px-4 py-3 rounded-lg bg-red-50 text-red-700 text-sm border border-red-100">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-5 px-4 py-3 rounded-lg bg-red-50 text-red-700 text-sm border border-red-100">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Form --}}
            <div class="lg:col-span-2 bg-white rounded-xl p-6 shadow-sm border border-slate-100">
                <form method="POST" action="{{ route('admin.peminjaman.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Anggota</label>
                        <select name="id_anggota" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                            <option value="">-- Pilih Anggota --</option>
                            @foreach($anggota as $a)
                                <option value="{{ $a->id_anggota }}" @selected(old('id_anggota') == $a->id_anggota)>
                                    {{ $a->id_anggota }} - {{ $a->pengguna->nama_pengguna ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Buku</label>
                        <select name="id_buku" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                            <option value="">-- Pilih Buku --</option>
                            @foreach($buku as $b)
                                <option value="{{ $b->id_buku }}" @selected(old('id_buku') == $b->id_buku)>
                                    {{ $b->id_buku }} - {{ $b->judul_buku }} (stok: {{ $b->stok_tersedia }})
                                </option>
                            @endforeach
                        </select>
                        @if($buku->isEmpty())
                            <p class="text-xs text-red-500 mt-1">Tidak ada buku dengan stok tersedia.</p>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Pinjam</label>
                            <input type="text" value="{{ now()->format('d M Y') }}" disabled
                                   class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm bg-slate-100 text-slate-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Jatuh Tempo</label>
                            <input type="text" value="{{ now()->addDays(7)->format('d M Y') }}" disabled
                                   class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm bg-slate-100 text-slate-500">
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" class="px-5 py-2.5 bg-blue-900 hover:bg-blue-950 text-white text-sm font-medium rounded-lg transition">
                            Proses Peminjaman
                        </button>
                        <a href="{{ route('admin.peminjaman.index') }}" class="px-5 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-lg hover:bg-slate-50">Batal</a>
                    </div>
                </form>
            </div>

            {{-- Info aturan --}}
            <div class="bg-blue-50 rounded-xl p-6 border border-blue-100 h-fit">
                <div class="flex items-center gap-2 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <h3 class="font-semibold text-blue-900">Aturan Peminjaman</h3>
                </div>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li>&bull; Maksimal 3 buku per anggota.</li>
                    <li>&bull; Durasi peminjaman standar 7 hari.</li>
                    <li>&bull; Denda Rp 2.000/hari untuk keterlambatan.</li>
                    <li>&bull; Hanya anggota berstatus aktif yang dapat meminjam.</li>
                </ul>
            </div>

        </div>

    </main>
</div>
</body>
</html>