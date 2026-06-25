<?php $__env->startSection('title', 'Lokasi'); ?>
<?php $__env->startSection('page-title', 'Lokasi'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola data lokasi perpustakaan'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col gap-4">

    <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Lokasi','subtitle' => $lokasis->total() . ' lokasi terdaftar','icon' => 'location','buttonOnclick' => 'bukaModalLokasi()','routeLabel' => 'Tambah Lokasi','placeholder' => 'Cari nama lokasi, alamat...','searchId' => 'searchInput','stats' => [
            ['label' => 'Total', 'value' => $lokasis->total(), 'color' => 'text-neutral-800'],
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Lokasi','subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($lokasis->total() . ' lokasi terdaftar'),'icon' => 'location','button-onclick' => 'bukaModalLokasi()','route-label' => 'Tambah Lokasi','placeholder' => 'Cari nama lokasi, alamat...','search-id' => 'searchInput','stats' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            ['label' => 'Total', 'value' => $lokasis->total(), 'color' => 'text-neutral-800'],
        ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcb19cb35a534439097b02b8af91726ee)): ?>
<?php $attributes = $__attributesOriginalcb19cb35a534439097b02b8af91726ee; ?>
<?php unset($__attributesOriginalcb19cb35a534439097b02b8af91726ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcb19cb35a534439097b02b8af91726ee)): ?>
<?php $component = $__componentOriginalcb19cb35a534439097b02b8af91726ee; ?>
<?php unset($__componentOriginalcb19cb35a534439097b02b8af91726ee); ?>
<?php endif; ?>

    <div class="relative overflow-hidden rounded-2xl bg-white shadow-sm">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left   text-xs font-medium text-neutral-400 px-5 py-3">Nama Lokasi</th>
                        <th class="text-left   text-xs font-medium text-neutral-400 px-5 py-3">Alamat</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">No. Telepon</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Tanggal</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100" id="tableBody">
                    <?php $__empty_1 = true; $__currentLoopData = $lokasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-neutral-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <p class="text-xs font-semibold text-neutral-800"><?php echo e($lokasi->nama_lokasi); ?></p>
                            </td>
                            <td class="px-5 py-3.5 max-w-xs">
                                <p class="text-xs text-neutral-500 whitespace-normal leading-relaxed"><?php echo e($lokasi->alamat); ?></p>
                            </td>
                            <td class="px-5 py-3.5 text-xs text-neutral-500 font-mono text-center">
                                <?php echo e($lokasi->no_telp ?? '-'); ?>

                            </td>
                            <td class="px-5 py-3.5 text-xs text-neutral-400 text-center">
                                <?php echo e($lokasi->created_at->format('d M Y')); ?>

                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="button"
                                        onclick="bukaModalEditLokasi(<?php echo e(json_encode([
                                            'id'          => $lokasi->id,
                                            'nama_lokasi' => $lokasi->nama_lokasi,
                                            'alamat'      => $lokasi->alamat,
                                            'no_telp'     => $lokasi->no_telp,
                                        ])); ?>)"
                                        class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-primary-300 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                        <?php if (isset($component)) { $__componentOriginal32022bdceaa704d305484041fc21cb4a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal32022bdceaa704d305484041fc21cb4a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.edit','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.edit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal32022bdceaa704d305484041fc21cb4a)): ?>
<?php $attributes = $__attributesOriginal32022bdceaa704d305484041fc21cb4a; ?>
<?php unset($__attributesOriginal32022bdceaa704d305484041fc21cb4a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal32022bdceaa704d305484041fc21cb4a)): ?>
<?php $component = $__componentOriginal32022bdceaa704d305484041fc21cb4a; ?>
<?php unset($__componentOriginal32022bdceaa704d305484041fc21cb4a); ?>
<?php endif; ?>
                                        <span>Edit</span>
                                    </button>

                                    <button type="button"
                                        onclick="bukaModalHapusLokasi(
                                            '<?php echo e(route('admin.lokasi.destroy', $lokasi)); ?>',
                                            '<?php echo e(addslashes($lokasi->nama_lokasi)); ?>'
                                        )"
                                        class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-danger-300 hover:text-danger-600 hover:bg-danger-50 transition-colors">
                                        <?php if (isset($component)) { $__componentOriginalab518ebc45c56ecd96af42eff2f09240 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab518ebc45c56ecd96af42eff2f09240 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.delete','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalab518ebc45c56ecd96af42eff2f09240)): ?>
<?php $attributes = $__attributesOriginalab518ebc45c56ecd96af42eff2f09240; ?>
<?php unset($__attributesOriginalab518ebc45c56ecd96af42eff2f09240); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalab518ebc45c56ecd96af42eff2f09240)): ?>
<?php $component = $__componentOriginalab518ebc45c56ecd96af42eff2f09240; ?>
<?php unset($__componentOriginalab518ebc45c56ecd96af42eff2f09240); ?>
<?php endif; ?>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-10 h-10 rounded-2xl bg-neutral-100 flex items-center justify-center">
                                        <?php if (isset($component)) { $__componentOriginal529f05da3443eaef4aa8815e981f7826 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal529f05da3443eaef4aa8815e981f7826 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.location','data' => ['class' => 'w-5 h-5 text-neutral-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.location'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-neutral-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal529f05da3443eaef4aa8815e981f7826)): ?>
<?php $attributes = $__attributesOriginal529f05da3443eaef4aa8815e981f7826; ?>
<?php unset($__attributesOriginal529f05da3443eaef4aa8815e981f7826); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal529f05da3443eaef4aa8815e981f7826)): ?>
<?php $component = $__componentOriginal529f05da3443eaef4aa8815e981f7826; ?>
<?php unset($__componentOriginal529f05da3443eaef4aa8815e981f7826); ?>
<?php endif; ?>
                                    </div>
                                    <p class="text-sm font-medium text-neutral-500">Belum ada lokasi</p>
                                    <p class="text-xs text-neutral-400">Tambah lokasi terlebih dahulu</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($lokasis->hasPages()): ?>
            <div class="px-5 py-3 bg-neutral-50 border-t border-neutral-100">
                <?php echo e($lokasis->withQueryString()->links()); ?>

            </div>
        <?php endif; ?>
    </div>

</div>

<?php if($errors->any()): ?>
    <script>document.addEventListener('DOMContentLoaded', bukaModalLokasi);</script>
<?php endif; ?>

<?php echo $__env->make('admin.lokasi.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('admin.lokasi.edit', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('admin.lokasi.destroy', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/admin/lokasi/index.blade.php ENDPATH**/ ?>