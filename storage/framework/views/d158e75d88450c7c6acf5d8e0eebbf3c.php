<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('page-subtitle', 'Selamat Datang, Petugas!'); ?>

<?php $__env->startSection('content'); ?>
    <div class="flex flex-col gap-6">

        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <?php if (isset($component)) { $__componentOriginale3e48fc32d24604579a0740f9bac39f2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3e48fc32d24604579a0740f9bac39f2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.dashboard.stat-card','data' => ['label' => 'Transaksi Bulan Ini','value' => $transaksiBulanIni,'icon' => 'document','color' => 'primary','badge' => ($selisihTransaksi >= 0 ? '+' : '') . $selisihTransaksi . '% dari bulan lalu','caption' => 'Total transaksi tukar buku','href' => route('admin.transaksi.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.dashboard.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Transaksi Bulan Ini','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($transaksiBulanIni),'icon' => 'document','color' => 'primary','badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(($selisihTransaksi >= 0 ? '+' : '') . $selisihTransaksi . '% dari bulan lalu'),'caption' => 'Total transaksi tukar buku','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.transaksi.index'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3e48fc32d24604579a0740f9bac39f2)): ?>
<?php $attributes = $__attributesOriginale3e48fc32d24604579a0740f9bac39f2; ?>
<?php unset($__attributesOriginale3e48fc32d24604579a0740f9bac39f2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3e48fc32d24604579a0740f9bac39f2)): ?>
<?php $component = $__componentOriginale3e48fc32d24604579a0740f9bac39f2; ?>
<?php unset($__componentOriginale3e48fc32d24604579a0740f9bac39f2); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginale3e48fc32d24604579a0740f9bac39f2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3e48fc32d24604579a0740f9bac39f2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.dashboard.stat-card','data' => ['label' => 'Jumlah Buku','value' => $jumlahBuku,'icon' => 'book','color' => 'success','badge' => 'Total judul buku','caption' => 'Total judul buku','href' => route('admin.buku.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.dashboard.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Jumlah Buku','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($jumlahBuku),'icon' => 'book','color' => 'success','badge' => 'Total judul buku','caption' => 'Total judul buku','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.buku.index'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3e48fc32d24604579a0740f9bac39f2)): ?>
<?php $attributes = $__attributesOriginale3e48fc32d24604579a0740f9bac39f2; ?>
<?php unset($__attributesOriginale3e48fc32d24604579a0740f9bac39f2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3e48fc32d24604579a0740f9bac39f2)): ?>
<?php $component = $__componentOriginale3e48fc32d24604579a0740f9bac39f2; ?>
<?php unset($__componentOriginale3e48fc32d24604579a0740f9bac39f2); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginale3e48fc32d24604579a0740f9bac39f2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3e48fc32d24604579a0740f9bac39f2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.dashboard.stat-card','data' => ['label' => 'Jumlah Stok','value' => $jumlahStok,'icon' => 'book','color' => 'warning','badge' => 'Total stok tersedia','caption' => 'Stok buku','href' => route('admin.buku.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.dashboard.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Jumlah Stok','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($jumlahStok),'icon' => 'book','color' => 'warning','badge' => 'Total stok tersedia','caption' => 'Stok buku','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.buku.index'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3e48fc32d24604579a0740f9bac39f2)): ?>
<?php $attributes = $__attributesOriginale3e48fc32d24604579a0740f9bac39f2; ?>
<?php unset($__attributesOriginale3e48fc32d24604579a0740f9bac39f2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3e48fc32d24604579a0740f9bac39f2)): ?>
<?php $component = $__componentOriginale3e48fc32d24604579a0740f9bac39f2; ?>
<?php unset($__componentOriginale3e48fc32d24604579a0740f9bac39f2); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginale3e48fc32d24604579a0740f9bac39f2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3e48fc32d24604579a0740f9bac39f2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.dashboard.stat-card','data' => ['label' => 'Member Bulan Ini','value' => $memberBulanIni,'icon' => 'users','color' => 'danger','badge' => ($selisihMember >= 0 ? '+' : '') . $selisihMember . ' dari bulan lalu','caption' => 'Total member yang bergabung','href' => route('admin.member.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.dashboard.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Member Bulan Ini','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($memberBulanIni),'icon' => 'users','color' => 'danger','badge' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(($selisihMember >= 0 ? '+' : '') . $selisihMember . ' dari bulan lalu'),'caption' => 'Total member yang bergabung','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.member.index'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3e48fc32d24604579a0740f9bac39f2)): ?>
<?php $attributes = $__attributesOriginale3e48fc32d24604579a0740f9bac39f2; ?>
<?php unset($__attributesOriginale3e48fc32d24604579a0740f9bac39f2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3e48fc32d24604579a0740f9bac39f2)): ?>
<?php $component = $__componentOriginale3e48fc32d24604579a0740f9bac39f2; ?>
<?php unset($__componentOriginale3e48fc32d24604579a0740f9bac39f2); ?>
<?php endif; ?>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 items-start">
            <?php echo $__env->make('components.admin.dashboard.penukaran-per-kategori', ['kategoris' => $kategoris], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo $__env->make('components.admin.dashboard.aktivitas-terkini', ['aktivitas' => $aktivitas], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <?php if($transaksiTerbaru->isNotEmpty()): ?>
            <?php if (isset($component)) { $__componentOriginalbf9e60c730737961dc4cd2b8c711b9b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbf9e60c730737961dc4cd2b8c711b9b5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.dashboard.transaksi-terbaru','data' => ['transaksis' => $transaksiTerbaru]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.dashboard.transaksi-terbaru'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['transaksis' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($transaksiTerbaru)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbf9e60c730737961dc4cd2b8c711b9b5)): ?>
<?php $attributes = $__attributesOriginalbf9e60c730737961dc4cd2b8c711b9b5; ?>
<?php unset($__attributesOriginalbf9e60c730737961dc4cd2b8c711b9b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbf9e60c730737961dc4cd2b8c711b9b5)): ?>
<?php $component = $__componentOriginalbf9e60c730737961dc4cd2b8c711b9b5; ?>
<?php unset($__componentOriginalbf9e60c730737961dc4cd2b8c711b9b5); ?>
<?php endif; ?>
        <?php else: ?>
            <div class="rounded-xl border border-neutral-200 bg-white p-8 flex flex-col items-center justify-center min-h-40">
                <span class="text-sm text-neutral-400">Belum ada transaksi terbaru.</span>
            </div>
        <?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Perkuliahan Duniawi\MAGANG GES\PerpusKotaYogyakarta\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>