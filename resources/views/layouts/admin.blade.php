<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - @yield('title', 'Perpustakaan')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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
     @stack('scripts')
</body>
</html>