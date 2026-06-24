<?php
    $aktivitas ??= [];

    $tipeConfig = [
        'transaksi_disetujui' => ['bg' => 'bg-success-50', 'text' => 'text-success-600', 'icon' => 'check-circle'],
        'transaksi_ditolak'   => ['bg' => 'bg-danger-50',  'text' => 'text-danger-600',  'icon' => 'x-circle'],
        'transaksi_pending'   => ['bg' => 'bg-warning-50', 'text' => 'text-warning-600', 'icon' => 'refresh'],
        'buku_masuk'          => ['bg' => 'bg-primary-50', 'text' => 'text-primary-600', 'icon' => 'book-open'],
        'member_baru'         => ['bg' => 'bg-neutral-100','text' => 'text-neutral-500', 'icon' => 'user-plus'],
        'sisa_buku'           => ['bg' => 'bg-warning-50', 'text' => 'text-warning-600', 'icon' => 'package'],
    ];

    $defaultConfig = $tipeConfig['transaksi_pending'];
?>

<div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200 flex flex-col h-full">

    <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

    
    <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-neutral-100 shrink-0">
        <div class="flex items-center gap-3">
            
            <div class="shrink-0 w-10 h-10 rounded-xl bg-primary-50 text-primary-700 flex items-center justify-center">
                
                <?php if (isset($component)) { $__componentOriginal4525404018e5b2e94f2d1e4dc53d4ad7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4525404018e5b2e94f2d1e4dc53d4ad7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.bell','data' => ['class' => 'w-5 h-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.bell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4525404018e5b2e94f2d1e4dc53d4ad7)): ?>
<?php $attributes = $__attributesOriginal4525404018e5b2e94f2d1e4dc53d4ad7; ?>
<?php unset($__attributesOriginal4525404018e5b2e94f2d1e4dc53d4ad7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4525404018e5b2e94f2d1e4dc53d4ad7)): ?>
<?php $component = $__componentOriginal4525404018e5b2e94f2d1e4dc53d4ad7; ?>
<?php unset($__componentOriginal4525404018e5b2e94f2d1e4dc53d4ad7); ?>
<?php endif; ?>
            </div>
            <div class="flex flex-col justify-center">
                
                <h2 class="text-sm font-semibold text-neutral-700 leading-tight">Aktivitas Terkini</h2>
                
                <p class="text-xs text-neutral-500 mt-0.5">Update real-time sistem</p>
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
        <?php $__empty_1 = true; $__currentLoopData = $aktivitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $cfg = $tipeConfig[$item['tipe'] ?? ''] ?? $defaultConfig;
            ?>
            <li class="flex items-start gap-3 px-5 py-3 hover:bg-neutral-50 transition-colors">
                
                <div class="w-9 h-9 rounded-lg <?php echo e($cfg['bg']); ?> flex items-center justify-center shrink-0 mt-0.5">
                    
                    
                    <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => 'icons.' . $cfg['icon']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 '.e($cfg['text']).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-neutral-700 leading-snug">
                        <?php echo e($item['pesan'] ?? '-'); ?>

                    </p>
                    <?php if(!empty($item['sub'])): ?>
                        
                        <p class="text-xs text-neutral-500 mt-0.5 truncate">
                            <?php echo e($item['sub']); ?>

                        </p>
                    <?php endif; ?>
                </div>
                
                <span class="text-xs text-neutral-500 shrink-0 mt-0.5 whitespace-nowrap tabular-nums">
                    <?php echo e($item['waktu'] ?? '-'); ?>

                </span>
            </li>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <li class="flex flex-col items-center justify-center py-12 text-center px-4">
                <div class="w-10 h-10 rounded-xl bg-neutral-100 flex items-center justify-center mb-3">
                    
                    <?php if (isset($component)) { $__componentOriginalb373b622f13e92e969f88b7e3de0faae = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb373b622f13e92e969f88b7e3de0faae = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.document','data' => ['class' => 'w-5 h-5 text-neutral-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.document'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-neutral-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb373b622f13e92e969f88b7e3de0faae)): ?>
<?php $attributes = $__attributesOriginalb373b622f13e92e969f88b7e3de0faae; ?>
<?php unset($__attributesOriginalb373b622f13e92e969f88b7e3de0faae); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb373b622f13e92e969f88b7e3de0faae)): ?>
<?php $component = $__componentOriginalb373b622f13e92e969f88b7e3de0faae; ?>
<?php unset($__componentOriginalb373b622f13e92e969f88b7e3de0faae); ?>
<?php endif; ?>
                </div>
                <p class="text-sm font-medium text-neutral-500">Belum ada aktivitas</p>
                
                <p class="text-xs text-neutral-500 mt-1">Aktivitas terbaru akan muncul di sini</p>
            </li>
        <?php endif; ?>

    </ul>

    <?php if(!empty($aktivitas)): ?>
        <div class="px-5 py-3 bg-neutral-50 border-t border-neutral-100 shrink-0">
            
            <p class="text-xs text-neutral-500">
                Menampilkan <?php echo e(count($aktivitas)); ?> aktivitas terbaru.
            </p>
        </div>
    <?php endif; ?>

</div><?php /**PATH D:\Perkuliahan Duniawi\MAGANG GES\PerpusKotaYogyakarta\resources\views/components/admin/dashboard/aktivitas-terkini.blade.php ENDPATH**/ ?>