<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['eksemplar']));

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

foreach (array_filter((['eksemplar']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
$buku           = $eksemplar->buku;
$categoryColorMap = [
    'Umum/Komputer'        => 'bg-primary-50 text-primary-700',
    'Filsafat & Psikologi' => 'bg-warning-50 text-warning-700',
    'Agama'                => 'bg-danger-50 text-danger-700',
    'Ilmu Sosial'          => 'bg-success-50 text-success-700',
    'Bahasa'               => 'bg-primary-50 text-primary-800',
    'Sains & Matematika'   => 'bg-success-50 text-success-800',
    'Teknologi'            => 'bg-neutral-100 text-neutral-600',
    'Seni & Rekreasi'      => 'bg-warning-50 text-warning-800',
    'Literatur & Sastra'   => 'bg-neutral-100 text-neutral-500',
    'Geografi & Sejarah'   => 'bg-primary-50 text-primary-600',
];
$catClass = $categoryColorMap[$buku->kategori ?? ''] ?? 'bg-neutral-100 text-neutral-500';
?>

<tr class="hover:bg-neutral-50 transition-colors">

    
    <td class="px-5 py-3">
        <p class="text-xs font-semibold text-neutral-800 leading-snug line-clamp-2"><?php echo e($buku->judul); ?></p>
        <p class="text-xs text-neutral-400 mt-0.5"><?php echo e($buku->pengarang); ?>

            <?php if($buku->tahun_terbit): ?>
                · <?php echo e($buku->tahun_terbit); ?>

            <?php endif; ?>
        </p>
    </td>

    
    <td class="px-4 py-3 text-center">
        <span class="text-xs font-mono text-neutral-500"><?php echo e($buku->isbn ?? '—'); ?></span>
    </td>

    
    <td class="px-4 py-3 text-center">
        <?php if($buku->kategori): ?>
            <span class="text-xs font-medium px-2 py-0.5 rounded-full <?php echo e($catClass); ?>">
                <?php echo e($buku->kategori); ?>

            </span>
        <?php else: ?>
            <span class="text-xs text-neutral-400">—</span>
        <?php endif; ?>
    </td>

    
    <td class="px-4 py-3 text-center">
        <?php if($eksemplar->stok > 0): ?>
            <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-success-50 text-success-700">
                <?php echo e($eksemplar->stok); ?> tersedia
            </span>
        <?php else: ?>
            <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-danger-50 text-danger-700">
                Habis
            </span>
        <?php endif; ?>
    </td>

    <td class="px-4 py-3 text-center">
        <?php if($eksemplar->paket?->is_aktif): ?>
            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-success-50 text-success-700">
                Tampil
            </span>
        <?php else: ?>
            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-neutral-100 text-neutral-500">
                Tersembunyi
            </span>
        <?php endif; ?>
    </td>

    
    <td class="px-4 py-3 text-center">
        <div class="flex items-center justify-center gap-1.5">
            <button type="button"
                onclick="bukaModalEditBuku(<?php echo e(json_encode([
                    'id'            => $buku->id,
                    'judul'         => $buku->judul,
                    'pengarang'     => $buku->pengarang,
                    'penerbit'      => $buku->penerbit,
                    'isbn'          => $buku->isbn,
                    'tahun_terbit'  => $buku->tahun_terbit,
                    'tempat_terbit' => $buku->tempat_terbit,
                    'resume'        => $buku->resume,
                    'kategori'      => $buku->kategori,
                    'deskripsi'     => $buku->deskripsi,
                    'is_visible'    => $buku->is_visible,
                    'cover'         => $buku->cover,
                    'eksemplar_id'  => $eksemplar->id,
                    'stok'          => $eksemplar->stok,
                    'paket_id'      => $eksemplar->paket_id,
                ])); ?>)"
                class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-warning-300 hover:text-warning-600 hover:bg-warning-50 transition-colors">
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
                onclick="bukaModalHapusBuku(
                    '<?php echo e(route('admin.buku.destroy', $buku)); ?>',
                    '<?php echo e(addslashes($buku->judul)); ?>'
                )"
                class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-danger-300 hover:text-danger-600 hover:bg-danger-50 transition-colors">
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

</tr><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/components/admin/buku/eksemplar-row.blade.php ENDPATH**/ ?>