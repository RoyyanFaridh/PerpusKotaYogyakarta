<?php $__env->startSection('title', 'Kegiatan'); ?>
<?php $__env->startSection('page-title', 'Kegiatan'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola rencana kegiatan perpustakaan'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col gap-4">

    <?php if (isset($component)) { $__componentOriginalcb19cb35a534439097b02b8af91726ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcb19cb35a534439097b02b8af91726ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.page-header','data' => ['title' => 'Kegiatan','subtitle' => $kegiatans->total() . ' kegiatan terdaftar','icon' => 'calendar','buttonOnclick' => 'bukaModalKegiatan()','routeLabel' => 'Tambah Kegiatan','placeholder' => 'Cari nama kegiatan, deskripsi...','searchId' => 'searchInput','stats' => [
            ['label' => 'Total',       'value' => $kegiatans->total(), 'color' => 'text-neutral-800'],
            ['label' => 'Akan Datang', 'value' => $kegiatans->getCollection()->filter(fn($k) => $k->status_otomatis === 'akan_berlangsung')->count(),  'color' => 'text-blue-600'],
            ['label' => 'Berlangsung', 'value' => $kegiatans->getCollection()->filter(fn($k) => $k->status_otomatis === 'sedang_berlangsung')->count(), 'color' => 'text-yellow-600'],
            ['label' => 'Selesai',     'value' => $kegiatans->getCollection()->filter(fn($k) => $k->status_otomatis === 'selesai')->count(),            'color' => 'text-green-600'],
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Kegiatan','subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kegiatans->total() . ' kegiatan terdaftar'),'icon' => 'calendar','button-onclick' => 'bukaModalKegiatan()','route-label' => 'Tambah Kegiatan','placeholder' => 'Cari nama kegiatan, deskripsi...','search-id' => 'searchInput','stats' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            ['label' => 'Total',       'value' => $kegiatans->total(), 'color' => 'text-neutral-800'],
            ['label' => 'Akan Datang', 'value' => $kegiatans->getCollection()->filter(fn($k) => $k->status_otomatis === 'akan_berlangsung')->count(),  'color' => 'text-blue-600'],
            ['label' => 'Berlangsung', 'value' => $kegiatans->getCollection()->filter(fn($k) => $k->status_otomatis === 'sedang_berlangsung')->count(), 'color' => 'text-yellow-600'],
            ['label' => 'Selesai',     'value' => $kegiatans->getCollection()->filter(fn($k) => $k->status_otomatis === 'selesai')->count(),            'color' => 'text-green-600'],
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

    <?php if(session('success')): ?>
        <div class="flex items-center gap-2.5 px-5 py-3 bg-success-50 border border-success-100 rounded-xl text-success-700 text-sm font-medium">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left text-xs font-semibold text-neutral-500 px-5 py-3">Tanggal & Jam</th>
                        <th class="text-left text-xs font-semibold text-neutral-500 px-4 py-3">Nama Kegiatan</th>
                        <th class="text-left text-xs font-semibold text-neutral-500 px-4 py-3">Lokasi</th>
                        <th class="text-left text-xs font-semibold text-neutral-500 px-4 py-3">Deskripsi</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Status</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50" id="tableBody">
                    <?php $__empty_1 = true; $__currentLoopData = $kegiatans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kegiatan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php $statusOtomatis = $kegiatan->status_otomatis; ?>
                        <tr class="hover:bg-neutral-50 transition-colors <?php echo e($statusOtomatis === 'selesai' ? 'opacity-50' : ''); ?>">

                            
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <p class="text-xs font-semibold text-neutral-800">
                                    <?php echo e(\Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y')); ?>

                                    <?php if($kegiatan->tanggal_selesai && $kegiatan->tanggal_selesai->ne($kegiatan->tanggal_mulai)): ?>
                                        <span class="text-neutral-400 font-normal">
                                            – <?php echo e($kegiatan->tanggal_selesai->format('d M Y')); ?>

                                        </span>
                                    <?php endif; ?>
                                </p>
                                <?php if($kegiatan->jam_pelaksanaan): ?>
                                    <p class="text-[0.68rem] text-neutral-400 flex items-center gap-1 mt-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                        <?php echo e(\Carbon\Carbon::parse($kegiatan->jam_pelaksanaan)->format('H:i')); ?>

                                        <?php if($kegiatan->jam_selesai): ?>
                                            – <?php echo e(\Carbon\Carbon::parse($kegiatan->jam_selesai)->format('H:i')); ?>

                                        <?php endif; ?>
                                        WIB
                                    </p>
                                <?php endif; ?>
                            </td>

                            
                            <td class="px-4 py-3.5">
                                <p class="text-xs font-semibold text-neutral-800"><?php echo e($kegiatan->nama_kegiatan); ?></p>
                            </td>

                            
                            <td class="px-4 py-3.5">
                                <?php if($kegiatan->lokasi): ?>
                                    <span class="text-xs text-neutral-600"><?php echo e($kegiatan->lokasi->nama_lokasi); ?></span>
                                <?php else: ?>
                                    <span class="text-xs text-neutral-300">—</span>
                                <?php endif; ?>
                            </td>

                            
                            <td class="px-4 py-3.5 max-w-50">
                                <p class="text-xs text-neutral-500 truncate"><?php echo e($kegiatan->deskripsi ?? '—'); ?></p>
                            </td>

                            
                            <td class="px-4 py-3.5 text-center">
                                <?php
                                    $statusMap = [
                                        'akan_berlangsung'   => ['label' => 'Akan Berlangsung',  'class' => 'bg-blue-50 text-blue-600',     'dot' => 'bg-blue-400'],
                                        'sedang_berlangsung' => ['label' => 'Sedang Berlangsung', 'class' => 'bg-yellow-50 text-yellow-600', 'dot' => 'bg-yellow-400'],
                                        'selesai'            => ['label' => 'Selesai',            'class' => 'bg-neutral-100 text-neutral-400', 'dot' => 'bg-neutral-300'],
                                    ];
                                    $st = $statusMap[$statusOtomatis];
                                ?>
                                <span class="inline-flex items-center gap-1.5 text-[0.68rem] font-medium px-2 py-0.5 rounded-full <?php echo e($st['class']); ?>">
                                    <span class="w-1.5 h-1.5 rounded-full <?php echo e($st['dot']); ?>

                                        <?php echo e($statusOtomatis === 'sedang_berlangsung' ? 'animate-pulse' : ''); ?>">
                                    </span>
                                    <?php echo e($st['label']); ?>

                                </span>
                            </td>

                            
                            <td class="px-4 py-3.5">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="button"
                                            onclick="bukaModalEditKegiatan(<?php echo e($kegiatan->id); ?>)"
                                            class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-warning-300 hover:text-warning-600 hover:bg-warning-50 transition-colors">
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
                                            onclick="bukaModalHapusKegiatan(
                                                '<?php echo e(route('admin.kegiatan.destroy', $kegiatan)); ?>',
                                                '<?php echo e(addslashes($kegiatan->nama_kegiatan)); ?>'
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
                                    <div class="w-10 h-10 rounded-xl bg-neutral-100 flex items-center justify-center">
                                        <?php if (isset($component)) { $__componentOriginalac5ce4cb0e7217f92544b8be719adb6f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalac5ce4cb0e7217f92544b8be719adb6f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.calendar','data' => ['class' => 'w-5 h-5 text-neutral-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-neutral-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalac5ce4cb0e7217f92544b8be719adb6f)): ?>
<?php $attributes = $__attributesOriginalac5ce4cb0e7217f92544b8be719adb6f; ?>
<?php unset($__attributesOriginalac5ce4cb0e7217f92544b8be719adb6f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalac5ce4cb0e7217f92544b8be719adb6f)): ?>
<?php $component = $__componentOriginalac5ce4cb0e7217f92544b8be719adb6f; ?>
<?php unset($__componentOriginalac5ce4cb0e7217f92544b8be719adb6f); ?>
<?php endif; ?>
                                    </div>
                                    <p class="text-sm font-medium text-neutral-500">Belum ada kegiatan</p>
                                    <p class="text-xs text-neutral-400">Tambah kegiatan terlebih dahulu</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($kegiatans->hasPages()): ?>
            <div class="px-5 py-3 bg-neutral-50 border-t border-neutral-100">
                <?php echo e($kegiatans->withQueryString()->links()); ?>

            </div>
        <?php endif; ?>
    </div>

</div>

<?php echo $__env->make('admin.kegiatan.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('admin.kegiatan.edit', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('admin.kegiatan.destroy', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Perkuliahan Duniawi\MAGANG GES\PerpusKotaYogyakarta\resources\views/admin/kegiatan/index.blade.php ENDPATH**/ ?>