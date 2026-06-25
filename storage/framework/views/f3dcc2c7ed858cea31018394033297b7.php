<?php $__env->startSection('title', 'Pengaturan'); ?>
<?php $__env->startSection('page-title', 'Pengaturan'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola akun dan sistem'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col gap-4">

    
    <?php if(session('success')): ?>
        <div class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-success-50 border border-success-200 text-success-700 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-danger-50 border border-danger-200 text-danger-700 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php echo $__env->make('admin.pengaturan.partials.tabel-user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <?php echo $__env->make('admin.pengaturan.modals.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('admin.pengaturan.modals.edit', ['user' => $userItem], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('admin.pengaturan.modals.destroy', ['user' => $userItem], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <?php echo $__env->make('admin.pengaturan.partials.modal-assign', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('admin.pengaturan.partials.modal-histori', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</div>

<?php echo $__env->make('admin.pengaturan.scripts.pengaturan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/admin/pengaturan/index.blade.php ENDPATH**/ ?>