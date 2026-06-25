<?php
    $user = auth()->user();
    $lokasiStep = $prefix === 'create'
        && ($user->isSuperAdmin() || $user->penugasanAktif()->count() >= 2);

    $steps = $lokasiStep
        ? ['Lokasi', 'Member', 'Buku Masuk', 'Buku Keluar', 'Konfirmasi']
        : ['Member', 'Buku Masuk', 'Buku Keluar', 'Konfirmasi'];

    $total = count($steps);
?>

<div class="flex items-center px-6 sm:px-8 py-4 gap-1.5 border-b border-neutral-100">
    <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="flex items-center gap-1.5 <?php echo e($i < $total - 1 ? 'flex-1' : ''); ?>">
            <div class="w-5 h-5 rounded-full flex items-center justify-center text-[0.6rem] font-bold shrink-0 transition-all
                    <?php echo e($i === 0 ? 'bg-primary text-white' : 'bg-neutral-100 text-neutral-400'); ?>"
                 id="<?php echo e($prefix); ?>_dot_<?php echo e($i + 1); ?>"><?php echo e($i + 1); ?></div>

            <span class="text-[0.65rem] font-medium transition-colors hidden sm:block
                    <?php echo e($i === 0 ? 'text-primary-700' : 'text-neutral-400'); ?>"
                  id="<?php echo e($prefix); ?>_label_<?php echo e($i + 1); ?>">
                <?php echo e($label); ?>

            </span>

            <?php if($i < $total - 1): ?>
                <div class="flex-1 h-px bg-neutral-100 mx-1"></div>
            <?php endif; ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/admin/transaksi/_step-indicator.blade.php ENDPATH**/ ?>