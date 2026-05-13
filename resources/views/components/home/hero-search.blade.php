<section class="relative z-50 min-h-screen flex flex-col items-center justify-center pt-25 pb-16 px-6 text-center">

    {{-- Glow orb --}}
    <div class="hero-glow absolute w-[clamp(400px,70vw,860px)] h-[clamp(400px,70vw,860px)] rounded-full pointer-events-none"
         style="background: radial-gradient(circle, rgba(4,68,141,0.10) 0%, transparent 68%);">
    </div>

    {{-- Eyebrow --}}
    <p class="animate-fade-up-1 text-[0.72rem] font-semibold tracking-[0.22em] uppercase text-primary-500 mb-5 flex items-center gap-3">
        <span class="block w-9 h-[1.5px] bg-primary-500 rounded"></span>
        Perpustakaan Kota Yogyakarta
        <span class="block w-9 h-[1.5px] bg-primary-500 rounded"></span>
    </p>

    {{-- Title --}}
    <h1 class="animate-fade-up-2 font-extrabold leading-[1.1] text-primary-900 mb-5"
        style="font-size: clamp(2.4rem, 7vw, 5rem);">
        Tukarkan Buku,<br>
        <span class="text-primary">Perluas Wawasan</span>
    </h1>

    {{-- Description --}}
    <p class="animate-fade-up-3 max-w-130 text-base leading-[1.78] text-neutral-500 font-normal mb-12">
        Temukan buku yang kamu inginkan, ajukan penukaran, dan nikmati
        koleksi baru tanpa biaya.
    </p>

    {{-- Search --}}
    <div class="animate-fade-up-4 w-full max-w-160 relative z-100">
        <div class="search-box relative flex items-center bg-white border border-primary-100 rounded-lg shadow-lg transition-all duration-200 overflow-hidden">
            <span class="shrink-0 px-4 pl-5 grid place-items-center text-neutral-400">
                <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2">
                    <circle cx="11" cy="11" r="7"/>
                    <path d="M21 21l-4.35-4.35" stroke-linecap="round"/>
                </svg>
            </span>
            <input
                id="search-input"
                type="text"
                class="flex-1 border-none outline-none font-sans text-[0.95rem] text-primary-900 bg-transparent py-4 placeholder-neutral-400"
                placeholder="Cari judul buku, penulis…"
                autocomplete="off"
            >
            <button id="search-btn"
                    class="m-[0.45rem] shrink-0 px-6 py-[0.65rem] bg-primary text-white font-sans text-[0.88rem] font-semibold border-none rounded-md cursor-pointer transition-all duration-200 shadow hover:bg-[#033370] hover:scale-[1.02] hover:shadow-md">
                <span class="max-sm:hidden">Cari Buku</span>
                <span class="hidden max-sm:inline text-base">→</span>
            </button>
        </div>

        {{-- Filter row: Kategori + Lokasi --}}
        <div class="animate-fade-up-5 relative z-50 flex flex-wrap items-center gap-2 justify-center mt-4">

            {{-- Filter Kategori --}}
            <div class="relative" id="dropdown-kategori-wrapper">
                <button id="dropdown-kategori-btn"
                        class="flex items-center gap-1.5 px-[0.95rem] py-[0.35rem] border border-primary-100 rounded-full text-[0.78rem] font-medium text-neutral-500 bg-white/70 cursor-pointer transition-all duration-200 hover:bg-primary hover:text-white hover:border-primary"
                        onclick="toggleDropdown('kategori')">
                    <svg class="w-3.5 h-3.5 stroke-current fill-none shrink-0" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M4 6h16M4 12h8M4 18h4" stroke-linecap="round"/>
                    </svg>
                    <span id="label-kategori">Kategori</span>
                    <svg class="w-3 h-3 stroke-current fill-none shrink-0 transition-transform" id="chevron-kategori" viewBox="0 0 24 24" stroke-width="2.5">
                        <path d="M6 9l6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div id="dropdown-kategori"
                    class="hidden absolute left-0 top-[calc(100%+6px)] z-9999 bg-white border border-neutral-200 rounded-xl shadow-lg py-1.5 min-w-55 max-h-70 overflow-y-auto text-left custom-scroll">
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
                        class="flex items-center gap-1.5 px-[0.95rem] py-[0.35rem] border border-primary-100 rounded-full text-[0.78rem] font-medium text-neutral-500 bg-white/70 cursor-pointer transition-all duration-200 hover:bg-primary hover:text-white hover:border-primary"
                        onclick="toggleDropdown('lokasi')">
                    <svg class="w-3.5 h-3.5 stroke-current fill-none shrink-0" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                        <circle cx="12" cy="9" r="2.5"/>
                    </svg>
                    <span id="label-lokasi">Lokasi</span>
                    <svg class="w-3 h-3 stroke-current fill-none shrink-0 transition-transform" id="chevron-lokasi" viewBox="0 0 24 24" stroke-width="2.5">
                        <path d="M6 9l6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div id="dropdown-lokasi"
                    class="hidden absolute left-0 top-[calc(100%+6px)] z-9999 bg-white border border-neutral-200 rounded-xl shadow-lg py-1.5 min-w-70 text-left custom-scroll">
                    <button
                        data-value=""
                        class="dropdown-item-lokasi w-full text-left px-3.5 py-2 text-[0.78rem] text-neutral-600 hover:bg-primary-50 hover:text-primary transition-colors">
                        Lokasi
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
                    class="hidden items-center gap-1 px-[0.95rem] py-[0.35rem] border border-danger-200 rounded-full text-[0.78rem] font-medium text-danger-500 bg-white/70 cursor-pointer transition-all duration-200 hover:bg-danger-50">
                <svg class="w-3 h-3 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2.5">
                    <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round"/>
                </svg>
                Reset Filter
            </button>

        </div>
    </div>

    {{-- ══ KATALOG SECTION ══ --}}
    <div id="katalog-section" class="relative z-1 w-full max-w-6xl mt-14">

        {{-- Header hasil --}}
        <div class="flex items-center justify-between mb-6 px-1">
            <div class="text-left">
                <p id="katalog-label" class="text-[0.7rem] font-semibold tracking-[0.18em] uppercase text-primary-400 mb-1">Hasil Pencarian</p>
                <h2 id="katalog-title" class="font-bold text-primary-900 text-lg leading-tight"></h2>
            </div>
            <button id="katalog-close"
                    class="flex items-center gap-1.5 text-[0.78rem] font-medium text-neutral-400 hover:text-primary transition-colors duration-200 cursor-pointer">
                <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round"/>
                </svg>
                Tutup
            </button>
        </div>

        {{-- Loading state --}}
        <div id="katalog-loading" class="hidden flex-col items-center justify-center py-16 gap-4">
            <div class="spinner"></div>
            <p class="text-sm text-neutral-400 font-medium">Mencari buku…</p>
        </div>

        {{-- Empty state --}}
        <div id="katalog-empty" class="hidden flex-col items-center justify-center py-16 gap-3">
            <svg class="w-14 h-14 text-primary-200 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.3">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                <rect x="9" y="3" width="6" height="4" rx="1"/>
                <path d="M9 12h6M9 16h4" stroke-linecap="round"/>
            </svg>
            <p class="font-semibold text-primary-800">Buku tidak ditemukan</p>
            <p class="text-sm text-neutral-400">Coba kata kunci lain atau ubah filter</p>
        </div>

        {{-- Grid buku --}}
        <div id="katalog-grid" class="grid gap-5" style="grid-template-columns: repeat(3, 1fr);"></div>

    </div>
    {{-- /KATALOG SECTION --}}

</section>