<section class="relative z-10 py-14 sm:py-20 px-4 sm:px-6 lg:px-8 bg-white border-b border-primary-100">
    <div class="w-full max-w-4xl mx-auto">

        
        <div class="text-center mb-8 sm:mb-12">
            <p class="text-xs font-semibold tracking-[0.2em] uppercase text-primary-400 mb-3 flex items-center justify-center gap-2 sm:gap-3">
                <span class="block w-5 sm:w-7 h-px bg-primary-300 rounded"></span>
                Agenda Mendatang
                <span class="block w-5 sm:w-7 h-px bg-primary-300 rounded"></span>
            </p>
            <h2 class="font-extrabold text-primary-900 leading-tight mb-3"
                style="font-size: clamp(1.3rem, 4vw, 2.4rem);">
                Rencana <span class="text-primary-800">Kegiatan</span>
            </h2>
            <p class="text-neutral-400 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
                Kami terus merancang berbagai kegiatan yang bermanfaat dan menyenangkan,
                agar pembaca semakin bersemangat dalam mengeksplorasi buku.
            </p>
        </div>

        <?php
            $namaBulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

            $sorted = $kegiatan->sortBy(function ($item) {
                $s   = $item->status_otomatis;
                $tgl = \Carbon\Carbon::parse($item->tanggal_mulai)->timestamp;
                $priority = match ($s) {
                    'sedang_berlangsung' => 1,
                    'selesai'            => 0,
                    default              => 2,
                };
                return [$priority, $tgl];
            })->values();

            $focalIndex = $sorted->search(fn($item) => $item->status_otomatis !== 'selesai');
            if ($focalIndex === false) $focalIndex = 0;
        ?>

        <?php if($sorted->isEmpty()): ?>
            <div class="flex flex-col items-center justify-center py-14 gap-3 text-center">
                <svg class="w-12 h-12 text-primary-200 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.3" aria-hidden="true">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <path d="M16 2v4M8 2v4M3 10h18" stroke-linecap="round"/>
                </svg>
                <p class="font-semibold text-primary-800 text-sm">Belum ada kegiatan terjadwal</p>
                <p class="text-xs text-neutral-400">Pantau terus halaman ini untuk informasi terbaru</p>
            </div>
        <?php else: ?>
            <div class="relative">
                
                <div class="pointer-events-none absolute inset-x-0 top-0 z-10 h-32"
                     style="background: linear-gradient(to bottom, white 30%, transparent 100%);"></div>

                
                <div class="pointer-events-none absolute inset-x-0 bottom-0 z-10 h-32"
                     style="background: linear-gradient(to top, white 30%, transparent 100%);"></div>

                
                <div id="kegiatan-scroll"
                     class="relative overflow-y-auto scrollbar-hide"
                     style="height: 460px; scroll-behavior: smooth; overscroll-behavior: contain;">

                    
                    <div style="height: 100px;"></div>

                    <?php $__currentLoopData = $sorted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $tgl    = \Carbon\Carbon::parse($item->tanggal_mulai);
                            $status = $item->status_otomatis;
                            $isPast = $status === 'selesai';
                            $isLive = $status === 'sedang_berlangsung';
                            $isFocal = $index === $focalIndex;
                        ?>

                        
                        <?php if($index > 0): ?>
                            <div class="w-full h-px <?php echo e($isPast ? 'bg-neutral-100' : 'bg-primary-100'); ?>"></div>
                        <?php endif; ?>

                        <div data-kegiatan-index="<?php echo e($index); ?>"
                             data-is-focal="<?php echo e($isFocal ? 'true' : 'false'); ?>"
                             class="kegiatan-item w-full flex items-center gap-3 sm:gap-5 px-2 sm:px-4 py-6 sm:py-8 transition-all duration-300">

                            
                            <div class="shrink-0 flex items-center gap-1.5 sm:gap-2" style="width: 4.5rem;">

                                
                                <div class="text-right leading-none">
                                    <span class="block font-extrabold leading-none
                                        <?php echo e($isPast ? 'text-neutral-300' : 'text-primary-700'); ?>"
                                          style="font-size: clamp(1.6rem, 4vw, 2.2rem);">
                                        <?php echo e($tgl->format('d')); ?>

                                    </span>
                                    <span class="block text-xs font-semibold tracking-widest uppercase mt-1
                                        <?php echo e($isPast ? 'text-neutral-300' : 'text-primary-500'); ?>">
                                        <?php echo e($namaBulan[$tgl->month - 1]); ?>

                                    </span>
                                </div>

                                
                                <span class="block text-[0.6rem] font-bold tracking-[0.25em] uppercase
                                    <?php echo e($isPast ? 'text-neutral-200' : 'text-primary-300'); ?>"
                                      style="writing-mode: vertical-rl; transform: rotate(180deg); letter-spacing: 0.25em;">
                                    <?php echo e($tgl->format('Y')); ?>

                                </span>
                            </div>

                            
                            <div class="shrink-0 self-stretch w-px
                                <?php echo e($isPast ? 'bg-neutral-100' : ($isFocal ? 'bg-primary-300' : 'bg-primary-100')); ?>">
                            </div>

                            
                            <div class="flex-1 min-w-0">

                                
                                <?php if($item->jam_pelaksanaan): ?>
                                    <p class="text-xs mb-1.5 flex items-center gap-1.5
                                        <?php echo e($isPast ? 'text-neutral-300' : 'text-primary-400'); ?>">
                                        <svg class="w-3 h-3 shrink-0" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"/>
                                            <polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                        <?php echo e(\Carbon\Carbon::parse($item->jam_pelaksanaan)->format('H:i')); ?>

                                        <?php if($item->jam_selesai): ?>
                                            &ndash; <?php echo e(\Carbon\Carbon::parse($item->jam_selesai)->format('H:i')); ?>

                                        <?php endif; ?>
                                        WIB
                                    </p>
                                <?php endif; ?>

                                
                                <h3 class="font-bold leading-snug mb-1.5
                                    <?php echo e($isPast
                                        ? 'text-neutral-300 text-sm sm:text-base'
                                        : ($isFocal
                                            ? 'text-primary-700 text-base sm:text-xl'
                                            : 'text-primary-600 text-sm sm:text-base')); ?>">
                                    <?php echo e($item->nama_kegiatan); ?>

                                </h3>

                                
                                <?php if($item->deskripsi): ?>
                                    <p class="text-xs sm:text-sm leading-relaxed
                                        <?php echo e($isPast ? 'text-neutral-300' : 'text-primary-400'); ?>">
                                        <?php echo e($item->deskripsi); ?>

                                    </p>
                                <?php endif; ?>

                                
                                <?php if($item->pakets && $item->pakets->isNotEmpty()): ?>
                                    <div class="flex flex-wrap gap-1.5 mt-2.5">
                                        <?php if($isLive && $item->lokasi): ?>
                                            
                                            <span class="inline-flex items-center gap-1 text-[0.62rem] font-medium px-2 py-0.5 rounded-full bg-primary-50 text-primary-500 border border-primary-100">
                                                <svg class="w-2.5 h-2.5 shrink-0" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                                    <circle cx="12" cy="9" r="2.5"/>
                                                </svg>
                                                <?php echo e($item->lokasi->nama_lokasi); ?>

                                            </span>
                                        <?php elseif(!$isPast): ?>
                                            
                                            <?php $__currentLoopData = $item->pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($paket->lokasi): ?>
                                                    <span class="inline-flex items-center gap-1 text-[0.62rem] font-medium px-2 py-0.5 rounded-full bg-primary-50 text-primary-500 border border-primary-100">
                                                        <svg class="w-2.5 h-2.5 shrink-0" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" aria-hidden="true">
                                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                                            <circle cx="12" cy="9" r="2.5"/>
                                                        </svg>
                                                        <?php echo e($paket->lokasi->nama_lokasi); ?>

                                                    </span>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            
                            <div class="shrink-0 flex items-center justify-end" style="min-width: 7rem;">
                                <?php if($isLive): ?>
                                    
                                    <div class="flex items-center justify-center w-8 group relative">
                                        <span class="relative flex h-3 w-3">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-60"></span>
                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-primary-500"></span>
                                        </span>
                                        <span class="pointer-events-none absolute right-full mr-2 top-1/2 -translate-y-1/2
                                                     opacity-0 group-hover:opacity-100 transition-opacity duration-200
                                                     whitespace-nowrap text-[0.62rem] font-semibold tracking-[0.15em] uppercase
                                                     text-primary-600 bg-primary-50 border border-primary-100
                                                     px-2.5 py-0.5 rounded-full">
                                            Sedang Berlangsung
                                        </span>
                                    </div>
                                <?php elseif($isPast): ?>
                                    <span class="inline-flex items-center text-[0.62rem] font-semibold tracking-[0.15em] uppercase text-neutral-400 bg-neutral-100 px-2.5 py-0.5 rounded-full">
                                        Selesai
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center text-[0.62rem] font-semibold tracking-[0.15em] uppercase text-success-600 bg-success-50 border border-success-100 px-2.5 py-0.5 rounded-full">
                                        Akan Berlangsung
                                    </span>
                                <?php endif; ?>
                            </div>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <div style="height: 100px;"></div>

                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
(function () {
    const container = document.getElementById('kegiatan-scroll');
    if (!container) return;

    const focal = container.querySelector('[data-is-focal="true"]');
    if (!focal) return;

    const containerH = container.clientHeight;
    const itemH      = focal.offsetHeight;

    // Pakai getBoundingClientRect agar akurat meski ada nested positioning
    requestAnimationFrame(function () {
        const contRect  = container.getBoundingClientRect();
        const itemRect  = focal.getBoundingClientRect();
        const scrollTo  = container.scrollTop + (itemRect.top - contRect.top) - (containerH / 2) + (itemH / 2);
        container.scrollTop = scrollTo;
    });
})();
</script><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/components/home/kegiatan.blade.php ENDPATH**/ ?>