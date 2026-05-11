<section class="relative z-10 min-h-screen flex flex-col items-center justify-center pt-25 pb-16 px-6 text-center">

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
    <div class="animate-fade-up-4 w-full max-w-160">
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
                placeholder="Cari judul buku, penulis, atau genre…"
                autocomplete="off"
            >
            <button id="search-btn"
                    class="m-[0.45rem] shrink-0 px-6 py-[0.65rem] bg-primary text-white font-sans text-[0.88rem] font-semibold border-none rounded-md cursor-pointer transition-all duration-200 shadow hover:bg-[#033370] hover:scale-[1.02] hover:shadow-md">
                <span class="max-sm:hidden">Cari Buku</span>
                <span class="hidden max-sm:inline text-base">→</span>
            </button>
        </div>

        {{-- Filter chips --}}
        <div class="animate-fade-up-5 flex flex-wrap gap-2 justify-center mt-4">
            @foreach (['Semua', 'Novel', 'Sains', 'Sejarah', 'Teknologi', 'Anak-anak'] as $genre)
                <span
                    data-genre="{{ $genre }}"
                    class="chip px-[0.95rem] py-[0.35rem] border border-primary-100 rounded-full text-[0.78rem] font-medium text-neutral-500 bg-white/70 cursor-pointer transition-all duration-200 hover:bg-primary hover:text-white hover:border-primary">
                    {{ $genre }}
                </span>
            @endforeach
        </div>
    </div>

    {{-- ══ KATALOG SECTION ══ --}}
    <div id="katalog-section" class="w-full max-w-6xl mt-14">

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
            <p class="text-sm text-neutral-400">Coba kata kunci lain atau pilih genre yang berbeda</p>
        </div>

        {{-- Grid buku --}}
        <div id="katalog-grid" class="grid gap-5" style="grid-template-columns: repeat(3, 1fr);"></div>

    </div>
    {{-- /KATALOG SECTION --}}

</section>