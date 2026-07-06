{{-- resources/views/admin/partials/sidebar.blade.php --}}
@php
    $active = $active ?? '';
    $u = auth()->user();

    $menu = [
        'dashboard' => [
            'route' => 'admin.dashboard', 'label' => 'Dashboard',
            'icon'  => 'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z',
        ],
        'buku' => [
            'route' => 'admin.buku.index', 'label' => 'Data Buku',
            'icon'  => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25',
        ],
        'kategori' => [
            'route' => 'admin.kategori.index', 'label' => 'Kategori',
            'icon'  => 'M6 6.878V6a2.25 2.25 0 012.25-2.25h7.5A2.25 2.25 0 0118 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 004.5 9v.878m13.5-3A2.25 2.25 0 0119.5 9v.878m0 0a2.246 2.246 0 00-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0121 12v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6c0-.98.626-1.813 1.5-2.122',
        ],
        'rak' => [
            'route' => 'admin.rak.index', 'label' => 'Rak',
            'icon'  => 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21',
        ],
        'anggota' => [
            'route' => 'admin.anggota.index', 'label' => 'Anggota',
            'icon'  => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z',
        ],
        'peminjaman' => [
            'route' => 'admin.peminjaman.index', 'label' => 'Transaksi Peminjaman',
            'icon'  => 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99',
        ],
        'pengembalian' => [
            'route' => 'admin.pengembalian.index', 'label' => 'Pengembalian',
            'icon'  => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.098 4.02 8.25 4.982 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z',
        ],
    ];
@endphp

<aside class="w-64 bg-blue-950 text-white flex flex-col justify-between fixed h-screen">
    <div>
        <div class="px-6 py-6 border-b border-blue-900">
            <h1 class="text-lg font-bold">Admin Perpustakaan</h1>
            <p class="text-xs text-blue-300">Manajemen Sistem</p>
        </div>

        <nav class="mt-4 space-y-1 px-3">
            @foreach($menu as $key => $m)
                <a href="{{ route($m['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition {{ $active === $key ? 'bg-cyan-500/20 text-cyan-300' : 'text-blue-200 hover:bg-blue-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $m['icon'] }}" />
                    </svg>
                    {{ $m['label'] }}
                </a>
            @endforeach
        </nav>
    </div>

    {{-- Profil + tombol keluar --}}
    <div class="px-4 py-4 border-t border-blue-900 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <img src="{{ $u->foto ?? 'https://ui-avatars.com/api/?name=' . urlencode($u->nama_pengguna ?? 'Admin') }}"
                 class="w-9 h-9 rounded-full object-cover" alt="Foto Admin">
            <div>
                <p class="text-sm font-medium">{{ $u->nama_pengguna ?? 'Admin Utama' }}</p>
                <p class="text-xs text-blue-300">{{ $u->role ?? 'Administrator' }}</p>
            </div>
        </div>
        <button type="button" onclick="document.getElementById('modalLogout').classList.remove('hidden')"
                class="text-blue-300 hover:text-red-400" title="Keluar">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
            </svg>
        </button>
    </div>
</aside>

{{-- Modal Konfirmasi Logout --}}
<div id="modalLogout" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 shadow-xl max-w-sm w-full mx-4 text-center">
        <div class="w-12 h-12 bg-blue-900 text-white rounded-xl flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
            </svg>
        </div>
        <h3 class="text-lg font-bold text-slate-800 mb-1">Konfirmasi Keluar</h3>
        <p class="text-sm text-slate-500 mb-6">Apakah Anda yakin ingin mengakhiri sesi ini? Perubahan yang belum disimpan mungkin akan hilang.</p>
        <div class="flex gap-3">
            <button type="button" onclick="document.getElementById('modalLogout').classList.add('hidden')"
                    class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-600 text-sm font-medium rounded-lg hover:bg-slate-50">
                Batal
            </button>
            <form method="POST" action="{{ route('logout') }}" class="flex-1">
                @csrf
                <button type="submit" class="w-full px-4 py-2.5 bg-blue-900 hover:bg-blue-950 text-white text-sm font-medium rounded-lg">
                    Ya, Keluar
                </button>
            </form>
        </div>
    </div>
</div>