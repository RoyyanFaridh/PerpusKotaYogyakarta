<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['paket']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['paket']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
$isAktif = $paket->is_aktif;
?>

<div class="rounded-xl border border-neutral-200 bg-white overflow-hidden"
     x-data="{ open: true }">

    
    <button type="button"
            @click="open = !open"
            class="w-full flex items-center justify-between px-5 py-3.5 bg-neutral-50 hover:bg-neutral-100 transition-colors border-b border-neutral-200">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg <?php echo e($isAktif ? 'bg-warning-50 text-warning-700' : 'bg-neutral-100 text-neutral-400'); ?> flex items-center justify-center shrink-0">
                <?php if (isset($component)) { $__componentOriginalb90ef4b4c5059d0c6376a35a031a7fe8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb90ef4b4c5059d0c6376a35a031a7fe8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.package','data' => ['class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.package'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb90ef4b4c5059d0c6376a35a031a7fe8)): ?>
<?php $attributes = $__attributesOriginalb90ef4b4c5059d0c6376a35a031a7fe8; ?>
<?php unset($__attributesOriginalb90ef4b4c5059d0c6376a35a031a7fe8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb90ef4b4c5059d0c6376a35a031a7fe8)): ?>
<?php $component = $__componentOriginalb90ef4b4c5059d0c6376a35a031a7fe8; ?>
<?php unset($__componentOriginalb90ef4b4c5059d0c6376a35a031a7fe8); ?>
<?php endif; ?>
            </div>
            <div class="text-left">
                <p class="text-sm font-semibold text-neutral-800 leading-tight"><?php echo e($paket->nama); ?></p>
                <p class="text-xs text-neutral-400 mt-0.5">
                    <?php echo e($paket->lokasi?->nama_lokasi ?? 'Belum ada lokasi'); ?>

                    · <?php echo e($paket->eksemplars_count); ?> eksemplar
                    · <?php echo e($paket->eksemplars_sum_stok ?? 0); ?> stok
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <span class="text-xs font-medium px-2 py-0.5 rounded-full <?php echo e($isAktif ? 'bg-warning-50 text-warning-700' : 'bg-neutral-100 text-neutral-500'); ?>">
                <?php echo e($isAktif ? 'Aktif' : 'Tidak Aktif'); ?>

            </span>
            <svg class="w-4 h-4 text-neutral-400 transition-transform"
                 :class="open ? 'rotate-180' : ''"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="6 9 12 15 18 9"/>
            </svg>
        </div>
    </button>

    <div x-show="open" x-collapse>
        <?php if($paket->eksemplars->isEmpty()): ?>
            <div class="px-5 py-8 text-center">
                <p class="text-xs text-neutral-400">Belum ada buku dalam paket ini.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full min-w-150 text-sm">
                    <thead>
                        <tr class="border-b border-neutral-100 bg-neutral-50/50">
                            <th class="text-left text-xs font-medium text-neutral-500 px-5 py-2.5">Judul</th>
                            <th class="text-center text-xs font-medium text-neutral-500 px-4 py-2.5">ISBN</th>
                            <th class="text-center text-xs font-medium text-neutral-500 px-4 py-2.5">Kategori</th>
                            <th class="text-center text-xs font-medium text-neutral-500 px-4 py-2.5">Stok</th>
                            <th class="text-center text-xs font-medium text-neutral-500 px-4 py-2.5">Tampil</th>
                            <th class="text-center text-xs font-medium text-neutral-500 px-4 py-2.5">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-50">
                        <?php $__currentLoopData = $paket->eksemplars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eksemplar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginal9d0b8040ecf323afcc034ce550fc9aba = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9d0b8040ecf323afcc034ce550fc9aba = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.buku.eksemplar-row','data' => ['eksemplar' => $eksemplar]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.buku.eksemplar-row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eksemplar' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($eksemplar)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9d0b8040ecf323afcc034ce550fc9aba)): ?>
<?php $attributes = $__attributesOriginal9d0b8040ecf323afcc034ce550fc9aba; ?>
<?php unset($__attributesOriginal9d0b8040ecf323afcc034ce550fc9aba); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9d0b8040ecf323afcc034ce550fc9aba)): ?>
<?php $component = $__componentOriginal9d0b8040ecf323afcc034ce550fc9aba; ?>
<?php unset($__componentOriginal9d0b8040ecf323afcc034ce550fc9aba); ?>
<?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</div><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/components/admin/buku/paket-group.blade.php ENDPATH**/ ?>