<section class="relative z-50 min-h-screen flex flex-col items-center justify-center pb-16 px-4 sm:px-6 text-center">

    {{-- Glow orb --}}
    <div class="hero-glow absolute w-[clamp(300px,70vw,860px)] h-[clamp(300px,70vw,860px)] rounded-full pointer-events-none"
         style="background: radial-gradient(circle, rgba(4,68,141,0.10) 0%, transparent 68%);">
    </div>

    {{-- Eyebrow --}}
    <p class="animate-fade-up-1 text-[0.65rem] sm:text-[0.72rem] font-semibold tracking-[0.18em] sm:tracking-[0.22em] uppercase text-primary-500 mb-4 sm:mb-5 flex items-center gap-2 sm:gap-3">
        <span class="block w-6 sm:w-9 h-[1.5px] bg-primary-500 rounded"></span>
        Perpustakaan Kota Yogyakarta
        <span class="block w-6 sm:w-9 h-[1.5px] bg-primary-500 rounded"></span>
    </p>

    {{-- Title --}}
    <h1 class="animate-fade-up-2 font-extrabold leading-[1.1] text-primary-900 mb-4 sm:mb-5"
        style="font-size: clamp(1.8rem, 7vw, 5rem);">
        Tukarkan Buku,<br>
        <span class="text-primary">Perluas Wawasan</span>
    </h1>

    {{-- Description --}}
    <p class="animate-fade-up-3 max-w-xs sm:max-w-130 text-sm sm:text-base leading-[1.78] text-neutral-500 font-normal mb-8 sm:mb-12">
        Temukan buku yang kamu inginkan, ajukan penukaran, dan nikmati
        koleksi baru tanpa biaya.
    </p>

    {{-- Search --}}
    <div class="animate-fade-up-4 w-full max-w-3xl relative z-100">
        <div class="search-box relative flex items-center bg-white border border-primary-100 rounded-lg shadow-sm transition-all duration-200 overflow-hidden">
            <span class="shrink-0 px-3 sm:px-4 sm:pl-5 grid place-items-center text-neutral-400">
                <x-icons.search/>
            </span>
            <input
                id="search-input"
                type="text"
                class="flex-1 border-none outline-none font-sans text-[0.88rem] sm:text-[0.95rem] text-primary-900 bg-transparent py-3.5 sm:py-4 placeholder-neutral-400"
                placeholder="Cari judul, penulis…"
                autocomplete="off"
            >
            <button id="search-btn"
                    class="m-[0.35rem] sm:m-[0.45rem] shrink-0 px-4 sm:px-6 py-2.5 sm:py-[0.65rem] bg-primary text-white font-sans text-[0.82rem] sm:text-[0.88rem] font-semibold border-none rounded-md cursor-pointer transition-all duration-200 shadow hover:bg-[#033370] hover:shadow-md">
                <span class="max-sm:hidden">Cari Buku</span>
                <span class="hidden max-sm:inline">
                    <x-icons.search/>
                </span>
            </button>
        </div>

        {{-- Filter row --}}
        <div class="animate-fade-up-5 relative z-9999 flex flex-wrap items-center gap-2 justify-center mt-3 sm:mt-4">

            {{-- Filter Kategori --}}
            <div class="relative" id="dropdown-kategori-wrapper">
                <button id="dropdown-kategori-btn"
                        class="flex items-center gap-1.5 px-3 sm:px-[0.95rem] py-[0.35rem] border border-primary-100 rounded-full text-[0.75rem] sm:text-[0.78rem] font-medium text-neutral-500 bg-white/70 cursor-pointer transition-all duration-200 hover:bg-primary hover:text-white hover:border-primary"
                        onclick="toggleDropdown('kategori')">
                    <x-icons.filter/>
                    <span id="label-kategori">Kategori</span>
                    <x-icons.chevron-down class="w-3 h-3 stroke-current fill-none shrink-0 transition-transform pointer-events-none" id="chevron-kategori" />
                </button>
                <div id="dropdown-kategori"
                     class="hidden absolute left-0 top-[calc(100%+6px)] z-9999 bg-white border border-neutral-200 rounded-xl shadow-lg py-1.5 w-55 max-h-65 overflow-y-auto text-left custom-scroll">
                    @foreach (['Kategori', 'Filsafat & Psikologi', 'Agama', 'Ilmu Sosial', 'Bahasa', 'Sains & Matematika', 'Teknologi', 'Seni & Rekreasi', 'Literatur & Sastra', 'Geografi & Sejarah'] as $kat)
                        <button
                            data-value="{{ $kat === 'Kategori' ? '' : $kat }}"
                            class="dropdown-item-kategori w-full text-left px-3.5 py-2 text-[0.78rem] text-neutral-600 hover:bg-primary-50 hover:text-primary transition-colors">
                            {{ $kat }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Filter Lokasi --}}
            <div class="relative" id="dropdown-lokasi-wrapper">
                <button id="dropdown-lokasi-btn"
                        class="flex items-center gap-1.5 px-3 sm:px-[0.95rem] py-[0.35rem] border border-primary-100 rounded-full text-[0.75rem] sm:text-[0.78rem] font-medium text-neutral-500 bg-white/70 cursor-pointer transition-all duration-200 hover:bg-primary hover:text-white hover:border-primary"
                        onclick="toggleDropdown('lokasi')">
                    <x-icons.location width="14" height="14"/>
                    <span id="label-lokasi">Lokasi</span>
                    <x-icons.chevron-down class="w-3 h-3 stroke-current fill-none shrink-0 transition-transform pointer-events-none" id="chevron-lokasi" />
                </button>
                <div id="dropdown-lokasi"
                     class="hidden absolute left-0 top-[calc(100%+6px)] z-9999 bg-white border border-neutral-200 rounded-xl shadow-lg py-1.5 w-65 sm:min-w-70 max-h-65 overflow-y-auto text-left custom-scroll">
                    <button
                        data-value=""
                        class="dropdown-item-lokasi w-full text-left px-3.5 py-2 text-[0.78rem] text-neutral-600 hover:bg-primary-50 hover:text-primary transition-colors">
                        Semua Lokasi
                    </button>
                    @foreach ($lokasis as $lokasi)
                        <button
                            data-value="{{ $lokasi->id }}"
                            data-label="{{ $lokasi->nama_lokasi }}"
                            class="dropdown-item-lokasi w-full text-left px-3.5 py-2 text-[0.78rem] text-neutral-600 hover:bg-primary-50 hover:text-primary transition-colors">
                            {{ $lokasi->nama_lokasi }}
                            <span class="block text-[0.68rem] text-neutral-400">{{ $lokasi->alamat }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Reset filter --}}
            <button id="reset-filter"
                    class="hidden items-center gap-1 px-3 sm:px-[0.95rem] py-[0.35rem] border border-danger-200 rounded-full text-[0.75rem] sm:text-[0.78rem] font-medium text-danger-500 bg-white/70 cursor-pointer transition-all duration-200 hover:bg-danger-50">
                <svg class="w-3 h-3 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2.5">
                    <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round"/>
                </svg>
                Reset
            </button>
        </div>
    </div>

    {{-- ══ KATALOG SECTION ══ --}}
    <div id="katalog-section" class="relative z-1 w-full max-w-6xl mt-10 sm:mt-14">

        {{-- Header hasil --}}
        <div class="flex items-center justify-between mb-4 sm:mb-6 px-1">
            <div class="text-left">
                <p id="katalog-label" class="text-[0.65rem] sm:text-[0.7rem] font-semibold tracking-[0.18em] uppercase text-primary-400 mb-1">Hasil Pencarian</p>
                <h2 id="katalog-title" class="font-bold text-primary-900 text-sm sm:text-lg leading-tight"></h2>
            </div>
            <button id="katalog-close"
                    class="flex items-center gap-1 sm:gap-1.5 text-[0.72rem] sm:text-[0.78rem] font-medium text-neutral-400 hover:text-primary transition-colors duration-200 cursor-pointer">
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round"/>
                </svg>
                Tutup
            </button>
        </div>

        {{-- Loading state --}}
        <div id="katalog-loading" class="hidden flex-col items-center justify-center py-12 sm:py-16 gap-4">
            <div class="spinner"></div>
            <p class="text-sm text-neutral-400 font-medium">Mencari buku…</p>
        </div>

        {{-- Empty state --}}
        <div id="katalog-empty" class="hidden flex-col items-center justify-center py-12 sm:py-16 gap-3">
            <svg class="w-12 h-12 sm:w-14 sm:h-14 text-primary-200 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.3">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                <rect x="9" y="3" width="6" height="4" rx="1"/>
                <path d="M9 12h6M9 16h4" stroke-linecap="round"/>
            </svg>
            <p class="font-semibold text-primary-800 text-sm">Buku tidak ditemukan</p>
            <p class="text-xs sm:text-sm text-neutral-400">Coba kata kunci lain atau ubah filter</p>
        </div>

        {{-- Grid buku: 1 col mobile, 2 col tablet, 3 col desktop --}}
        <div id="katalog-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5"></div>

    </div>
</section>