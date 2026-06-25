<?php
    $user = auth()->user();
    $lokasiStep = $user->isSuperAdmin() || $user->penugasanAktif()->count() >= 2;
?>

<?php if($lokasiStep): ?>
<div class="step-content-<?php echo e($prefix); ?> hidden" data-step="1">
    <p class="text-sm font-medium text-neutral-700 mb-1">Pilih Lokasi</p>
    <p class="text-xs text-neutral-400 mb-4">Transaksi ini akan dicatat di lokasi yang dipilih.</p>

    <div id="<?php echo e($prefix); ?>_lokasiList" class="flex flex-col gap-2">
        <?php $__currentLoopData = $lokasiPilihan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button
                type="button"
                data-id="<?php echo e($lokasi->id); ?>"
                onclick="pilihLokasi(<?php echo e($lokasi->id); ?>, this)"
                class="w-full text-left px-4 py-3 rounded-lg border text-sm transition-all
                       border-neutral-200 hover:border-primary hover:bg-primary-50
                       focus:outline-none focus:ring-2 focus:ring-primary-300
                       <?php echo e($activeLokasiId === $lokasi->id ? 'border-primary bg-primary-50 font-semibold' : ''); ?>">
                <?php echo e($lokasi->nama_lokasi); ?>

            </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/admin/transaksi/_step-lokasi.blade.php ENDPATH**/ ?>