{{-- resources/views/admin/anggota/kartu.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Anggota Digital - Sistem Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
<div class="flex min-h-screen">

    @include('admin.partials.sidebar', ['active' => 'anggota'])

    <main class="ml-64 flex-1 p-8">

        <div class="mb-6">
            <a href="{{ route('admin.anggota.index') }}" class="text-sm text-blue-700 hover:underline">&larr; Kembali ke Anggota</a>
        </div>

        @if(session('success'))
            <div class="mb-5 px-4 py-3 rounded-lg bg-green-50 text-green-700 text-sm border border-green-100">
                {{ session('success') }}
            </div>
        @endif

        <div class="max-w-md mx-auto">
            <h2 class="text-xl font-bold text-slate-800 text-center mb-1">Identitas Digital</h2>
            <p class="text-sm text-slate-500 text-center mb-6">Gunakan kode QR di bawah untuk peminjaman mandiri dan akses masuk.</p>

            {{-- Kartu --}}
            <div class="bg-gradient-to-br from-blue-950 to-blue-900 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-2 text-sm font-medium">
                        <span>📚</span> PERPUSTAKAAN PUSAT
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full
                        {{ $anggota->status_anggota === 'aktif' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-slate-500/20 text-slate-300' }}">
                        ● {{ strtoupper($anggota->status_anggota) }}
                    </span>
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex-1">
                        <p class="text-xs text-blue-200 uppercase tracking-wide">Nama Lengkap</p>
                        <p class="text-lg font-semibold mb-3">{{ $anggota->pengguna->nama_pengguna }}</p>

                        <p class="text-xs text-blue-200 uppercase tracking-wide">Nomor Anggota</p>
                        <p class="text-sm font-mono mb-3">{{ $anggota->id_anggota }}</p>

                        <p class="text-xs text-blue-200 uppercase tracking-wide">Tanggal Daftar</p>
                        <p class="text-sm">{{ \Carbon\Carbon::parse($anggota->tanggal_daftar)->translatedFormat('d F Y') }}</p>
                    </div>

                    <div class="bg-white p-2 rounded-lg">
                        @if(class_exists(\SimpleSoftwareIO\QrCode\Facades\QrCode::class))
                            {!! QrCode::size(110)->generate($anggota->id_anggota) !!}
                        @else
                            <div class="w-[110px] h-[110px] flex items-center justify-center text-slate-400 text-xs text-center">
                                QR Code<br>belum diaktifkan
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-5">
                <button onclick="window.print()" class="flex-1 px-4 py-2.5 bg-blue-900 hover:bg-blue-950 text-white text-sm font-medium rounded-lg transition">
                    ⬇ Cetak / Simpan
                </button>
                <a href="{{ route('admin.anggota.index') }}" class="flex-1 text-center px-4 py-2.5 border border-slate-200 text-sm text-slate-600 rounded-lg hover:bg-slate-50">
                    Kembali
                </a>
            </div>

            <div class="mt-5 px-4 py-3 rounded-lg bg-blue-50 border border-blue-100 text-xs text-blue-700">
                <strong>Cara Penggunaan:</strong> Tunjukkan kode QR ini ke petugas perpustakaan atau pindai pada mesin peminjaman mandiri untuk melakukan transaksi buku.
            </div>
        </div>

    </main>
</div>
</body>
</html>