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
        @keyframes spin { to { transform: rotate(360deg); } }

        .animate-fade-up-1 { animation: fadeUp 0.7s 0.0s ease both; }
        .animate-fade-up-2 { animation: fadeUp 0.7s 0.1s ease both; }
        .animate-fade-up-3 { animation: fadeUp 0.7s 0.2s ease both; }
        .animate-fade-up-4 { animation: fadeUp 0.7s 0.3s ease both; }
        .animate-fade-up-5 { animation: fadeUp 0.7s 0.4s ease both; }

        .hero-glow { animation: pulse-glow 6s ease-in-out infinite; }

        .search-box:focus-within {
            border-color: var(--color-primary);
            box-shadow: 0 4px 32px color-mix(in srgb, var(--color-primary) 12%, transparent),
                        0 0 0 4px color-mix(in srgb, var(--color-primary) 12%, transparent);
        }

        #katalog-section         { display: none; animation: fadeIn 0.45s ease both; }
        #katalog-section.visible { display: block; }

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

        .spinner {
            width: 36px; height: 36px;
            border: 3px solid color-mix(in srgb, var(--color-primary) 15%, transparent);
            border-top-color: var(--color-primary);
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        #timeline-container {
            -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 25%, black 75%, transparent 100%);
            mask-image:         linear-gradient(to bottom, transparent 0%, black 25%, black 75%, transparent 100%);
        }
        #timeline-container::-webkit-scrollbar { display: none; }

        [id^="event-"] {
            transition: opacity 0.45s cubic-bezier(0.25, 0.1, 0.25, 1),
                        transform 0.45s cubic-bezier(0.25, 0.1, 0.25, 1);
            will-change: opacity, transform;
        }
        .timeline-scroll-item {
            border-top: 1px solid transparent;
            border-bottom: 1px solid transparent;
            border-left: none; border-right: none; border-radius: 0;
            transition: border-color 0.35s ease, transform 0.35s ease;
        }

        #dropdown-kategori,
        #dropdown-lokasi {
            animation: fadeIn 0.18s ease both;
            z-index: 9999 !important;
        }

        #dropdown-kategori-wrapper,
        #dropdown-lokasi-wrapper {
            position: relative;
            z-index: 100;
        }

        .animate-fade-up-5 {
            position: relative;
            z-index: 9999;
        }

        #katalog-grid > div {
            transform: none;
            will-change: auto;
        }

        /* Cover buku: wrapper dengan tinggi tetap, gambar contain di dalamnya */
        .book-cover-wrap {
            width: 100%;
            height: 260px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(var(--color-primary-50), 0.6);
        }
        .book-cover-wrap img {
            height: 100%;
            width: auto;
            max-width: 100%;
            object-fit: contain;
        }
        .book-cover-placeholder {
            width: 100%;
            height: 260px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f5fb;
        }
    </style>
</head>

