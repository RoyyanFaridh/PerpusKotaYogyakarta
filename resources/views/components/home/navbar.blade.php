<nav class="fixed top-0 left-0 right-0 z-200 h-17 bg-white/94 backdrop-blur-md border-b border-primary-100 flex items-center px-[clamp(1rem,5vw,3rem)] shadow-sm">
    <div class="w-full max-w-8xl mx-auto flex items-center justify-between gap-4">

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
        <a href="{{ route('auth.login') }}"
           class="inline-flex items-center gap-[0.45rem] px-5 py-[0.55rem] bg-primary text-white text-sm font-semibold rounded-lg border-none cursor-pointer no-underline transition-all duration-200 whitespace-nowrap shadow-md hover:bg-[#033370] hover:-translate-y-px hover:shadow-lg">
            <span>Login Admin</span>
        </a>
    </div>
</nav>