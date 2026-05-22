@php
    $activeMenu = match(true) {
        request()->routeIs('admin.dashboard*')   => 'dashboard',
        request()->routeIs('admin.transaksi*')   => 'transaksi',
        request()->routeIs('admin.member*')      => 'member',
        request()->routeIs('admin.buku*')        => 'buku',
        request()->routeIs('admin.lokasi*')      => 'lokasi',
        request()->routeIs('admin.kegiatan*')    => 'kegiatan',
        request()->routeIs('admin.pengaturan*')  => 'pengaturan',
        default                                  => '',
    };
@endphp

<aside
    x-data="{
        open: localStorage.getItem('sidebarOpen') !== 'false',
        activeMenu: '{{ $activeMenu }}',
        loaded: false,
        toggle() {
            this.open = !this.open;
            localStorage.setItem('sidebarOpen', this.open);
            document.documentElement.style.setProperty('--sidebar-w', this.open ? '16rem' : '4.5rem');
        }
    }"
    x-init="$nextTick(() => loaded = true)"
    :style="loaded ? 'transition: width 300ms cubic-bezier(0.4,0,0.2,1)' : ''"
    style="width: var(--sidebar-w, 16rem)"
    class="relative flex flex-col h-screen bg-primary shrink-0 shadow-lg"
