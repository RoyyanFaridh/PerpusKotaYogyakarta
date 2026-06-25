<div class="relative z-0 flex flex-wrap justify-center border-t border-b border-primary-100 bg-white">
    <div class="flex-1 min-w-32 sm:min-w-40 px-4 sm:px-8 py-5 sm:py-7 text-center border-r border-primary-100 hover:bg-primary-50 transition-colors">
        <div class="font-extrabold text-3xl sm:text-4xl text-primary-600 tabular-nums"><?php echo e(number_format($totalBuku ?? 0)); ?></div>
        <div class="text-xs font-medium tracking-widest uppercase text-neutral-400 mt-1.5">Judul Buku</div>
    </div>
    <div class="flex-1 min-w-32 sm:min-w-40 px-4 sm:px-8 py-5 sm:py-7 text-center border-r border-primary-100 hover:bg-primary-50 transition-colors">
        <div class="font-extrabold text-3xl sm:text-4xl text-primary-600 tabular-nums"><?php echo e(number_format($totalEksemplar ?? 0)); ?></div>
        <div class="text-xs font-medium tracking-widest uppercase text-neutral-400 mt-1.5">Total Stok</div>
    </div>
    <div class="flex-1 min-w-32 sm:min-w-40 px-4 sm:px-8 py-5 sm:py-7 text-center border-r border-primary-100 hover:bg-primary-50 transition-colors">
        <div class="font-extrabold text-3xl sm:text-4xl text-primary-600 tabular-nums"><?php echo e(number_format($totalAnggota ?? 0)); ?></div>
        <div class="text-xs font-medium tracking-widest uppercase text-neutral-400 mt-1.5">Anggota Aktif</div>
    </div>
    <div class="flex-1 min-w-32 sm:min-w-40 px-4 sm:px-8 py-5 sm:py-7 text-center hover:bg-primary-50 transition-colors">
        <div class="font-extrabold text-3xl sm:text-4xl text-primary-600 tabular-nums"><?php echo e(number_format($totalTukar ?? 0)); ?></div>
        <div class="text-xs font-medium tracking-widest uppercase text-neutral-400 mt-1.5">Penukaran Berhasil</div>
    </div>
</div><?php /**PATH D:\Perkuliahan Duniawi\MAGANG GES\PerpusKotaYogyakarta\resources\views/components/home/stats-strip.blade.php ENDPATH**/ ?>