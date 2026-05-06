<aside
    x-data="{ open: true, activeMenu: '{{ request()->routeIs('admin.dashboard*') ? 'dashboard' : (request()->routeIs('admin.buku-perpus*') ? 'buku-perpus' : (request()->routeIs('admin.buku-tukar*') ? 'buku-tukar' : (request()->routeIs('admin.transaksi*') ? 'transaksi' : (request()->routeIs('admin.member*') ? 'member' : (request()->routeIs('admin.lokasi*') ? 'lokasi' : ''))))) }}' }"
    :class="open ? 'w-64' : 'w-18'"
    class="relative flex flex-col h-screen bg-primary transition-all duration-300 ease-in-out shrink-0 shadow-lg"
>

    {{-- Toggle Button --}}
    <button
        @click="open = !open"
        class="absolute -right-3 top-6 z-50 flex items-center justify-center w-6 h-6 rounded-full bg-white border border-primary-200 shadow-md text-primary hover:bg-primary-50 transition-colors"
    >
        <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 18l-6-6 6-6"/>
        </svg>
        <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 18l6-6-6-6"/>
        </svg>
    </button>

    <div class="flex items-center gap-3 px-4 py-5 border-b border-white/10 overflow-hidden">
        <div class="shrink-0 flex items-center justify-center w-9 h-9 rounded-xl bg-white/15 text-white">
            <x-icons.book/>
        </div>
        <div x-show="open" x-transition:enter="transition-opacity duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="overflow-hidden">
            <p class="text-white font-semibold text-sm leading-tight whitespace-nowrap">Perpustakaan</p>
            <p class="text-primary-300 text-xs whitespace-nowrap">Admin Panel</p>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-4 px-2 space-y-0.5">

        <div x-show="open" class="px-3 pt-1 pb-2">
            <span class="text-[10px] font-semibold uppercase tracking-widest text-primary-400">Menu Utama</span>
        </div>

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
            @click="activeMenu = 'dashboard'"
            :class="activeMenu === 'dashboard' ? 'bg-white/15 text-white' : 'text-primary-300 hover:bg-white/10 hover:text-white'"
            class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition-all duration-150 relative overflow-hidden"
        >
            <span :class="activeMenu === 'dashboard' ? 'bg-white' : 'bg-primary-400 group-hover:bg-white'" class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 rounded-r-full transition-all duration-150"></span>
            <span class="shrink-0 pl-1">
                <x-icons.dashboard/>
            </span>
            <span x-show="open" class="text-sm font-medium whitespace-nowrap" x-transition:enter="transition-opacity duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">Dashboard</span>
            <span x-show="!open" class="absolute left-14 bg-primary-600 text-white text-xs font-medium px-2 py-1 rounded-md shadow-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">Dashboard</span>
        </a>

        <div x-show="open" class="px-3 pt-4 pb-2">
            <span class="text-[10px] font-semibold uppercase tracking-widest text-primary-400">Koleksi Buku</span>
        </div>
        <div x-show="!open" class="my-2 mx-3 border-t border-white/10"></div>

        Buku Perpustakaan
        <a href="{{ route('admin.buku-perpus') }}"
            @click="activeMenu = 'buku-perpus'"
            :class="activeMenu === 'buku-perpus' ? 'bg-white/15 text-white' : 'text-primary-300 hover:bg-white/10 hover:text-white'"
            class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition-all duration-150 relative overflow-hidden"
        >
            <span :class="activeMenu === 'buku-perpus' ? 'bg-white' : 'bg-primary-400 group-hover:bg-white'" class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 rounded-r-full transition-all duration-150"></span>
            <span class="shrink-0 pl-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                </svg>
            </span>
            <span x-show="open" class="text-sm font-medium whitespace-nowrap" x-transition:enter="transition-opacity duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">Buku Perpustakaan</span>
            <span x-show="!open" class="absolute left-14 bg-primary-600 text-white text-xs font-medium px-2 py-1 rounded-md shadow-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">Buku Perpustakaan</span>
        </a>

        {{-- Buku Tukar
        <a href="{{ route('admin.buku-tukar.index') }}"
            @click="activeMenu = 'buku-tukar'"
            :class="activeMenu === 'buku-tukar' ? 'bg-white/15 text-white' : 'text-primary-300 hover:bg-white/10 hover:text-white'"
            class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition-all duration-150 relative overflow-hidden"
        >
            <span :class="activeMenu === 'buku-tukar' ? 'bg-white' : 'bg-primary-400 group-hover:bg-white'" class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 rounded-r-full transition-all duration-150"></span>
            <span class="shrink-0 pl-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3M3 16v3a2 2 0 0 0 2 2h3m8 0h3a2 2 0 0 0 2-2v-3"/>
                    <path d="M8 12h8M12 8l4 4-4 4"/>
                </svg>
            </span>
            <span x-show="open" class="text-sm font-medium whitespace-nowrap" x-transition:enter="transition-opacity duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">Buku Tukar</span>
            <span x-show="!open" class="absolute left-14 bg-primary-600 text-white text-xs font-medium px-2 py-1 rounded-md shadow-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">Buku Tukar</span>
        </a> --}}

        {{-- Transaksi --}}
        <div x-show="open" class="px-3 pt-4 pb-2">
            <span class="text-[10px] font-semibold uppercase tracking-widest text-primary-400">Transaksi</span>
        </div>
        <div x-show="!open" class="my-2 mx-3 border-t border-white/10"></div>

        {{-- <a href="{{ route('admin.transaksi.index') }}"
            @click="activeMenu = 'transaksi'"
            :class="activeMenu === 'transaksi' ? 'bg-white/15 text-white' : 'text-primary-300 hover:bg-white/10 hover:text-white'"
            class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition-all duration-150 relative overflow-hidden"
        >
            <span :class="activeMenu === 'transaksi' ? 'bg-white' : 'bg-primary-400 group-hover:bg-white'" class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 rounded-r-full transition-all duration-150"></span>
            <span class="shrink-0 pl-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                </svg>
            </span>
            <span x-show="open" class="text-sm font-medium whitespace-nowrap" x-transition:enter="transition-opacity duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">Transaksi Tukar</span>
            <span x-show="!open" class="absolute left-14 bg-primary-600 text-white text-xs font-medium px-2 py-1 rounded-md shadow-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">Transaksi Tukar</span>
        </a> --}}

        {{-- Master Data --}}
        <div x-show="open" class="px-3 pt-4 pb-2">
            <span class="text-[10px] font-semibold uppercase tracking-widest text-primary-400">Master Data</span>
        </div>
        <div x-show="!open" class="my-2 mx-3 border-t border-white/10"></div>

        {{-- Member
        <a href="{{ route('admin.member.index') }}"
            @click="activeMenu = 'member'"
            :class="activeMenu === 'member' ? 'bg-white/15 text-white' : 'text-primary-300 hover:bg-white/10 hover:text-white'"
            class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition-all duration-150 relative overflow-hidden"
        >
            <span :class="activeMenu === 'member' ? 'bg-white' : 'bg-primary-400 group-hover:bg-white'" class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 rounded-r-full transition-all duration-150"></span>
            <span class="shrink-0 pl-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </span>
            <span x-show="open" class="text-sm font-medium whitespace-nowrap" x-transition:enter="transition-opacity duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">Member</span>
            <span x-show="!open" class="absolute left-14 bg-primary-600 text-white text-xs font-medium px-2 py-1 rounded-md shadow-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">Member</span>
        </a>

        Lokasi
        <a href="{{ route('admin.lokasi.index') }}"
            @click="activeMenu = 'lokasi'"
            :class="activeMenu === 'lokasi' ? 'bg-white/15 text-white' : 'text-primary-300 hover:bg-white/10 hover:text-white'"
            class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition-all duration-150 relative overflow-hidden"
        >
            <span :class="activeMenu === 'lokasi' ? 'bg-white' : 'bg-primary-400 group-hover:bg-white'" class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 rounded-r-full transition-all duration-150"></span>
            <span class="shrink-0 pl-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
            </span>
            <span x-show="open" class="text-sm font-medium whitespace-nowrap" x-transition:enter="transition-opacity duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">Lokasi</span>
            <span x-show="!open" class="absolute left-14 bg-primary-600 text-white text-xs font-medium px-2 py-1 rounded-md shadow-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">Lokasi</span>
        </a>

    </nav>

    {{-- User Profile & Logout --}}
    {{-- <div class="border-t border-white/10 p-3">
        <div class="flex items-center gap-3 rounded-xl px-2 py-2 overflow-hidden">
            <div class="shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-white/20 text-white text-xs font-bold uppercase">
                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
            </div>
            <div x-show="open" class="flex-1 min-w-0" x-transition:enter="transition-opacity duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <p class="text-white text-xs font-semibold truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="text-primary-300 text-[11px] truncate">{{ auth()->user()->email ?? '' }}</p>
            </div>
            <form x-show="open" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="shrink-0 text-primary-300 hover:text-white transition-colors" title="Logout">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </button>
            </form>
        </div>
    </div> --}}

</aside>