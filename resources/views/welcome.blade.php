<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPETUK - Sistem Penukaran Buku</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html { scroll-behavior: smooth; }
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Ccircle cx='1' cy='1' r='0.6' fill='%2304448D' fill-opacity='0.06'/%3E%3C/svg%3E");
            pointer-events: none; z-index: 0;
        }
        @keyframes pulse-glow {
            0%, 100% { transform: scale(1); opacity: 1; }
            50%       { transform: scale(1.06); opacity: 0.65; }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up-1 { animation: fadeUp 0.7s 0.0s ease both; }
        .animate-fade-up-2 { animation: fadeUp 0.7s 0.1s ease both; }
        .animate-fade-up-3 { animation: fadeUp 0.7s 0.2s ease both; }
        .animate-fade-up-4 { animation: fadeUp 0.7s 0.3s ease both; }
        .animate-fade-up-5 { animation: fadeUp 0.7s 0.4s ease both; }
        .hero-glow { animation: pulse-glow 6s ease-in-out infinite; }
        .search-box:focus-within {
            border-color: #04448D;
            box-shadow: 0 4px 32px rgba(4,68,141,0.12), 0 0 0 4px rgba(4,68,141,0.12);
        }

        /* ── Katalog section ── */
        #katalog-section {
            display: none;
            animation: fadeIn 0.45s ease both;
        }
        #katalog-section.visible {
            display: block;
        }
        .book-card {
            background: #fff;
            border: 1px solid rgba(4,68,141,0.09);
            border-radius: 14px;
            padding: 1.75rem 1.85rem;
            transition: box-shadow 0.22s ease, transform 0.22s ease, border-color 0.22s ease;
            cursor: pointer;
            animation: fadeIn 0.4s ease both;
        }
        .book-card:hover {
            box-shadow: 0 8px 32px rgba(4,68,141,0.13);
            transform: translateY(-3px);
            border-color: rgba(4,68,141,0.22);
        }
        .book-card-stagger-1  { animation-delay: 0.04s; }
        .book-card-stagger-2  { animation-delay: 0.08s; }
        .book-card-stagger-3  { animation-delay: 0.12s; }
        .book-card-stagger-4  { animation-delay: 0.16s; }
        .book-card-stagger-5  { animation-delay: 0.20s; }
        .book-card-stagger-6  { animation-delay: 0.24s; }
        .book-card-stagger-7  { animation-delay: 0.28s; }
        .book-card-stagger-8  { animation-delay: 0.32s; }
        .book-card-stagger-9  { animation-delay: 0.36s; }
        .book-card-stagger-10 { animation-delay: 0.40s; }
        .book-card-stagger-11 { animation-delay: 0.44s; }
        .book-card-stagger-12 { animation-delay: 0.48s; }

        /* Spinner */
        .spinner {
            width: 36px; height: 36px;
            border: 3px solid rgba(4,68,141,0.15);
            border-top-color: #04448D;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Badge kategori */
        .badge-kategori {
            display: inline-block;
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            background: rgba(4,68,141,0.08);
            color: #04448D;
        }

        /* ── Timeline scroll ── */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .timeline-scroll-item {
            border-top: 1px solid transparent;
            border-bottom: 1px solid transparent;
            border-left: none;
            border-right: none;
            border-radius: 0;
            transition: border-color 0.35s ease, transform 0.35s ease;
        }
        [id^="event-"] {
            transition: opacity 0.45s cubic-bezier(0.25, 0.1, 0.25, 1),
                        transform 0.45s cubic-bezier(0.25, 0.1, 0.25, 1);
            will-change: opacity, transform;
        }
        #timeline-container {
            -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 25%, black 75%, transparent 100%);
            mask-image: linear-gradient(to bottom, transparent 0%, black 25%, black 75%, transparent 100%);
        }
    </style>
</head>

