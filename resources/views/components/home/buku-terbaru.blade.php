<section class="relative z-10 pt-4 pb-14 px-4 max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-4 sm:mb-6 px-1">
        <div class="text-left">
            <p class="text-xs font-semibold tracking-widest uppercase text-primary-400 mb-1">Koleksi Terbaru</p>
            <h2 class="font-bold text-primary-900 text-sm sm:text-lg leading-tight">
                5 Buku Terbaru — {{ $bukuTerbaru->count() }} buku
            </h2>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
        @forelse ($bukuTerbaru as $buku)
        <div class="flex flex-col bg-white border border-primary-100 rounded-xl p-7 cursor-pointer transition-all duration-200 hover:-translate-y-1 hover:shadow-xl hover:border-primary-200">
            <div class="flex items-start justify-between gap-2 mb-4">
                <span class="inline-block text-[0.65rem] font-semibold tracking-[0.07em] uppercase px-2.5 py-0.5 rounded-full bg-primary-50 text-primary">
                    {{ $buku->kategori ?? 'Umum' }}
                </span>
                <span class="text-[0.75rem] font-medium text-neutral-400 shrink-0">
                    {{ $buku->tahun_terbit ?? '' }}
                </span>
            </div>

            <h3 class="font-bold text-[1.05rem] leading-snug text-primary-900 mb-2 line-clamp-2">
                {{ $buku->judul }}
            </h3>
            <p class="text-[0.83rem] font-medium text-neutral-500 mb-4">
                {{ $buku->pengarang }}
            </p>
            <p class="text-[0.82rem] leading-relaxed text-neutral-400 line-clamp-4 flex-1">
                {{ $buku->resume ?? '' }}
            </p>

            <div class="flex items-center justify-between mt-4 pt-4 border-t border-primary-50">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full {{ $buku->stok > 0 ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
                    <span class="text-[0.78rem] font-medium {{ $buku->stok > 0 ? 'text-emerald-600' : 'text-red-500' }}">
                        {{ $buku->stok > 0 ? "Tersedia ({$buku->stok})" : 'Habis' }}
                    </span>
                </div>
                @if ($buku->lokasi)
                <div class="flex items-center gap-1.5 text-[0.75rem] text-neutral-400">
                    <svg class="w-3.5 h-3.5 stroke-current fill-none shrink-0" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                        <circle cx="12" cy="9" r="2.5"/>
                    </svg>
                    <span>{{ $buku->lokasi->nama_lokasi }}</span>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-3 flex flex-col items-center justify-center py-12 gap-3">
            <svg class="w-14 h-14 text-primary-200 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.3">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                <rect x="9" y="3" width="6" height="4" rx="1"/>
                <path d="M9 12h6M9 16h4" stroke-linecap="round"/>
            </svg>
            <p class="font-semibold text-primary-800 text-sm">Belum ada buku</p>
        </div>
        @endforelse
    </div>
</section>