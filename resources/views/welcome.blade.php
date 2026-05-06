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
        .animate-fade-up-1 { animation: fadeUp 0.7s 0.0s ease both; }
        .animate-fade-up-2 { animation: fadeUp 0.7s 0.1s ease both; }
        .animate-fade-up-3 { animation: fadeUp 0.7s 0.2s ease both; }
        .animate-fade-up-4 { animation: fadeUp 0.7s 0.3s ease both; }
        .animate-fade-up-5 { animation: fadeUp 0.7s 0.4s ease both; }
        .hero-glow {
            animation: pulse-glow 6s ease-in-out infinite;
        }
        .search-box:focus-within {
            border-color: #04448D;
            box-shadow: 0 4px 32px rgba(4,68,141,0.12), 0 0 0 4px rgba(4,68,141,0.12);
        }
    </style>
</head>
<body class="font-sans bg-primary-50 text-primary-900 min-h-screen overflow-x-hidden relative">

    {{-- ══════════════════ NAVBAR ══════════════════ --}}
    <nav class="fixed top-0 left-0 right-0 z-50 h-17 bg-white/94 backdrop-blur-md border-b border-primary-100 flex items-center px-[clamp(1rem,5vw,3rem)] shadow-sm">
        <div class="w-full max-w-7xl mx-auto flex items-center justify-between gap-4">

            {{-- Logo --}}
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

            {{-- Login Button --}}
            <a href="{{ route('admin.login') }}"
               class="inline-flex items-center gap-[0.45rem] px-5 py-[0.55rem] bg-primary text-white text-sm font-semibold rounded-lg border-none cursor-pointer no-underline transition-all duration-200 whitespace-nowrap shadow-md hover:bg-[#033370] hover:-translate-y-px hover:shadow-lg">
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
            <form action="{{ route('katalog.cari') }}" method="GET">
                @csrf
                <div class="search-box relative flex items-center bg-white border border-primary-100 rounded-lg shadow-lg transition-all duration-200 overflow-hidden">
                    <span class="shrink-0 px-4 pl-5 grid place-items-center text-neutral-400">
                        <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2">
                            <circle cx="11" cy="11" r="7"/>
                            <path d="M21 21l-4.35-4.35" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <input
                        type="text"
                        name="q"
                        class="flex-1 border-none outline-none font-sans text-[0.95rem] text-primary-900 bg-transparent py-4 placeholder-neutral-400"
                        placeholder="Cari judul buku, penulis, atau genre…"
                        value="{{ request('q') }}"
                        autocomplete="off"
                    >
                    <button type="submit"
                            class="m-[0.45rem] shrink-0 px-6 py-[0.65rem] bg-primary text-white font-sans text-[0.88rem] font-semibold border-none rounded-md cursor-pointer transition-all duration-200 shadow hover:bg-[#033370] hover:scale-[1.02] hover:shadow-md">
                        <span class="max-sm:hidden">Cari Buku</span>
                        <span class="hidden max-sm:inline text-base">→</span>
                    </button>
                </div>
            </form>

            {{-- Filter chips --}}
            <div class="animate-fade-up-5 flex flex-wrap gap-2 justify-center mt-4">
                @foreach (['Semua', 'Novel', 'Sains', 'Sejarah', 'Teknologi', 'Anak-anak'] as $genre)
                    <span
                        class="chip px-[0.95rem] py-[0.35rem] border border-primary-100 rounded-full text-[0.78rem] font-medium text-neutral-500 bg-white/70 cursor-pointer transition-all duration-200 hover:bg-primary hover:text-white hover:border-primary {{ request('genre') == $genre ? 'bg-primary text-white border-primary' : '' }}"
                        onclick="setGenre('{{ $genre }}')">
                        {{ $genre }}
                    </span>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════ STATS STRIP ══════════════════ --}}
    <div class="relative z-10 flex flex-wrap justify-center border-t border-b border-primary-100 bg-primary-100/50">
        <div class="flex-1 min-w-40 bg-white px-8 py-7 text-center transition-colors duration-200 border-r border-primary-100 hover:bg-primary-50">
            <div class="font-extrabold text-[2.1rem] text-primary">{{ number_format($totalBuku ?? 1240) }}</div>
            <div class="text-[0.78rem] font-medium tracking-[0.08em] uppercase text-neutral-500 mt-1">Koleksi Buku</div>
        </div>
        <div class="flex-1 min-w-40 bg-white px-8 py-7 text-center transition-colors duration-200 border-r border-primary-100 hover:bg-primary-50">
            <div class="font-extrabold text-[2.1rem] text-primary">{{ number_format($totalAnggota ?? 380) }}</div>
            <div class="text-[0.78rem] font-medium tracking-[0.08em] uppercase text-neutral-500 mt-1">Anggota Aktif</div>
        </div>
        <div class="flex-1 min-w-40 bg-white px-8 py-7 text-center transition-colors duration-200 hover:bg-primary-50">
            <div class="font-extrabold text-[2.1rem] text-primary">{{ number_format($totalTukar ?? 2100) }}</div>
            <div class="text-[0.78rem] font-medium tracking-[0.08em] uppercase text-neutral-500 mt-1">Penukaran Berhasil</div>
        </div>
    </div>

    {{-- ══════════════════ FOOTER ══════════════════ --}}
    <footer class="relative z-10 text-center px-4 py-6 text-[0.75rem] text-neutral-400 border-t border-primary-100 bg-white">
        © {{ date('Y') }} SIPETUK · Perpustakaan Buku Gratis
    </footer>

    <script>
        function setGenre(genre) {
            const url = new URL(window.location.href);
            url.searchParams.set('genre', genre === 'Semua' ? '' : genre);
            window.location.href = url.toString();
        }

        document.addEventListener('DOMContentLoaded', () => {
            const genre = new URLSearchParams(window.location.search).get('genre') || 'Semua';
            document.querySelectorAll('.chip').forEach(c => {
                c.classList.toggle('active', c.textContent.trim() === genre);
            });
        });
    </script>
</body>
</html>