<body class="font-sans bg-primary-50 text-primary-900 min-h-screen overflow-x-hidden relative">

    {{-- ══════════════════ NAVBAR ══════════════════ --}}
    <nav class="fixed top-0 left-0 right-0 z-50 h-17 bg-white/94 backdrop-blur-md border-b border-primary-100 flex items-center px-[clamp(1rem,5vw,3rem)] shadow-sm">
        <div class="w-full max-w-7xl mx-auto flex items-center justify-between gap-4">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 no-underline shrink-0">
                <div class="w-9.5 h-9.5 bg-primary rounded-[9px] grid place-items-center">
                    <svg class="w-5 h-5 fill-white" viewBox="0 0 24 24">
                        <path d="M4 4h4v16H4zM10 4h10v3H10zM10 10h7v3H10zM10 17h10v3H10z"/>
                    </svg>
                </div>
                <div>
                    <span class="font-extrabold text-[1.45rem] text-primary tracking-wider leading-none block">SIPETUK</span>
                    <span class="text-[0.57rem] font-medium tracking-[0.13em] text-neutral-500 uppercase block mt-0.75">Sistem Penukaran Buku</span>
                </div>
            </a>
            <a href="{{ route('auth.login') }}"
               class="inline-flex items-center gap-[0.45rem] px-5 py-[0.55rem] bg-primary text-white text-sm font-semibold rounded-lg border-none cursor-pointer no-underline transition-all duration-200 whitespace-nowrap shadow-md hover:bg-primary-700 hover:-translate-y-px hover:shadow-lg">
                <svg class="w-3.75 h-3.75 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
                <span>Login Admin</span>
            </a>
        </div>
    </nav>

    {{-- ══════════════════ HERO ══════════════════ --}}
    <section class="relative z-10 min-h-screen flex flex-col items-center justify-center pt-25 pb-16 px-6 text-center">

        <div class="hero-glow absolute w-[clamp(400px,70vw,860px)] h-[clamp(400px,70vw,860px)] rounded-full pointer-events-none"
             style="background: radial-gradient(circle, rgba(4,68,141,0.10) 0%, transparent 68%);">
        </div>

        <p class="animate-fade-up-1 text-[0.72rem] font-semibold tracking-[0.22em] uppercase text-primary-500 mb-5 flex items-center gap-3">
            <span class="block w-9 h-[1.5px] bg-primary-500 rounded"></span>
            Perpustakaan Kota Yogyakarta
            <span class="block w-9 h-[1.5px] bg-primary-500 rounded"></span>
        </p>

        <h1 class="animate-fade-up-2 font-extrabold leading-[1.1] text-primary-900 mb-5"
            style="font-size: clamp(2.4rem, 7vw, 5rem);">
            Tukarkan Buku,<br>
            <span class="text-primary">Perluas Wawasan</span>
        </h1>

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
                        class="m-[0.45rem] shrink-0 px-6 py-[0.65rem] bg-primary text-white font-sans text-[0.88rem] font-semibold border-none rounded-md cursor-pointer transition-all duration-200 shadow hover:bg-primary-700 hover:scale-[1.02] hover:shadow-md">
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

        {{-- ══ KATALOG SECTION (muncul hanya saat ada query) ══ --}}
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
            <div id="katalog-grid" class="grid gap-5"
                 style="grid-template-columns: repeat(3, 1fr);">
            </div>

        </div>
        {{-- /KATALOG SECTION --}}

    </section>

    {{-- ══════════════════ STATS STRIP ══════════════════ --}}
    <div class="relative z-10 flex flex-wrap justify-center border-t border-b border-primary-100 bg-primary-100/50">
        <div class="flex-1 min-w-40 bg-white px-8 py-7 text-center transition-colors duration-200 border-r border-primary-100 hover:bg-primary-50">
            <div class="font-extrabold text-[2.1rem] text-primary">{{ number_format($totalBuku ?? 0) }}</div>
            <div class="text-[0.78rem] font-medium tracking-[0.08em] uppercase text-neutral-500 mt-1">Koleksi Buku</div>
        </div>
        <div class="flex-1 min-w-40 bg-white px-8 py-7 text-center transition-colors duration-200 border-r border-primary-100 hover:bg-primary-50">
            <div class="font-extrabold text-[2.1rem] text-primary">{{ number_format($totalAnggota ?? 0) }}</div>
            <div class="text-[0.78rem] font-medium tracking-[0.08em] uppercase text-neutral-500 mt-1">Anggota Aktif</div>
        </div>
        <div class="flex-1 min-w-40 bg-white px-8 py-7 text-center transition-colors duration-200 hover:bg-primary-50">
            <div class="font-extrabold text-[2.1rem] text-primary">{{ number_format($totalTukar ?? 0) }}</div>
            <div class="text-[0.78rem] font-medium tracking-[0.08em] uppercase text-neutral-500 mt-1">Penukaran Berhasil</div>
        </div>
    </div>

    {{-- ══════════════════ RENCANA KEGIATAN ══════════════════ --}}
    <section class="relative z-10 py-16 px-[clamp(1rem,5vw,3rem)] bg-white border-b border-primary-100">
        <div class="w-full max-w-4xl mx-auto">
            <div class="text-center mb-8">
                <p class="text-[0.70rem] font-semibold tracking-[0.22em] uppercase text-primary-500 mb-3 flex items-center justify-center gap-3">
                    <span class="block w-7 h-px bg-primary-400 rounded"></span>
                    Agenda Mendatang
                    <span class="block w-7 h-px bg-primary-400 rounded"></span>
                </p>
                <h2 class="font-extrabold text-primary-900 leading-tight mb-3"
                    style="font-size: clamp(1.6rem, 4vw, 2.4rem);">
                    Rencana <span class="text-primary">Kegiatan</span>
                </h2>
                <p class="text-neutral-400 text-sm max-w-xl mx-auto leading-relaxed">
                    Kami terus merancang berbagai kegiatan yang bermanfaat dan menyenangkan,
                    agar pembaca semakin bersemangat dalam mengeksplorasi buku.
                </p>
            </div>

            @php
                $namaBulan    = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
                $today        = now()->startOfDay();
                $closestIndex = 0;

                foreach ($kegiatan as $i => $item) {
                    $tgl = \Carbon\Carbon::parse($item->tanggal_mulai);
                    if ($tgl->gte($today)) { $closestIndex = $i; break; }
                }
            @endphp

            <div
                id="timeline-container"
                class="relative overflow-y-auto flex flex-col items-center gap-3 scrollbar-hide"
                style="height: 400px; padding: 120px 0; scroll-behavior: smooth; overscroll-behavior: contain;"
            >
                @forelse ($kegiatan as $index => $item)
                    @php
                        $tgl   = \Carbon\Carbon::parse($item->tanggal_mulai);
                        $judul = $item->nama_kegiatan;
                        $desc  = $item->deskripsi;

                        if      ($item->status === 'selesai')            $status = 'past';
                        elseif  ($item->status === 'sedang_berlangsung') $status = 'active';
                        else                                             $status = 'future';
                    @endphp
                    <div id="event-{{ $index }}"
                         class="w-full max-w-2xl shrink-0"
                         style="opacity: 0.3; transform: scale(0.9);">
                        <div class="timeline-scroll-item flex items-start gap-5 px-6 py-5">
                            <div class="shrink-0 text-center leading-none min-w-[52px]">
                                <span class="block font-extrabold text-[2.2rem] leading-none text-[#04448D]">{{ $tgl->format('d') }}</span>
                                <span class="block text-[0.68rem] font-semibold tracking-widest uppercase mt-0.5 text-[#3a7bd5]">{{ $namaBulan[$tgl->month - 1] }}</span>
                                <span class="block text-[0.62rem] font-medium text-[#a8c4e8] mt-0.5">{{ $tgl->format('Y') }}</span>
                            </div>
                            <div class="shrink-0 self-stretch w-px mx-1" style="background: rgba(4,68,141,0.18);"></div>
                            <div class="flex-1 min-w-0 pt-0.5">
{{-- SESUDAH --}}
                                @if ($status === 'active')
                                    <span class="inline-flex items-center gap-1.5 text-[0.63rem] font-semibold tracking-wider uppercase text-[#04448D] bg-blue-50 border border-blue-100 px-2.5 py-0.5 rounded-full mb-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#04448D] animate-pulse inline-block"></span>
                                        Sedang Berlangsung
                                    </span>
                                @elseif ($status === 'past')
                                    <span class="inline-flex items-center gap-1.5 text-[0.63rem] font-semibold tracking-wider uppercase text-neutral-400 bg-neutral-100 px-2.5 py-0.5 rounded-full mb-2">
                                        Telah Selesai
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-[0.63rem] font-semibold tracking-wider uppercase text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-0.5 rounded-full mb-2">
                                        Akan Berlangsung
                                    </span>
                                @endif
                                <h3 class="font-bold text-[1rem] leading-snug mb-1 text-[#04448D]">{{ $judul }}</h3>
                                <p class="text-[0.82rem] leading-relaxed text-[#3a7bd5]">{{ $desc }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-16 gap-3 text-center">
                        <p class="font-semibold text-primary-800">Belum ada kegiatan terjadwal</p>
                        <p class="text-sm text-neutral-400">Pantau terus halaman ini untuk informasi terbaru</p>
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    {{-- ══════════════════ FOOTER ══════════════════ --}}
    <footer class="relative z-10 text-center px-4 py-6 text-[0.75rem] text-neutral-400 border-t border-primary-100 bg-white">
        © {{ date('Y') }} SIPETUK · Perpustakaan Buku Gratis
    </footer>

    <script>
    /* ══════════════════════════════════════════════
       SEARCH & KATALOG LOGIC
    ══════════════════════════════════════════════ */
    (() => {
        const searchInput    = document.getElementById('search-input');
        const searchBtn      = document.getElementById('search-btn');
        const katalogSection = document.getElementById('katalog-section');
        const katalogGrid    = document.getElementById('katalog-grid');
        const katalogTitle   = document.getElementById('katalog-title');
        const katalogLoading = document.getElementById('katalog-loading');
        const katalogEmpty   = document.getElementById('katalog-empty');
        const katalogClose   = document.getElementById('katalog-close');
        const chips          = document.querySelectorAll('.chip');

        let activeGenre   = 'Semua';
        let searchTimeout = null;

        chips.forEach(chip => {
            chip.addEventListener('click', () => {
                chips.forEach(c => c.classList.remove('bg-primary','text-white','border-primary'));
                chip.classList.add('bg-primary','text-white','border-primary');
                activeGenre = chip.dataset.genre;
                const q = searchInput.value.trim();
                if (activeGenre === 'Semua' && !q) {
                    doSearch('', 'Semua');
                } else {
                    doSearch(q, activeGenre);
                }
            });
        });

        searchBtn.addEventListener('click', () => {
            const q = searchInput.value.trim();
            if (q || activeGenre !== 'Semua') doSearch(q, activeGenre);
        });

        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                const q = searchInput.value.trim();
                if (q || activeGenre !== 'Semua') doSearch(q, activeGenre);
            }
        });

        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            const q = searchInput.value.trim();
            if (!q && activeGenre === 'Semua') { hideKatalog(); return; }
            searchTimeout = setTimeout(() => doSearch(q, activeGenre), 400);
        });

        katalogClose.addEventListener('click', () => {
            hideKatalog();
            searchInput.value = '';
            activeGenre = 'Semua';
            chips.forEach(c => c.classList.remove('bg-primary','text-white','border-primary'));
        });

        async function doSearch(q, genre) {
            showLoading();
            const params = new URLSearchParams();
            if (q)                          params.set('q', q);
            if (genre && genre !== 'Semua') params.set('genre', genre);
            try {
                const res  = await fetch(`/search-buku?${params.toString()}`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                const json = await res.json();
                renderKatalog(json, q, genre);
            } catch (err) {
                console.error('Search error:', err);
                showEmpty();
            }
        }

        function renderKatalog(json, q, genre) {
            hideLoading();
            if (q && genre && genre !== 'Semua') {
                katalogTitle.textContent = `"${q}" · ${genre}  —  ${json.total} buku ditemukan`;
            } else if (q) {
                katalogTitle.textContent = `"${q}"  —  ${json.total} buku ditemukan`;
            } else if (genre && genre !== 'Semua') {
                katalogTitle.textContent = `Genre: ${genre}  —  ${json.total} buku ditemukan`;
            } else {
                katalogTitle.textContent = `Semua Buku  —  ${json.total} buku ditemukan`;
            }
            if (!json.data || json.data.length === 0) { showEmpty(); return; }
            katalogEmpty.classList.add('hidden');
            katalogEmpty.classList.remove('flex');
            katalogGrid.innerHTML = json.data.map((buku, i) => `
                <div class="book-card book-card-stagger-${Math.min(i + 1, 12)}">
                    <div class="flex items-start justify-between gap-2 mb-4">
                        <span class="badge-kategori">${escHtml(buku.kategori ?? 'Umum')}</span>
                        <span class="text-[0.75rem] font-medium text-neutral-400 shrink-0">${escHtml(String(buku.tahun_terbit ?? ''))}</span>
                    </div>
                    <h3 class="font-bold text-[1.05rem] leading-snug text-primary-900 mb-2 line-clamp-2">${escHtml(buku.judul)}</h3>
                    <p class="text-[0.83rem] font-medium text-neutral-500 mb-4">${escHtml(buku.pengarang)}</p>
                    <p class="text-[0.82rem] leading-relaxed text-neutral-400 line-clamp-4 mb-6">${escHtml(buku.resume ?? '')}</p>
                    <div class="flex items-center justify-between pt-4 border-t border-primary-50">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full ${buku.stok > 0 ? 'bg-emerald-400' : 'bg-red-400'}"></span>
                            <span class="text-[0.78rem] font-medium ${buku.stok > 0 ? 'text-emerald-600' : 'text-red-500'}">
                                ${buku.stok > 0 ? `Tersedia (${buku.stok})` : 'Habis'}
                            </span>
                        </div>
                        ${buku.lokasi ? `
                        <div class="flex items-center gap-1.5 text-[0.75rem] text-neutral-400">
                            <svg class="w-3.5 h-3.5 stroke-current fill-none shrink-0" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                <circle cx="12" cy="9" r="2.5"/>
                            </svg>
                            <span>${escHtml(buku.lokasi)}</span>
                        </div>` : ''}
                    </div>
                </div>
            `).join('');
            showKatalog();
            setTimeout(() => {
                katalogSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 80);
        }

        function showLoading() {
            katalogSection.classList.add('visible');
            katalogLoading.classList.remove('hidden');
            katalogLoading.classList.add('flex');
            katalogGrid.innerHTML = '';
            katalogEmpty.classList.add('hidden');
            katalogEmpty.classList.remove('flex');
        }
        function hideLoading() {
            katalogLoading.classList.add('hidden');
            katalogLoading.classList.remove('flex');
        }
        function showEmpty() {
            katalogSection.classList.add('visible');
            katalogEmpty.classList.remove('hidden');
            katalogEmpty.classList.add('flex');
            katalogGrid.innerHTML = '';
        }
        function showKatalog() {
            katalogSection.classList.add('visible');
        }
        function hideKatalog() {
            katalogSection.classList.remove('visible');
            katalogGrid.innerHTML = '';
        }
        function escHtml(str) {
            return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
        }
    })();

    /* ══════════════════════════════════════════════
       TIMELINE SCROLL LOGIC
    ══════════════════════════════════════════════ */
    document.addEventListener('DOMContentLoaded', () => {
        const closestIndex = {{ $closestIndex ?? 0 }};
        const container    = document.getElementById('timeline-container');
        const cards        = Array.from(container ? container.querySelectorAll('[id^="event-"]') : []);

        if (!container || cards.length === 0) return;

        const updateFocus = () => {
            const containerMid = container.scrollTop + container.clientHeight / 2;
            cards.forEach(card => {
                const cardMid  = card.offsetTop + card.offsetHeight / 2;
                const distance = Math.abs(cardMid - containerMid);
                const maxDist  = container.clientHeight / 2;
                const ratio    = Math.min(distance / maxDist, 1);
                const eased    = ratio * ratio * (3 - 2 * ratio);
                const scale    = (1 - eased * 0.13).toFixed(4);
                const opacity  = (1 - eased * 0.72).toFixed(4);
                const inner    = card.querySelector('.timeline-scroll-item');

                card.style.opacity   = opacity;
                card.style.transform = `scale(${scale})`;

                if (ratio < 0.22) {
                    inner.style.borderTopColor    = 'rgba(4, 68, 141, 0.30)';
                    inner.style.borderBottomColor = 'rgba(4, 68, 141, 0.30)';
                } else {
                    inner.style.borderTopColor    = 'transparent';
                    inner.style.borderBottomColor = 'transparent';
                }
                inner.style.background = 'transparent';
                inner.style.boxShadow  = 'none';
            });
        };

        const scrollToCard = (index) => {
            const target = cards[index];
            if (!target) return;
            const offset = target.offsetTop - container.clientHeight / 2 + target.offsetHeight / 2;
            container.scrollTo({ top: offset, behavior: 'smooth' });
        };

        let ticking = false;
        container.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(() => { updateFocus(); ticking = false; });
                ticking = true;
            }
        }, { passive: true });

        let snapTimer;
        container.addEventListener('scroll', () => {
            clearTimeout(snapTimer);
            snapTimer = setTimeout(() => {
                const containerMid = container.scrollTop + container.clientHeight / 2;
                let nearest = cards[0];
                let minDist = Infinity;
                cards.forEach(card => {
                    const dist = Math.abs(card.offsetTop + card.offsetHeight / 2 - containerMid);
                    if (dist < minDist) { minDist = dist; nearest = card; }
                });
                const snapOffset = nearest.offsetTop - container.clientHeight / 2 + nearest.offsetHeight / 2;
                container.scrollTo({ top: snapOffset, behavior: 'smooth' });
            }, 200);
        }, { passive: true });

        cards.forEach((card, i) => {
            card.style.opacity    = '0';
            card.style.transform  = 'scale(0.88) translateY(16px)';
            card.style.transition = 'opacity 0.55s ease, transform 0.55s ease';
            setTimeout(() => {
                card.style.opacity   = '1';
                card.style.transform = 'scale(1) translateY(0)';
            }, 120 * i + 80);
        });

        const animDuration = cards.length * 120 + 300;
        setTimeout(() => {
            scrollToCard(closestIndex);
            setTimeout(updateFocus, 500);
        }, animDuration);
    });
    </script>
</body>
</html>