<body class="font-sans bg-primary-50 text-primary-900 min-h-screen overflow-x-hidden relative custom-scroll">

    @include('components.home.navbar')
    @include('components.home.hero-search')
    @include('components.home.buku-terbaru')
    @include('components.home.stats-strip')
    @include('components.home.kegiatan')
    @include('components.home.footer')

    <script>
    (() => {
        const searchInput    = document.getElementById('search-input');
        const searchBtn      = document.getElementById('search-btn');
        const katalogSection = document.getElementById('katalog-section');
        const katalogGrid    = document.getElementById('katalog-grid');
        const katalogTitle   = document.getElementById('katalog-title');
        const katalogLoading = document.getElementById('katalog-loading');
        const katalogEmpty   = document.getElementById('katalog-empty');
        const katalogClose   = document.getElementById('katalog-close');
        const resetFilter    = document.getElementById('reset-filter');

        let activeKategori    = '';
        let activeLokasi      = '';
        let activeLokasiLabel = '';
        let searchTimeout     = null;

        // ── Dropdown toggle ───────────────────────────────────────────────
        window.toggleDropdown = function (type) {
            const dropdown = document.getElementById(`dropdown-${type}`);
            const chevron  = document.getElementById(`chevron-${type}`);
            const isHidden = dropdown.classList.contains('hidden');

            ['kategori', 'lokasi'].forEach(t => {
                document.getElementById(`dropdown-${t}`).classList.add('hidden');
                document.getElementById(`chevron-${t}`).classList.remove('rotate-180');
            });

            if (isHidden) {
                dropdown.classList.remove('hidden');
                chevron.classList.add('rotate-180');
            }
        };

        // Tutup dropdown saat klik di luar
        document.addEventListener('click', (e) => {
            ['kategori', 'lokasi'].forEach(type => {
                const wrapper = document.getElementById(`dropdown-${type}-wrapper`);
                if (wrapper && !wrapper.contains(e.target)) {
                    document.getElementById(`dropdown-${type}`).classList.add('hidden');
                    document.getElementById(`chevron-${type}`).classList.remove('rotate-180');
                }
            });
        });

        // ── Pilih Kategori ────────────────────────────────────────────────
        document.querySelectorAll('.dropdown-item-kategori').forEach(item => {
            item.addEventListener('click', () => {
                activeKategori = item.dataset.value;
                document.getElementById('label-kategori').textContent =
                    activeKategori ? activeKategori : 'Kategori';

                document.querySelectorAll('.dropdown-item-kategori').forEach(i =>
                    i.classList.remove('text-primary', 'font-semibold', 'bg-primary-50'));
                item.classList.add('text-primary', 'font-semibold', 'bg-primary-50');

                const btn = document.getElementById('dropdown-kategori-btn');
                btn.classList.toggle('bg-primary-50',    !!activeKategori);
                btn.classList.toggle('text-primary-700', !!activeKategori);
                btn.classList.toggle('border-primary',   !!activeKategori);
                btn.classList.toggle('font-semibold',    !!activeKategori);

                document.getElementById('dropdown-kategori').classList.add('hidden');
                document.getElementById('chevron-kategori').classList.remove('rotate-180');

                updateResetBtn();
                triggerSearch();
            });
        });

        // ── Pilih Lokasi ──────────────────────────────────────────────────
        document.querySelectorAll('.dropdown-item-lokasi').forEach(item => {
            item.addEventListener('click', () => {
                activeLokasi      = item.dataset.value;
                activeLokasiLabel = item.dataset.label ?? '';
                document.getElementById('label-lokasi').textContent =
                    activeLokasi ? activeLokasiLabel : 'Lokasi';

                document.querySelectorAll('.dropdown-item-lokasi').forEach(i =>
                    i.classList.remove('text-primary', 'font-semibold', 'bg-primary-50'));
                item.classList.add('text-primary', 'font-semibold', 'bg-primary-50');

                const btn = document.getElementById('dropdown-lokasi-btn');
                btn.classList.toggle('bg-primary-50',    !!activeLokasi);
                btn.classList.toggle('text-primary-700', !!activeLokasi);
                btn.classList.toggle('border-primary',   !!activeLokasi);
                btn.classList.toggle('font-semibold',    !!activeLokasi);

                document.getElementById('dropdown-lokasi').classList.add('hidden');
                document.getElementById('chevron-lokasi').classList.remove('rotate-180');

                updateResetBtn();
                triggerSearch();
            });
        });

        // ── Reset filter ──────────────────────────────────────────────────
        resetFilter?.addEventListener('click', () => {
            activeKategori    = '';
            activeLokasi      = '';
            activeLokasiLabel = '';

            document.getElementById('label-kategori').textContent = 'Kategori';
            document.getElementById('label-lokasi').textContent   = 'Lokasi';

            ['kategori', 'lokasi'].forEach(type => {
                const btn = document.getElementById(`dropdown-${type}-btn`);
                btn.classList.remove('bg-primary', 'text-white', 'border-primary');
                document.querySelectorAll(`.dropdown-item-${type}`).forEach(i =>
                    i.classList.remove('text-primary', 'font-semibold', 'bg-primary-50'));
            });

            updateResetBtn();

            const q = searchInput.value.trim();
            if (q) triggerSearch();
            else hideKatalog();
        });

        function updateResetBtn() {
            if (!resetFilter) return;
            if (activeKategori || activeLokasi) {
                resetFilter.classList.remove('hidden');
                resetFilter.classList.add('flex');
            } else {
                resetFilter.classList.add('hidden');
                resetFilter.classList.remove('flex');
            }
        }

        // ── Search triggers ───────────────────────────────────────────────
        searchBtn.addEventListener('click', () => triggerSearch());

        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') triggerSearch();
        });

        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            const q = searchInput.value.trim();
            if (!q && !activeKategori && !activeLokasi) { hideKatalog(); return; }
            searchTimeout = setTimeout(() => triggerSearch(), 400);
        });

        katalogClose.addEventListener('click', () => {
            hideKatalog();
            searchInput.value = '';
            activeKategori    = '';
            activeLokasi      = '';
            activeLokasiLabel = '';
            document.getElementById('label-kategori').textContent = 'Kategori';
            document.getElementById('label-lokasi').textContent   = 'Lokasi';
            ['kategori', 'lokasi'].forEach(type => {
                document.getElementById(`dropdown-${type}-btn`)
                    .classList.remove('bg-primary', 'text-white', 'border-primary');
            });
            updateResetBtn();
        });

        function triggerSearch() {
            const q = searchInput.value.trim();
            if (!q && !activeKategori && !activeLokasi) { hideKatalog(); return; }

            ['kategori', 'lokasi'].forEach(t => {
                document.getElementById(`dropdown-${t}`)?.classList.add('hidden');
                document.getElementById(`chevron-${t}`)?.classList.remove('rotate-180');
            });

            doSearch(q, activeKategori, activeLokasi);
        }

        // ── Fetch ─────────────────────────────────────────────────────────
        async function doSearch(q, kategori, lokasi) {
            showLoading();
            const params = new URLSearchParams();
            if (q)        params.set('q', q);
            if (kategori) params.set('kategori', kategori);
            if (lokasi)   params.set('lokasi_id', lokasi);
            try {
                const res  = await fetch(`/search-buku?${params.toString()}`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                const json = await res.json();
                renderKatalog(json, q, kategori, lokasi);
            } catch (err) {
                console.error('Search error:', err);
                showEmpty();
            }
        }

        function renderKatalog(json, q, kategori, lokasi) {
            hideLoading();

            const parts = [];
            if (q)        parts.push(`"${q}"`);
            if (kategori) parts.push(kategori);
            if (lokasi)   parts.push(activeLokasiLabel);
            const total = json.total ?? json.meta?.total ?? json.data?.length ?? 0;
            katalogTitle.textContent = (parts.length ? parts.join(' · ') : 'Semua Buku')
                + `  —  ${total} buku ditemukan`;

            if (!json.data || json.data.length === 0) { showEmpty(); return; }
            katalogEmpty.classList.add('hidden');
            katalogEmpty.classList.remove('flex');

            katalogGrid.innerHTML = json.data.map((buku, i) => `
            <div class="book-card-stagger-${Math.min(i + 1, 12)} flex flex-col bg-white border border-primary-100 rounded-xl overflow-hidden cursor-pointer transition-all duration-200 hover:-translate-y-1 hover:border-primary-200 snap-start shrink-0 w-44 sm:w-52"
                style="animation: fadeIn 0.4s ease both;">

                ${buku.cover_url
                    ? `<div class="w-full bg-primary-50/60 flex items-center justify-center" style="height:160px;">
                        <img src="${escHtml(buku.cover_url)}" alt="Cover ${escHtml(buku.judul)}"
                                class="h-full w-auto max-w-full object-contain">
                    </div>`
                    : `<div class="w-full bg-primary-50 flex items-center justify-center" style="height:160px;">
                        <svg class="w-8 h-8 stroke-current fill-none" style="color:#c7d9ef;" viewBox="0 0 24 24" stroke-width="1.3">
                            <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>
                        </svg>
                    </div>`
                }

                <div class="flex flex-col p-3 flex-1">
                    <div class="flex items-start justify-between gap-1 mb-2">
                        <span class="inline-block text-[0.5rem] font-semibold tracking-wide uppercase px-2 py-0.5 rounded-full bg-primary-50 text-primary">
                            ${escHtml(buku.kategori ?? 'Umum')}
                        </span>
                        <span class="text-[0.65rem] font-medium text-neutral-400 shrink-0">${escHtml(String(buku.tahun_terbit ?? ''))}</span>
                    </div>
                    <h3 class="font-bold text-[0.85rem] leading-snug text-primary-900 mb-1">${escHtml(buku.judul)}</h3>
                    <p class="text-[0.75rem] font-medium text-neutral-500 mb-2">${escHtml(buku.pengarang)}</p>
                    <div class="flex flex-col gap-1 mt-auto pt-2 border-t border-primary-50">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full ${buku.stok > 0 ? 'bg-emerald-400' : 'bg-red-400'}"></span>
                            <span class="text-[0.7rem] font-medium ${buku.stok > 0 ? 'text-emerald-600' : 'text-red-500'}">
                                ${buku.stok > 0 ? `Stok ${buku.stok}` : 'Habis'}
                            </span>
                        </div>
                        ${buku.lokasi ? `
                        <div class="flex items-center gap-1 text-[0.65rem] text-neutral-400">
                            <svg class="w-3 h-3 stroke-current fill-none shrink-0" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                <circle cx="12" cy="9" r="2.5"/>
                            </svg>
                            <span>${escHtml(buku.lokasi)}</span>
                        </div>` : ''}
                    </div>
                </div>
            </div>
        `).join('');

            showKatalog();
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
            katalogGrid.className = 'flex gap-4 overflow-x-auto pb-3 -mx-4 px-4 snap-x snap-mandatory scrollbar-hide';
            document.getElementById('buku-terbaru-section')?.classList.add('hidden');
        }

        function hideKatalog() {
            katalogSection.classList.remove('visible');
            katalogGrid.innerHTML = '';
            katalogGrid.className = 'flex gap-4 overflow-x-auto pb-3 -mx-4 px-4 snap-x snap-mandatory scrollbar-hide';
            document.getElementById('buku-terbaru-section')?.classList.remove('hidden');
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