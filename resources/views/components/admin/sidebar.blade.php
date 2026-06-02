@php
    $activeMenu = match(true) {
        request()->routeIs('admin.dashboard*')            => 'dashboard',
        request()->routeIs('admin.transaksi*')            => 'transaksi',
        request()->routeIs('admin.member*')               => 'member',
        request()->routeIs('admin.buku*', 'admin.paket*') => 'buku',
        request()->routeIs('admin.lokasi*')               => 'lokasi',
        request()->routeIs('admin.kegiatan*')             => 'kegiatan',
        request()->routeIs('admin.pengaturan*')           => 'pengaturan',
        default                                           => '',
    };

    $navItems = [
        ['key' => 'dashboard',   'label' => 'Dashboard',         'route' => route('admin.dashboard'),           'icon' => 'dashboard',  'group' => 'utama'],
        ['key' => 'transaksi',   'label' => 'Tukar Buku',        'route' => route('admin.transaksi.index'),     'icon' => 'book-up',    'group' => 'utama'],
        ['key' => 'member',      'label' => 'Member',            'route' => route('admin.member.index'),        'icon' => 'users',      'group' => 'data'],
        ['key' => 'buku',        'label' => 'Buku',              'route' => route('admin.buku.index'),          'icon' => 'book-open',  'group' => 'data'],
        ['key' => 'lokasi',      'label' => 'Lokasi',            'route' => route('admin.lokasi.index'),        'icon' => 'location',   'group' => 'data'],
        ['key' => 'kegiatan',    'label' => 'Rencana Kegiatan',  'route' => route('admin.kegiatan.index'),      'icon' => 'calendar',   'group' => 'data'],
        ['key' => 'pengaturan',  'label' => 'Pengaturan',        'route' => auth()->user()->isSuperAdmin() ? route('admin.pengaturan.index') : route('admin.pengaturan.profil.page'), 'icon' => 'settings', 'group' => 'akun'],
    ];
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
    {{-- Toggle button --}}
    <button
        @click="toggle()"
        aria-label="Toggle sidebar"
        class="absolute -right-3 top-6 z-50 flex items-center justify-center w-6 h-6 rounded-full bg-white border border-primary-200 shadow-md text-primary hover:bg-primary-50 transition-colors"
    >
        <span x-show="open"
              x-transition:enter="transition-opacity duration-150"
              x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100"
              x-transition:leave="transition-opacity duration-100"
              x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M15 18l-6-6 6-6"/>
            </svg>
        </span>
        <span x-show="!open"
              x-transition:enter="transition-opacity duration-150"
              x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100"
              x-transition:leave="transition-opacity duration-100"
              x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M9 18l6-6-6-6"/>
            </svg>
        </span>
    </button>

    {{-- Logo / Brand --}}
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

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto overflow-x-visible py-4 px-2 space-y-0.5">

        <div x-show="open" class="px-3 pt-1 pb-2">
            <span class="text-xs font-semibold uppercase tracking-wider text-primary-400">Menu Utama</span>
        </div>

        @foreach($navItems as $item)

            @if($item['key'] === 'member')
                <div x-show="open" class="px-3 pt-4 pb-2">
                    <span class="text-xs font-semibold uppercase tracking-wider text-primary-400">Kelola Data</span>
                </div>
                <div x-show="!open" class="my-2 mx-3 border-t border-white/10"></div>
            @endif

            @if($item['key'] === 'pengaturan')
                <div x-show="open" class="px-3 pt-4 pb-2">
                    <span class="text-xs font-semibold uppercase tracking-wider text-primary-400">Akun</span>
                </div>
                <div x-show="!open" class="my-2 mx-3 border-t border-white/10"></div>
            @endif

            <div class="relative group/nav">
                <a href="{{ $item['route'] }}"
                    :class="[
                        activeMenu === '{{ $item['key'] }}' ? 'bg-white/15 text-white' : 'text-primary-300 hover:bg-white/10 hover:text-white',
                        open ? 'px-3 gap-3' : 'px-0 gap-0 justify-center'
                    ]"
                    class="flex items-center rounded-xl py-2.5 transition-colors duration-150 relative w-full"
                >
                    <span x-show="activeMenu === '{{ $item['key'] }}'"
                          class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 rounded-r-full bg-white shrink-0"></span>

                    <span class="shrink-0 flex items-center justify-center w-5 h-5">
                        <x-dynamic-component :component="'icons.' . $item['icon']" class="w-5 h-5"/>
                    </span>

                    <span x-show="open" class="text-sm font-medium whitespace-nowrap"
                          x-transition:enter="transition-opacity duration-150"
                          x-transition:enter-start="opacity-0"
                          x-transition:enter-end="opacity-100">{{ $item['label'] }}</span>
                </a>

                <div x-show="!open"
                     class="pointer-events-none absolute left-[calc(100%+0.75rem)] top-1/2 -translate-y-1/2 z-50
                            opacity-0 group-hover/nav:opacity-100 transition-opacity duration-150
                            flex items-center gap-1">
                    <div class="w-0 h-0 border-y-4 border-y-transparent border-r-4 border-r-primary-600"></div>
                    <div class="bg-primary-600 text-white text-xs font-medium px-2.5 py-1.5 rounded-md shadow-lg whitespace-nowrap">
                        {{ $item['label'] }}
                    </div>
                </div>
            </div>
        @endforeach

    </nav>

    {{-- User profile & logout --}}
    <div class="border-t border-white/10 p-3">

        {{-- Expanded state --}}
        <div x-show="open"
            x-transition:enter="transition-opacity duration-150"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="flex items-center gap-3 rounded-xl px-2 py-2">
            <div class="shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-white/20 text-white text-sm font-bold uppercase select-none">
                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white text-xs font-semibold truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="text-primary-300 text-xs truncate">{{ auth()->user()->email ?? '' }}</p>
            </div>
            <form method="POST" action="{{ route('auth.logout') }}"
                  onsubmit="return confirm('Yakin ingin keluar?')">
                @csrf
                <button type="submit"
                        aria-label="Logout"
                        class="shrink-0 p-1.5 rounded-lg text-primary-300 hover:text-white hover:bg-white/10 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </button>
            </form>
        </div>

        {{-- Collapsed state --}}
        <div x-show="!open"
            x-data="{ dropdownOpen: false }"
            class="relative flex justify-center">

            <button @click="dropdownOpen = !dropdownOpen"
                    @click.outside="dropdownOpen = false"
                    aria-label="Menu akun"
                    class="flex items-center justify-center w-8 h-8 rounded-full bg-white/20 text-white text-sm font-bold uppercase hover:bg-white/30 transition-colors select-none">
                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
            </button>

            <div x-show="dropdownOpen"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 -translate-x-2"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 -translate-x-2"
                class="absolute bottom-0 left-full ml-2 w-48 bg-white rounded-lg shadow-lg border border-neutral-200 overflow-hidden z-50">

                <div class="px-3 py-2.5 border-b border-neutral-100">
                    <p class="text-xs font-semibold text-neutral-800 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-neutral-500 truncate">{{ auth()->user()->email ?? '' }}</p>
                </div>

                <form method="POST" action="{{ route('auth.logout') }}"
                      onsubmit="return confirm('Yakin ingin keluar?')">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-2 px-3 py-2.5 text-xs font-medium text-danger-600 hover:bg-danger-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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