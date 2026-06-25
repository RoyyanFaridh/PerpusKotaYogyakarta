<?php
    $kategoris = $kategoris ?? [
        ['nama' => 'Umum/Komputer',        'jumlah' => 84,  'warna' => 'indigo'],
        ['nama' => 'Filsafat & Psikologi', 'jumlah' => 57,  'warna' => 'violet'],
        ['nama' => 'Agama',                'jumlah' => 43,  'warna' => 'rose'],
        ['nama' => 'Ilmu Sosial',          'jumlah' => 38,  'warna' => 'amber'],
        ['nama' => 'Bahasa',               'jumlah' => 29,  'warna' => 'teal'],
        ['nama' => 'Sains & Matematika',   'jumlah' => 17,  'warna' => 'success'],
        ['nama' => 'Teknologi',            'jumlah' => 12,  'warna' => 'danger'],
        ['nama' => 'Seni & Rekreasi',      'jumlah' => 9,   'warna' => 'primary'],
        ['nama' => 'Literatur & Sastra',   'jumlah' => 7,   'warna' => 'neutral'],
        ['nama' => 'Geografi & Sejarah',   'jumlah' => 5,   'warna' => 'sky'],
    ];

    $total = collect($kategoris)->sum('jumlah');

    $colorMap = [
        'indigo' => ['bar' => 'bg-indigo-400', 'badge' => 'bg-indigo-50 text-indigo-700',   'dot' => 'bg-indigo-400'],
        'violet' => ['bar' => 'bg-violet-400', 'badge' => 'bg-violet-50 text-violet-700',   'dot' => 'bg-violet-400'],
        'rose'   => ['bar' => 'bg-rose-400',   'badge' => 'bg-rose-50 text-rose-700',       'dot' => 'bg-rose-400'],
        'amber'  => ['bar' => 'bg-amber-400',  'badge' => 'bg-amber-50 text-amber-700',     'dot' => 'bg-amber-400'],
        'teal'   => ['bar' => 'bg-teal-400',   'badge' => 'bg-teal-50 text-teal-700',       'dot' => 'bg-teal-400'],
        'sky'    => ['bar' => 'bg-sky-400',    'badge' => 'bg-sky-50 text-sky-700',         'dot' => 'bg-sky-400'],
        'success'=> ['bar' => 'bg-success-400','badge' => 'bg-success-50 text-success-700', 'dot' => 'bg-success-400'],
        'danger' => ['bar' => 'bg-danger-400', 'badge' => 'bg-danger-50 text-danger-700',   'dot' => 'bg-danger-400'],
        'primary'=> ['bar' => 'bg-primary-400','badge' => 'bg-primary-50 text-primary-700', 'dot' => 'bg-primary-400'],
        'neutral'=> ['bar' => 'bg-neutral-400','badge' => 'bg-neutral-100 text-neutral-600','dot' => 'bg-neutral-400'],
    ];

    $colorDefault = ['bar' => 'bg-neutral-300', 'badge' => 'bg-neutral-100 text-neutral-500', 'dot' => 'bg-neutral-300'];
?>

<div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">

    <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

    
    <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-neutral-100">
        <div class="flex items-center gap-3">
            
            <div class="shrink-0 w-10 h-10 rounded-xl bg-primary-50 text-primary-700 flex items-center justify-center">
                
                <?php if (isset($component)) { $__componentOriginalb8c63901edd685c28abddfe7934b0b5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8c63901edd685c28abddfe7934b0b5d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.book-up','data' => ['class' => 'w-5 h-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.book-up'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb8c63901edd685c28abddfe7934b0b5d)): ?>
<?php $attributes = $__attributesOriginalb8c63901edd685c28abddfe7934b0b5d; ?>
<?php unset($__attributesOriginalb8c63901edd685c28abddfe7934b0b5d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb8c63901edd685c28abddfe7934b0b5d)): ?>
<?php $component = $__componentOriginalb8c63901edd685c28abddfe7934b0b5d; ?>
<?php unset($__componentOriginalb8c63901edd685c28abddfe7934b0b5d); ?>
<?php endif; ?>
            </div>
            <div class="flex flex-col justify-center">
                
                <h2 class="text-sm font-semibold text-neutral-700 leading-tight">Penukaran per Kategori</h2>
                <p class="text-xs text-neutral-500 mt-0.5">
                    Total <span class="font-semibold text-neutral-600"><?php echo e(number_format($total)); ?></span> penukaran bulan ini
                </p>
            </div>
        </div>
        
        <button aria-label="Opsi lainnya"
                class="p-1.5 rounded-md text-neutral-300 hover:text-neutral-500 hover:bg-neutral-100 transition-colors">
            <?php if (isset($component)) { $__componentOriginal21c22a7710b3816cb36091ef95b53569 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal21c22a7710b3816cb36091ef95b53569 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.ellipsis','data' => ['ariaHidden' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.ellipsis'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['aria-hidden' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal21c22a7710b3816cb36091ef95b53569)): ?>
<?php $attributes = $__attributesOriginal21c22a7710b3816cb36091ef95b53569; ?>
<?php unset($__attributesOriginal21c22a7710b3816cb36091ef95b53569); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal21c22a7710b3816cb36091ef95b53569)): ?>
<?php $component = $__componentOriginal21c22a7710b3816cb36091ef95b53569; ?>
<?php unset($__componentOriginal21c22a7710b3816cb36091ef95b53569); ?>
<?php endif; ?>
        </button>
    </div>

    
    
    <ul class="divide-y divide-neutral-100 px-5 max-h-96 overflow-y-auto custom-scroll">
        <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $persen = $total > 0 ? round(($item['jumlah'] / $total) * 100) : 0;
                $colors = $colorMap[$item['warna']] ?? $colorDefault;
            ?>
            <li class="py-3 flex flex-col gap-2">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2 min-w-0">
                        <span class="w-2 h-2 rounded-full shrink-0 <?php echo e($colors['dot']); ?>"></span>
                        
                        <span class="text-sm font-medium text-neutral-700 truncate"><?php echo e($item['nama']); ?></span>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        
                        <span class="text-sm font-semibold text-neutral-800 tabular-nums">
                            <?php echo e(number_format($item['jumlah'])); ?>

                        </span>
                        <span class="text-xs font-medium px-1.5 py-0.5 rounded-full tabular-nums <?php echo e($colors['badge']); ?>">
                            <?php echo e($persen); ?>%
                        </span>
                    </div>
                </div>
                
                <div class="w-full h-2 bg-neutral-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-700 <?php echo e($colors['bar']); ?>"
                         style="width: <?php echo e($persen); ?>%"></div>
                </div>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    
    <div class="px-5 py-3 bg-neutral-50 border-t border-neutral-100">
        
        <p class="text-xs text-neutral-500">
            Data dihitung dari seluruh transaksi tukar yang berhasil dikonfirmasi.
        </p>
    </div>

</div><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/components/admin/dashboard/penukaran-per-kategori.blade.php ENDPATH**/ ?>