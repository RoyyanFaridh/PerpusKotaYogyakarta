<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin – {{ config('app.name', 'SIPETUK') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
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
        .anim-1 { animation: fadeUp 0.7s 0.05s ease both; }
        .anim-2 { animation: fadeUp 0.7s 0.15s ease both; }
        .anim-3 { animation: fadeUp 0.7s 0.25s ease both; }
        .anim-4 { animation: fadeUp 0.7s 0.35s ease both; }
        .anim-5 { animation: fadeUp 0.7s 0.45s ease both; }
        .glow    { animation: pulse-glow 6s ease-in-out infinite; }
    </style>
</head>

<body class="font-sans bg-primary-50 text-primary-900 min-h-screen overflow-x-hidden relative flex flex-col">

    {{-- NAVBAR --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-primary-100 shadow-sm">
        <div class="w-full max-w-7xl mx-auto px-[clamp(1rem,5vw,3rem)] h-16 flex items-center justify-between gap-4">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 no-underline shrink-0">
                <div class="w-9 h-9 bg-primary rounded-[9px] grid place-items-center shadow-sm">
                    <svg class="w-5 h-5 fill-white" viewBox="0 0 24 24">
                        <path d="M4 4h4v16H4zM10 4h10v3H10zM10 10h7v3H10zM10 17h10v3H10z"/>
                    </svg>
                </div>
                <div>
                    <span class="font-extrabold text-[1.4rem] text-primary tracking-wider leading-none block">SIPETUK</span>
                    <span class="text-[0.57rem] font-medium tracking-[0.13em] text-neutral-400 uppercase block">Sistem Penukaran Buku</span>
                </div>
            </a>
            <a href="{{ url('/') }}"
               class="inline-flex items-center gap-2 px-4 py-2 border border-primary-100 text-primary text-sm font-semibold rounded-lg no-underline bg-white transition-all duration-200 hover:bg-primary-50 hover:border-primary-200">
                <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 5l-7 7 7 7"/>
                </svg>
                <span class="hidden sm:inline">Kembali ke Beranda</span>
            </a>
        </div>
    </nav>

    {{-- MAIN --}}
    <main class="relative z-10 flex-1 flex items-center justify-center pt-24 pb-12 px-4">

        <div class="glow absolute rounded-full pointer-events-none -z-10"
             style="width:clamp(360px,60vw,720px);height:clamp(360px,60vw,720px);background:radial-gradient(circle,rgba(4,68,141,0.09) 0%,transparent 68%);">
        </div>

        <div class="w-full max-w-md">

            <p class="anim-1 text-[0.70rem] font-semibold tracking-[0.22em] uppercase text-primary-500 mb-4 flex items-center justify-center gap-3">
                <span class="block w-7 h-px bg-primary-400 rounded"></span>
                Portal Admin
                <span class="block w-7 h-px bg-primary-400 rounded"></span>
            </p>

            <h1 class="anim-2 font-extrabold text-primary-900 text-center mb-2 leading-tight"
                style="font-size:clamp(1.9rem,5vw,2.8rem);">
                Masuk ke <span class="text-primary">SIPETUK</span>
            </h1>

            <p class="anim-3 text-center text-neutral-400 text-sm font-normal mb-8">
                Masukkan kredensial admin Anda untuk mengakses dashboard.
            </p>

            {{-- CARD --}}
            <div class="anim-4 bg-white/90 backdrop-blur-lg rounded-2xl border border-primary-100 shadow-xl p-8">

                @if (session('error'))
                    <div class="mb-5 flex items-start gap-3 px-4 py-3 rounded-lg bg-danger-50 border border-danger-100 text-danger-600 text-sm">
                        <svg class="w-4 h-4 mt-0.5 shrink-0 fill-current" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-.75-11.25a.75.75 0 011.5 0v4.5a.75.75 0 01-1.5 0v-4.5zm.75 7.5a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 flex items-start gap-3 px-4 py-3 rounded-lg bg-danger-50 border border-danger-100 text-danger-600 text-sm">
                        <svg class="w-4 h-4 mt-0.5 shrink-0 fill-current" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-.75-11.25a.75.75 0 011.5 0v4.5a.75.75 0 01-1.5 0v-4.5zm.75 7.5a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"/>
                        </svg>
                        <ul class="list-none space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('auth.login.post') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-[0.75rem] font-semibold tracking-widest text-primary-800 uppercase mb-1.5">
                            Email
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-300">
                                <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round">
                                    <rect x="2" y="4" width="20" height="16" rx="3"/>
                                    <path d="M2 7l10 7 10-7"/>
                                </svg>
                            </span>
                            <input
                                id="email" type="email" name="email"
                                value="{{ old('email') }}"
                                required autocomplete="email"
                                placeholder="admin@sipetuk.id"
                                class="w-full pl-10 pr-4 py-3 rounded-lg border bg-white font-sans text-[0.9rem] text-primary-900 placeholder-neutral-300 transition-all duration-200 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary-100 {{ $errors->has('email') ? 'border-danger-400 bg-danger-50' : 'border-primary-100' }}"
                            >
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-[0.73rem] text-danger-500 flex items-center gap-1">
                                <svg class="w-3 h-3 fill-current shrink-0" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-.75-11.25a.75.75 0 011.5 0v4.5a.75.75 0 01-1.5 0v-4.5zm.75 7.5a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-[0.75rem] font-semibold tracking-widest text-primary-800 uppercase">
                                Password
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[0.73rem] text-primary font-medium no-underline hover:underline">
                                    Lupa password?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-300">
                                <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2"/>
                                    <path d="M7 11V7a5 5 0 0110 0v4"/>
                                </svg>
                            </span>
                            <input
                                id="password" type="password" name="password"
                                required autocomplete="current-password"
                                placeholder="••••••••"
                                class="w-full pl-10 pr-12 py-3 rounded-lg border bg-white font-sans text-[0.9rem] text-primary-900 placeholder-neutral-300 transition-all duration-200 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary-100 {{ $errors->has('password') ? 'border-danger-400 bg-danger-50' : 'border-primary-100' }}"
                            >
                            <button type="button" id="toggle-pw"
                                    aria-label="Tampilkan/sembunyikan password"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-neutral-300 hover:text-primary transition-colors duration-150">
                                <svg id="icon-eye" class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                <svg id="icon-eye-off" class="w-4 h-4 stroke-current fill-none hidden" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round">
                                    <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                                    <line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-[0.73rem] text-danger-500 flex items-center gap-1">
                                <svg class="w-3 h-3 fill-current shrink-0" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-.75-11.25a.75.75 0 011.5 0v4.5a.75.75 0 01-1.5 0v-4.5zm.75 7.5a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Remember me --}}
                    <div class="flex items-center gap-2.5">
                        <input id="remember" type="checkbox" name="remember"
                               class="w-4 h-4 rounded border-primary-200 accent-primary cursor-pointer">
                        <label for="remember" class="text-[0.82rem] text-neutral-500 cursor-pointer select-none">
                            Ingat saya selama 30 hari
                        </label>
                    </div>

                    <div class="border-t border-primary-50"></div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-primary text-white font-sans text-[0.9rem] font-semibold rounded-lg border-none cursor-pointer transition-all duration-200 shadow-md hover:bg-primary-700 hover:-translate-y-px hover:shadow-lg active:translate-y-0">
                        <svg class="w-4 h-4 stroke-current fill-none shrink-0" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/>
                        </svg>
                        Masuk ke Dashboard
                    </button>
                </form>
            </div>

            <p class="anim-5 text-center text-[0.73rem] text-neutral-400 mt-6 leading-relaxed">
                Halaman ini hanya untuk admin SIPETUK.<br>
                Jika Anda bukan admin,
                <a href="{{ url('/') }}" class="text-primary font-medium no-underline hover:underline">kembali ke beranda</a>.
            </p>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="relative z-10 text-center px-4 py-5 text-[0.73rem] text-neutral-400 border-t border-primary-100 bg-white">
        © {{ date('Y') }} SIPETUK · Perpustakaan Buku Gratis
    </footer>

    <script>
        const toggleBtn = document.getElementById('toggle-pw');
        const pwInput   = document.getElementById('password');
        const iconEye   = document.getElementById('icon-eye');
        const iconOff   = document.getElementById('icon-eye-off');

        toggleBtn.addEventListener('click', () => {
            const show   = pwInput.type === 'password';
            pwInput.type = show ? 'text' : 'password';
            iconEye.classList.toggle('hidden', show);
            iconOff.classList.toggle('hidden', !show);
        });
    </script>

</body>
</html>