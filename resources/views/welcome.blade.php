<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPETUK - Sistem Penukaran Buku</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --white:      #ffffff;
            --bg:         #F0F5FB;
            --ink:        #0B1F3A;
            --navy:       #04448D;
            --navy-dark:  #033370;
            --navy-deep:  #02265A;
            --sky:        #1A72C7;
            --sky-lt:     #E8F1FB;
            --gold:       #F0A500;
            --gold-lt:    #FFC840;
            --muted:      #4A6B8A;
            --border:     rgba(4,68,141,0.15);
            --shadow:     0 4px 32px rgba(4,68,141,0.12);
            --nav-h:      68px;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image:
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Ccircle cx='1' cy='1' r='0.6' fill='%2304448D' fill-opacity='0.06'/%3E%3C/svg%3E");
            pointer-events: none; z-index: 0;
        }

        /* ── Navbar ── */
        nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            height: var(--nav-h);
            background: rgba(255,255,255,0.94);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center;
            padding: 0 clamp(1rem, 5vw, 3rem);
            box-shadow: 0 2px 16px rgba(4,68,141,0.07);
        }

        .nav-inner {
            width: 100%; max-width: 1280px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            gap: 1rem;
        }

        .logo {
            display: flex; align-items: center; gap: 0.65rem;
            text-decoration: none; flex-shrink: 0;
        }
        .logo-icon {
            width: 38px; height: 38px;
            background: var(--navy);
            border-radius: 9px;
            display: grid; place-items: center;
        }
        .logo-icon svg { width: 20px; height: 20px; fill: var(--white); }
        .logo-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 800; font-size: 1.45rem;
            color: var(--navy); letter-spacing: 0.05em;
            line-height: 1;
        }
        .logo-sub {
            font-size: 0.57rem; font-weight: 500; letter-spacing: 0.13em;
            color: var(--muted); text-transform: uppercase;
            display: block; margin-top: 3px;
        }

        .btn-login {
            display: inline-flex; align-items: center; gap: 0.45rem;
            padding: 0.55rem 1.3rem;
            background: var(--navy);
            color: var(--white);
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem; font-weight: 600;
            border: none; border-radius: 8px;
            cursor: pointer; text-decoration: none;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            white-space: nowrap;
            box-shadow: 0 2px 10px rgba(4,68,141,0.25);
        }
        .btn-login:hover {
            background: var(--navy-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(4,68,141,0.35);
        }
        .btn-login svg { width: 15px; height: 15px; stroke: currentColor; fill: none; }

        /* ── Hero ── */
        .hero {
            position: relative; z-index: 1;
            min-height: 100vh;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: calc(var(--nav-h) + 2rem) 1.5rem 4rem;
            text-align: center;
        }

        .hero::after {
            content: '';
            position: absolute;
            width: clamp(400px, 70vw, 860px);
            height: clamp(400px, 70vw, 860px);
            background: radial-gradient(circle, rgba(4,68,141,0.10) 0%, transparent 68%);
            border-radius: 50%;
            pointer-events: none;
            animation: pulse 6s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1);    opacity: 1; }
            50%       { transform: scale(1.06); opacity: 0.65; }
        }

        .hero-eyebrow {
            font-size: 0.72rem; font-weight: 600; letter-spacing: 0.22em;
            text-transform: uppercase; color: var(--sky);
            margin-bottom: 1.2rem;
            display: flex; align-items: center; gap: 0.75rem;
            animation: fadeUp 0.7s ease both;
        }
        .hero-eyebrow::before,
        .hero-eyebrow::after {
            content: ''; display: block;
            width: 36px; height: 1.5px; background: var(--sky);
            border-radius: 2px;
        }

        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(2.4rem, 7vw, 5rem);
            font-weight: 800; line-height: 1.1;
            color: var(--ink); margin-bottom: 1.2rem;
            animation: fadeUp 0.7s 0.1s ease both;
        }
        .hero-title span { color: var(--navy); }

        .hero-desc {
            max-width: 520px; font-size: 1rem; line-height: 1.78;
            color: var(--muted); font-weight: 400;
            margin-bottom: 3rem;
            animation: fadeUp 0.7s 0.2s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Search Bar ── */
        .search-wrap {
            width: 100%; max-width: 640px;
            animation: fadeUp 0.7s 0.3s ease both;
        }

        .search-box {
            position: relative; display: flex; align-items: center;
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--shadow);
            transition: box-shadow 0.25s, border-color 0.25s;
            overflow: hidden;
        }
        .search-box:focus-within {
            border-color: var(--navy);
            box-shadow: var(--shadow), 0 0 0 4px rgba(4,68,141,0.12);
        }

        .search-icon {
            flex-shrink: 0; padding: 0 1rem 0 1.25rem;
            display: grid; place-items: center;
            color: var(--muted);
        }
        .search-icon svg { width: 20px; height: 20px; stroke: currentColor; fill: none; }

        .search-input {
            flex: 1; border: none; outline: none;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem; font-weight: 400;
            color: var(--ink);
            background: transparent;
            padding: 1rem 0;
        }
        .search-input::placeholder { color: var(--muted); }

        .search-btn {
            margin: 0.45rem; flex-shrink: 0;
            padding: 0.65rem 1.5rem;
            background: var(--navy);
            color: var(--white);
            font-family: 'Poppins', sans-serif;
            font-size: 0.88rem; font-weight: 600;
            border: none; border-radius: 10px;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(4,68,141,0.3);
        }
        .search-btn:hover {
            background: var(--navy-dark);
            transform: scale(1.02);
            box-shadow: 0 4px 14px rgba(4,68,141,0.4);
        }

        /* Filter chips */
        .filter-chips {
            display: flex; flex-wrap: wrap; gap: 0.5rem;
            justify-content: center; margin-top: 1rem;
            animation: fadeUp 0.7s 0.4s ease both;
        }
        .chip {
            padding: 0.35rem 0.95rem;
            border: 1px solid var(--border);
            border-radius: 20px; font-size: 0.78rem; font-weight: 500;
            color: var(--muted); background: rgba(255,255,255,0.7);
            cursor: pointer; transition: all 0.2s;
        }
        .chip:hover, .chip.active {
            background: var(--navy); color: var(--white);
            border-color: var(--navy);
        }

        /* ── Stats Strip ── */
        .stats {
            position: relative; z-index: 1;
            display: flex; flex-wrap: wrap; justify-content: center; gap: 1px;
            background: var(--border);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }
        .stat-item {
            flex: 1; min-width: 160px;
            background: var(--white);
            padding: 1.75rem 2rem;
            text-align: center;
            transition: background 0.2s;
        }
        .stat-item:hover { background: var(--sky-lt); }
        .stat-num {
            font-family: 'Poppins', sans-serif;
            font-size: 2.1rem; font-weight: 800;
            color: var(--navy);
        }
        .stat-label {
            font-size: 0.78rem; font-weight: 500; letter-spacing: 0.08em;
            text-transform: uppercase; color: var(--muted);
            margin-top: 0.3rem;
        }

        /* ── Footer ── */
        .footer-hint {
            position: relative; z-index: 1;
            text-align: center; padding: 1.5rem;
            font-size: 0.75rem; color: var(--muted);
            border-top: 1px solid var(--border);
            background: var(--white);
        }

        /* ── Responsive ── */
        @media (max-width: 600px) {
            .search-btn span { display: none; }
            .search-btn::after { content: '→'; font-size: 1rem; }
            .stat-item { min-width: 120px; padding: 1.25rem; }
            .stat-num { font-size: 1.6rem; }
        }
        @media (max-width: 400px) {
            .logo-sub { display: none; }
            .hero-title { font-size: 2rem; }
        }
    </style>
