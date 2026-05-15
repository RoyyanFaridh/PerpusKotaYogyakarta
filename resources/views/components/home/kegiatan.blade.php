<section class="relative z-10 py-12 sm:py-16 px-4 sm:px-[clamp(1rem,5vw,3rem)] bg-white border-b border-primary-100">
    <div class="w-full max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="text-center mb-6 sm:mb-8">
            <p class="text-[0.65rem] sm:text-[0.70rem] font-semibold tracking-[0.18em] sm:tracking-[0.22em] uppercase text-primary-500 mb-3 flex items-center justify-center gap-2 sm:gap-3">
                <span class="block w-5 sm:w-7 h-px bg-primary-400 rounded"></span>
                Agenda Mendatang
                <span class="block w-5 sm:w-7 h-px bg-primary-400 rounded"></span>
            </p>
            <h2 class="font-extrabold text-primary-900 leading-tight mb-3"
                style="font-size: clamp(1.3rem, 4vw, 2.4rem);">
                Rencana <span class="text-primary">Kegiatan</span>
            </h2>
            <p class="text-neutral-400 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
                Kami terus merancang berbagai kegiatan yang bermanfaat dan menyenangkan,
                agar pembaca semakin bersemangat dalam mengeksplorasi buku.
            </p>
        </div>

        @php
            $namaBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            $sorted = $kegiatan->sortBy(function ($item) {
                $s   = $item->status_otomatis;
                $tgl = \Carbon\Carbon::parse($item->tanggal_mulai)->timestamp;
                return [$s === 'selesai' ? 0 : 1, $tgl];
            })->values();
        @endphp

        {{-- Timeline --}}
        <div
            id="timeline-container"
            class="relative overflow-y-auto flex flex-col items-center gap-3 scrollbar-hide"
            style="height: 360px; padding: 100px 0; scroll-behavior: smooth; overscroll-behavior: contain;"
        >
            @forelse ($sorted as $index => $item)
                @php
                    $tgl    = \Carbon\Carbon::parse($item->tanggal_mulai);
                    $judul  = $item->nama_kegiatan;
                    $desc   = $item->deskripsi;
                    $status = $item->status_otomatis;
                    $isPast = $status === 'selesai';
                @endphp
                <div id="event-{{ $index }}"
                     class="w-full max-w-2xl shrink-0 transition-all duration-300"
                     style="opacity: 0.3; transform: scale(0.9);">
                    <div class="timeline-scroll-item flex items-start gap-3 sm:gap-5 px-4 sm:px-6 py-4 sm:py-5 rounded-xl
                        {{ $isPast ? 'bg-neutral-50' : 'bg-white' }}">

                        {{-- Kolom Tanggal --}}
                        <div class="shrink-0 text-center leading-none min-w-11min-w-[52px]">
                            <span class="block font-extrabold text-[1.8rem] sm:text-[2.2rem] leading-none
                                {{ $isPast ? 'text-neutral-300' : 'text-primary' }}">
                                {{ $tgl->format('d') }}
                            </span>
                            <span class="block text-[0.62rem] sm:text-[0.68rem] font-semibold tracking-widest uppercase mt-0.5
                                {{ $isPast ? 'text-neutral-300' : 'text-[#3a7bd5]' }}">
                                {{ $namaBulan[$tgl->month - 1] }}
                            </span>
                            <span class="block text-[0.58rem] sm:text-[0.62rem] font-medium mt-0.5
                                {{ $isPast ? 'text-neutral-200' : 'text-[#a8c4e8]' }}">
                                {{ $tgl->format('Y') }}
                            </span>
                        </div>

                        {{-- Garis Pembatas --}}
                        <div class="shrink-0 self-stretch w-px mx-0.5 sm:mx-1"
                             style="background: {{ $isPast ? 'rgba(0,0,0,0.06)' : 'rgba(4,68,141,0.18)' }};"></div>

                        {{-- Konten --}}
                        <div class="flex-1 min-w-0 pt-0.5">
                            @if ($status === 'sedang_berlangsung')
                                <span class="inline-flex items-center gap-1.5 text-[0.6rem] sm:text-[0.63rem] font-semibold tracking-wider uppercase text-primary bg-blue-50 border border-blue-100 px-2 sm:px-2.5 py-0.5 rounded-full mb-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse inline-block"></span>
                                    Berlangsung
                                </span>
                            @elseif ($status === 'selesai')
                                <span class="inline-flex items-center gap-1.5 text-[0.6rem] sm:text-[0.63rem] font-semibold tracking-wider uppercase text-neutral-400 bg-neutral-100 px-2 sm:px-2.5 py-0.5 rounded-full mb-2">
                                    Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-[0.6rem] sm:text-[0.63rem] font-semibold tracking-wider uppercase text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 sm:px-2.5 py-0.5 rounded-full mb-2">
                                    Akan Berlangsung
                                </span>
                            @endif

                            @if ($item->jam_pelaksanaan)
                                <p class="text-[0.68rem] sm:text-[0.72rem] mb-1.5 flex items-center gap-1
                                    {{ $isPast ? 'text-neutral-300' : 'text-[#3a7bd5]' }}">
                                    <svg class="w-3 h-3 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($item->jam_pelaksanaan)->format('H:i') }}
                                    @if ($item->jam_selesai)– {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}@endif WIB
                                </p>
                            @endif

                            <h3 class="font-bold text-[0.9rem] sm:text-[1rem] leading-snug mb-1
                                {{ $isPast ? 'text-neutral-400' : 'text-primary' }}">
                                {{ $judul }}
                            </h3>
                            <p class="text-[0.78rem] sm:text-[0.82rem] leading-relaxed
                                {{ $isPast ? 'text-neutral-300' : 'text-[#3a7bd5]' }}">
                                {{ $desc }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-12 gap-3 text-center">
                    <p class="font-semibold text-primary-800 text-sm">Belum ada kegiatan terjadwal</p>
                    <p class="text-xs text-neutral-400">Pantau terus halaman ini untuk informasi terbaru</p>
                </div>
            @endforelse
        </div>
    </div>
</section>