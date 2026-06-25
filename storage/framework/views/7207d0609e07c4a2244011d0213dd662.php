
<section id="buku-terbaru-section" class="relative z-10 pt-4 pb-14 px-8 max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-4 sm:mb-6 px-1">
        <div class="text-left">
            <p class="text-xs font-semibold tracking-widest uppercase text-primary-400 mb-1">Koleksi Terbaru</p>
            <h2 class="font-bold text-primary-900 text-sm sm:text-lg leading-tight">
                <?php echo e($bukuTerbaru->count()); ?> Buku Terbaru
            </h2>
        </div>
    </div>

    <div class="flex gap-4 overflow-x-auto pb-3 -mx-4 px-4 snap-x snap-mandatory scrollbar-hide">
        <?php $__empty_1 = true; $__currentLoopData = $bukuTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $buku): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="flex flex-col bg-white border border-primary-100 rounded-xl overflow-hidden cursor-pointer transition-all duration-200 hover:-translate-y-1 hover:border-primary-200 snap-start shrink-0 w-44 sm:w-52"
             onclick="bukaDetailBuku(<?php echo e($buku->id); ?>)">

            <?php if($buku->cover): ?>
                <div class="w-full bg-primary-50/60 flex items-center justify-center" style="height: 160px;">
                    <img src="<?php echo e(Storage::url($buku->cover)); ?>"
                         alt="Cover <?php echo e($buku->judul); ?>"
                         class="h-full w-auto max-w-full object-contain">
                </div>
            <?php else: ?>
                <div class="w-full bg-primary-50 flex items-center justify-center" style="height: 160px;">
                    <svg class="w-8 h-8 text-primary-200 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.3">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <path d="M3 9h18M9 21V9"/>
                    </svg>
                </div>
            <?php endif; ?>

            <div class="flex flex-col p-3 flex-1">
                <div class="flex items-start justify-between gap-1 mb-2">
                    <span class="inline-block text-[0.5rem] font-semibold tracking-wide uppercase px-2 py-0.5 rounded-full bg-primary-50 text-primary">
                        <?php echo e($buku->kategori ?? 'Umum'); ?>

                    </span>
                    <span class="text-[0.65rem] font-medium text-neutral-400 shrink-0">
                        <?php echo e($buku->tahun_terbit ?? ''); ?>

                    </span>
                </div>
                <h3 class="font-bold text-[0.85rem] leading-snug text-primary-900 mb-1">
                    <?php echo e($buku->judul); ?>

                </h3>
                <p class="text-[0.75rem] font-medium text-neutral-500 mb-2">
                    <?php echo e($buku->pengarang); ?>

                </p>
                <div class="flex flex-col gap-1 mt-auto pt-2 border-t border-primary-50">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full <?php echo e($buku->stok_aktif > 0 ? 'bg-emerald-400' : 'bg-red-400'); ?>"></span>
                        <span class="text-[0.7rem] font-medium <?php echo e($buku->stok_aktif > 0 ? 'text-emerald-600' : 'text-red-500'); ?>">
                            <?php echo e($buku->stok_aktif > 0 ? "Stok {$buku->stok_aktif}" : 'Habis'); ?>

                        </span>
                    </div>
                    <?php
                        $lokasiAktif = $buku->eksemplars
                            ->filter(fn($e) => $e->paket?->is_aktif && $e->stok > 0)
                            ->map(fn($e) => $e->paket?->lokasi?->nama_lokasi)
                            ->filter()
                            ->unique()
                            ->values();
                    ?>
                    <?php if($lokasiAktif->isNotEmpty()): ?>
                    <div class="flex items-center gap-1 text-[0.65rem] text-neutral-400">
                        <svg class="w-3 h-3 stroke-current fill-none shrink-0" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                            <circle cx="12" cy="9" r="2.5"/>
                        </svg>
                        <span><?php echo e($lokasiAktif->join(', ')); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="flex flex-col items-center justify-center py-12 gap-3 w-full">
            <svg class="w-14 h-14 text-primary-200 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.3">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                <rect x="9" y="3" width="6" height="4" rx="1"/>
                <path d="M9 12h6M9 16h4" stroke-linecap="round"/>
            </svg>
            <p class="font-semibold text-primary-800 text-sm">Belum ada buku</p>
        </div>
        <?php endif; ?>
    </div>
</section><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/components/home/buku-terbaru.blade.php ENDPATH**/ ?>