</head>
<body>

    {{-- ══════════════════ NAVBAR ══════════════════ --}}
    <nav>
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="logo">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24"><path d="M4 4h4v16H4zM10 4h10v3H10zM10 10h7v3H10zM10 17h10v3H10z"/></svg>
                </div>
                <div>
                    <span class="logo-text">SIPETUK</span>
                    <span class="logo-sub">Sistem Penukaran Buku</span>
                </div>
            </a>

            <a href="{{ route('admin.login') }}" class="btn-login">
                <svg viewBox="0 0 24 24" stroke-width="2">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
                <span>Login Admin</span>
            </a>
        </div>
    </nav>

    {{-- ══════════════════ HERO ══════════════════ --}}
    <section class="hero">
        <p class="hero-eyebrow">Perpustakaan Kota Yogyakarta</p>

        <h1 class="hero-title">
            Tukarkan Buku,<br>
            <span>Perluas Wawasan</span>
        </h1>

        <p class="hero-desc">
            Temukan buku yang kamu inginkan, ajukan penukaran, dan nikmati
            koleksi baru tanpa biaya.
        </p>

        <div class="search-wrap">
            <form action="{{ route('katalog.cari') }}" method="GET">
                @csrf
                <div class="search-box">
                    <span class="search-icon">
                        <svg viewBox="0 0 24 24" stroke-width="2">
                            <circle cx="11" cy="11" r="7"/>
                            <path d="M21 21l-4.35-4.35" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <input
                        type="text"
                        name="q"
                        class="search-input"
                        placeholder="Cari judul buku, penulis, atau genre…"
                        value="{{ request('q') }}"
                        autocomplete="off"
                    >
                    <button type="submit" class="search-btn">
                        <span>Cari Buku</span>
                    </button>
                </div>
            </form>

            <div class="filter-chips">
                @foreach (['Semua', 'Novel', 'Sains', 'Sejarah', 'Teknologi', 'Anak-anak'] as $genre)
                    <span class="chip {{ request('genre') == $genre ? 'active' : '' }}"
                          onclick="setGenre('{{ $genre }}')">
                        {{ $genre }}
                    </span>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════ STATS ══════════════════ --}}
    <div class="stats">
        <div class="stat-item">
            <div class="stat-num">{{ number_format($totalBuku ?? 1240) }}</div>
            <div class="stat-label">Koleksi Buku</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">{{ number_format($totalAnggota ?? 380) }}</div>
            <div class="stat-label">Anggota Aktif</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">{{ number_format($totalTukar ?? 2100) }}</div>
            <div class="stat-label">Penukaran Berhasil</div>
        </div>
    </div>

    <p class="footer-hint">© {{ date('Y') }} SIPETUK · Perpustakaan Buku Gratis</p>

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