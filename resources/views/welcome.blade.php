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
        .hero-glow { animation: pulse-glow 6s ease-in-out infinite; }
        .search-box:focus-within {
            border-color: #04448D;
            box-shadow: 0 4px 32px rgba(4,68,141,0.12), 0 0 0 4px rgba(4,68,141,0.12);
        }
    </style>
</head>
<body class="font-sans bg-primary-50 text-primary-900 min-h-screen overflow-x-hidden relative">

    @include('components.home.navbar')

    @include('components.home.hero-search')

    @include('components.home.stats-strip')

    @include('components.home.footer')

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