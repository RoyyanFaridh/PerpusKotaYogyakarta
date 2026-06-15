{{--
    Komponen: buku-terbaru
    Modal detail ditangani oleh @include('components.home.modal-detail-buku')
    yang di-include sekali di layout utama.
--}}
<section id="buku-terbaru-section" class="relative z-10 pt-4 pb-14 px-8 max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-4 sm:mb-6 px-1">
        <div class="text-left">
            <p class="text-xs font-semibold tracking-widest uppercase text-primary-400 mb-1">Koleksi Terbaru</p>
            <h2 class="font-bold text-primary-900 text-sm sm:text-lg leading-tight">
                {{ $bukuTerbaru->count() }} Buku Terbaru
            </h2>
        </div>
    </div>

    <div class="flex gap-4 overflow-x-auto pb-3 -mx-4 px-4 snap-x snap-mandatory scrollbar-hide">
        @forelse ($bukuTerbaru as $buku)
        <div class="flex flex-col bg-white border border-primary-100 rounded-xl overflow-hidden cursor-pointer transition-all duration-200 hover:-translate-y-1 hover:border-primary-200 snap-start shrink-0 w-44 sm:w-52"
             onclick="bukaDetailBuku({{ $buku->id }})">

            @if ($buku->cover)
                <div class="w-full bg-primary-50/60 flex items-center justify-center" style="height: 160px;">
                    <img src="{{ Storage::url($buku->cover) }}"
                         alt="Cover {{ $buku->judul }}"
                         class="h-full w-auto max-w-full object-contain">
                </div>
            @else
                <div class="w-full bg-primary-50 flex items-center justify-center" style="height: 160px;">
                    <svg class="w-8 h-8 text-primary-200 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.3">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <path d="M3 9h18M9 21V9"/>
                    </svg>
                </div>
            @endif

            <div class="flex flex-col p-3 flex-1">
                <div class="flex items-start justify-between gap-1 mb-2">
                    <span class="inline-block text-[0.5rem] font-semibold tracking-wide uppercase px-2 py-0.5 rounded-full bg-primary-50 text-primary">
                        {{ $buku->kategori ?? 'Umum' }}
                    </span>
                    <span class="text-[0.65rem] font-medium text-neutral-400 shrink-0">
                        {{ $buku->tahun_terbit ?? '' }}
                    </span>
                </div>
                <h3 class="font-bold text-[0.85rem] leading-snug text-primary-900 mb-1">
                    {{ $buku->judul }}
                </h3>
                <p class="text-[0.75rem] font-medium text-neutral-500 mb-2">
                    {{ $buku->pengarang }}
                </p>
                <div class="flex flex-col gap-1 mt-auto pt-2 border-t border-primary-50">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full {{ $buku->stok_aktif > 0 ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
                        <span class="text-[0.7rem] font-medium {{ $buku->stok_aktif > 0 ? 'text-emerald-600' : 'text-red-500' }}">
                            {{ $buku->stok_aktif > 0 ? "Stok {$buku->stok_aktif}" : 'Habis' }}
                        </span>
                    </div>
                    @if ($buku->lokasi)
                    <div class="flex items-center gap-1 text-[0.65rem] text-neutral-400">
                        <svg class="w-3 h-3 stroke-current fill-none shrink-0" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                            <circle cx="12" cy="9" r="2.5"/>
                        </svg>
                        <span>{{ $buku->lokasi->nama_lokasi }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="flex flex-col items-center justify-center py-12 gap-3 w-full">
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