>
    <button
        @click="toggle()"
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
        <div x-show="open"
             x-transition:enter="transition-opacity duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="overflow-hidden">
            <p class="text-white font-semibold text-sm leading-tight whitespace-nowrap">Perpustakaan</p>
            <p class="text-primary-300 text-xs whitespace-nowrap">Admin Panel</p>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-4 px-2 space-y-0.5">

        <div x-show="open" class="px-3 pt-1 pb-2">
            <span class="text-xs font-semibold uppercase tracking-widest text-primary-400">Menu Utama</span>
        </div>

        <a href="{{ route('admin.dashboard') }}"
            :class="[
                activeMenu === 'dashboard' ? 'bg-white/15 text-white' : 'text-primary-300 hover:bg-white/10 hover:text-white',
                open ? 'px-3 gap-3' : 'px-0 gap-0 justify-center'
            ]"
            class="group flex items-center rounded-xl py-2.5 transition-colors duration-150 relative overflow-hidden w-full"
        >
            <span x-show="activeMenu === 'dashboard'"
                  class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 rounded-r-full bg-white shrink-0"></span>
            <span class="shrink-0"><x-icons.dashboard/></span>
            <span x-show="open" class="text-sm font-medium whitespace-nowrap"
                  x-transition:enter="transition-opacity duration-150"
                  x-transition:enter-start="opacity-0"
                  x-transition:enter-end="opacity-100">Dashboard</span>
            <span x-show="!open" class="absolute left-14 bg-primary-600 text-white text-xs font-medium px-2 py-1 rounded-md shadow-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">Dashboard</span>
        </a>

        <a href="{{ route('admin.transaksi.index') }}"
            :class="[
                activeMenu === 'transaksi' ? 'bg-white/15 text-white' : 'text-primary-300 hover:bg-white/10 hover:text-white',
                open ? 'px-3 gap-3' : 'px-0 gap-0 justify-center'
            ]"
            class="group flex items-center rounded-xl py-2.5 transition-colors duration-150 relative overflow-hidden w-full"
        >
            <span x-show="activeMenu === 'transaksi'"
                  class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 rounded-r-full bg-white shrink-0"></span>
            <span class="shrink-0"><x-icons.book-up/></span>
            <span x-show="open" class="text-sm font-medium whitespace-nowrap"
                  x-transition:enter="transition-opacity duration-150"
                  x-transition:enter-start="opacity-0"
                  x-transition:enter-end="opacity-100">Tukar Buku</span>
            <span x-show="!open" class="absolute left-14 bg-primary-600 text-white text-xs font-medium px-2 py-1 rounded-md shadow-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">Transaksi Tukar</span>
        </a>

        <div x-show="open" class="px-3 pt-4 pb-2">
            <span class="text-xs font-semibold uppercase tracking-widest text-primary-400">Kelola Data</span>
        </div>
        <div x-show="!open" class="my-2 mx-3 border-t border-white/10"></div>

        <a href="{{ route('admin.member.index') }}"
            :class="[
                activeMenu === 'member' ? 'bg-white/15 text-white' : 'text-primary-300 hover:bg-white/10 hover:text-white',
                open ? 'px-3 gap-3' : 'px-0 gap-0 justify-center'
            ]"
            class="group flex items-center rounded-xl py-2.5 transition-colors duration-150 relative overflow-hidden w-full"
        >
            <span x-show="activeMenu === 'member'"
                  class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 rounded-r-full bg-white shrink-0"></span>
            <span class="shrink-0"><x-icons.users/></span>
            <span x-show="open" class="text-sm font-medium whitespace-nowrap"
                  x-transition:enter="transition-opacity duration-150"
                  x-transition:enter-start="opacity-0"
                  x-transition:enter-end="opacity-100">Member</span>
            <span x-show="!open" class="absolute left-14 bg-primary-600 text-white text-xs font-medium px-2 py-1 rounded-md shadow-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">Member</span>
        </a>

        <a href="{{ route('admin.buku.index') }}"
            :class="[
                activeMenu === 'buku' ? 'bg-white/15 text-white' : 'text-primary-300 hover:bg-white/10 hover:text-white',
                open ? 'px-3 gap-3' : 'px-0 gap-0 justify-center'
            ]"
            class="group flex items-center rounded-xl py-2.5 transition-colors duration-150 relative overflow-hidden w-full"
        >
            <span x-show="activeMenu === 'buku'"
                  class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 rounded-r-full bg-white shrink-0"></span>
            <span class="shrink-0"><x-icons.book-open/></span>
            <span x-show="open" class="text-sm font-medium whitespace-nowrap"
                  x-transition:enter="transition-opacity duration-150"
                  x-transition:enter-start="opacity-0"
                  x-transition:enter-end="opacity-100">Buku</span>
            <span x-show="!open" class="absolute left-14 bg-primary-600 text-white text-xs font-medium px-2 py-1 rounded-md shadow-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">Buku</span>
        </a>

        <a href="{{ route('admin.lokasi.index') }}"
            :class="[
                activeMenu === 'lokasi' ? 'bg-white/15 text-white' : 'text-primary-300 hover:bg-white/10 hover:text-white',
                open ? 'px-3 gap-3' : 'px-0 gap-0 justify-center'
            ]"
            class="group flex items-center rounded-xl py-2.5 transition-colors duration-150 relative overflow-hidden w-full"
        >
            <span x-show="activeMenu === 'lokasi'"
                  class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 rounded-r-full bg-white shrink-0"></span>
            <span class="shrink-0"><x-icons.location/></span>
            <span x-show="open" class="text-sm font-medium whitespace-nowrap"
                  x-transition:enter="transition-opacity duration-150"
                  x-transition:enter-start="opacity-0"
                  x-transition:enter-end="opacity-100">Lokasi</span>
            <span x-show="!open" class="absolute left-14 bg-primary-600 text-white text-xs font-medium px-2 py-1 rounded-md shadow-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">Lokasi</span>
        </a>

        <a href="{{ route('admin.kegiatan.index') }}"
            :class="[
                activeMenu === 'kegiatan' ? 'bg-white/15 text-white' : 'text-primary-300 hover:bg-white/10 hover:text-white',
                open ? 'px-3 gap-3' : 'px-0 gap-0 justify-center'
            ]"
            class="group flex items-center rounded-xl py-2.5 transition-colors duration-150 relative overflow-hidden w-full"
        >
            <span x-show="activeMenu === 'kegiatan'"
                  class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 rounded-r-full bg-white shrink-0"></span>
            <span class="shrink-0"><x-icons.calendar/></span>
            <span x-show="open" class="text-sm font-medium whitespace-nowrap"
                  x-transition:enter="transition-opacity duration-150"
                  x-transition:enter-start="opacity-0"
                  x-transition:enter-end="opacity-100">Kegiatan</span>
            <span x-show="!open" class="absolute left-14 bg-primary-600 text-white text-xs font-medium px-2 py-1 rounded-md shadow-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">Rencana Kegiatan</span>
        </a>

        <div x-show="open" class="px-3 pt-4 pb-2">
            <span class="text-xs font-semibold uppercase tracking-widest text-primary-400">Akun</span>
        </div>
        <div x-show="!open" class="my-2 mx-3 border-t border-white/10"></div>

        <a href="{{ auth()->user()->isSuperAdmin() ? route('admin.pengaturan.index') : route('admin.pengaturan.profil.page') }}"
            :class="[
                activeMenu === 'pengaturan' ? 'bg-white/15 text-white' : 'text-primary-300 hover:bg-white/10 hover:text-white',
                open ? 'px-3 gap-3' : 'px-0 gap-0 justify-center'
            ]"
            class="group flex items-center rounded-xl py-2.5 transition-colors duration-150 relative overflow-hidden w-full"
        >
            <span x-show="activeMenu === 'pengaturan'"
                  class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 rounded-r-full bg-white shrink-0"></span>
            <span class="shrink-0"><x-icons.settings/></span>
            <span x-show="open" class="text-sm font-medium whitespace-nowrap"
                  x-transition:enter="transition-opacity duration-150"
                  x-transition:enter-start="opacity-0"
                  x-transition:enter-end="opacity-100">Pengaturan</span>
            <span x-show="!open" class="absolute left-14 bg-primary-600 text-white text-xs font-medium px-2 py-1 rounded-md shadow-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">Pengaturan</span>
        </a>

    </nav>

    <div class="border-t border-white/10 p-3">

        <div x-show="open"
            x-transition:enter="transition-opacity duration-150"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="flex items-center gap-3 rounded-xl px-2 py-2">
            <div class="shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-white/20 text-white text-xs font-bold uppercase">
                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white text-xs font-semibold truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="text-primary-300 text-xs truncate">{{ auth()->user()->email ?? '' }}</p>
            </div>
            <form method="POST" action="{{ route('auth.logout') }}">
                @csrf
                <button type="submit"
                        class="shrink-0 p-1.5 rounded-lg text-primary-300 hover:text-white hover:bg-white/10 transition-colors"
                        title="Logout">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </button>
            </form>
        </div>

        <div x-show="!open"
            x-data="{ dropdownOpen: false }"
            class="relative flex justify-center">

            <button @click="dropdownOpen = !dropdownOpen"
                    @click.outside="dropdownOpen = false"
                    class="flex items-center justify-center w-8 h-8 rounded-full bg-white/20 text-white text-xs font-bold uppercase hover:bg-white/30 transition-colors">
                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
            </button>

            <div x-show="dropdownOpen"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 -translate-x-2"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 -translate-x-2"
                class="absolute bottom-0 left-full ml-2 w-44 bg-white rounded-lg shadow-lg border border-neutral-200 overflow-hidden z-50">

                <div class="px-3 py-2.5 border-b border-neutral-100">
                    <p class="text-xs font-semibold text-neutral-800 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-neutral-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                </div>

                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-2 px-3 py-2.5 text-xs font-medium text-danger-600 hover:bg-danger-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

    </div>

</aside>