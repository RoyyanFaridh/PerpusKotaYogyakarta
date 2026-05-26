<nav class="fixed top-0 left-0 right-0 z-200 h-16 sm:h-18 bg-white/95 backdrop-blur-md border-b border-primary-100 flex items-center px-4 sm:px-8 shadow-sm">
    <div class="w-full max-w-7xl mx-auto flex items-center justify-between gap-4">

        <a href="{{ url('/') }}" class="flex items-center gap-2 sm:gap-2.5 no-underline shrink-0">
            <div class="w-8 h-8 sm:w-9 sm:h-9 bg-primary-600 rounded-lg grid place-items-center">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 fill-white" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 4h4v16H4zM10 4h10v3H10zM10 10h7v3H10zM10 17h10v3H10z"/>
                </svg>
            </div>
            <div>
                <span class="font-extrabold text-lg sm:text-xl text-primary-700 tracking-wider leading-none block">SIPETUK</span>
                <span class="text-[0.6rem] font-medium tracking-widest text-neutral-400 uppercase block mt-0.5">Sistem Penukaran Buku</span>
            </div>
        </a>

        <a href="{{ route('auth.login') }}"
           class="inline-flex items-center gap-1.5 px-4 sm:px-5 py-2 bg-primary-600 text-white text-xs sm:text-sm font-semibold rounded-lg no-underline transition-colors whitespace-nowrap shadow-sm hover:bg-primary-700">
            Login Admin
        </a>
    </div>
</nav>