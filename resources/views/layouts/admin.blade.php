<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - @yield('title', 'Perpustakaan')</title>
    <style>
        [x-cloak] { display: none !important; }
        body { visibility: hidden; }
    </style>
    <script>
        (function() {
            const isOpen = localStorage.getItem('sidebarOpen') !== 'false';
            document.documentElement.style.setProperty('--sidebar-w', isOpen ? '16rem' : '4.5rem');
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-neutral-100 flex h-screen overflow-hidden custom-scroll">

    @include('components.admin.sidebar')

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <header class="h-16 bg-white border-b border-neutral-200 flex items-center justify-between px-6 shrink-0 shadow-sm">
            <div>
                <h1 class="text-neutral-800 font-semibold text-base">@yield('page-title', 'Dashboard')</h1>
                <p class="text-neutral-500 text-xs">@yield('page-subtitle', 'Selamat datang di panel admin')</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="relative w-9 h-9 flex items-center justify-center rounded-xl border border-neutral-200 text-neutral-500 hover:text-primary-600 hover:border-primary-300 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                </button>
                <div class="text-right hidden sm:block">
                    <p class="text-neutral-700 text-xs font-medium">{{ now()->translatedFormat('l') }}</p>
                    <p class="text-neutral-400 text-xs">{{ now()->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 custom-scroll">
            @yield('content')
        </main>

    </div>
    @if (session('permission_denied'))
    <div id="modalDenied"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">
        <div class="relative w-full max-w-sm rounded-xl bg-white border border-neutral-200 overflow-hidden shadow-lg">
            <div class="absolute top-0 left-0 right-0 h-0.5 bg-danger-400"></div>
            <div class="px-6 py-5 flex flex-col items-center gap-3 text-center">
                <div class="w-10 h-10 rounded-full bg-danger-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-danger-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-neutral-800">Akses Ditolak</p>
                    <p class="text-xs text-neutral-400 mt-1">{{ session('permission_denied') }}</p>
                </div>
                <button onclick="document.getElementById('modalDenied').remove()"
                        class="px-4 py-2 text-xs font-medium rounded-lg bg-danger-500 text-white hover:bg-danger-600 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif

    @stack('scripts')
    <script>
        document.body.style.visibility = 'visible';
    </script>
</body>
</html>