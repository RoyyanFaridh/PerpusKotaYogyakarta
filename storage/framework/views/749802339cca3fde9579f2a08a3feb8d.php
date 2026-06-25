<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title'         => 'Halaman',
    'subtitle'      => null,
    'icon'          => 'book',
    'route'         => null,
    'routeLabel'    => 'Tambah',
    'buttonOnclick' => null,
    'searchId'      => 'searchInput',
    'placeholder'   => 'Cari...',
    'filters'       => [],
    'stats'         => [],
    'exportRoute'   => null,
]));

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

foreach (array_filter(([
    'title'         => 'Halaman',
    'subtitle'      => null,
    'icon'          => 'book',
    'route'         => null,
    'routeLabel'    => 'Tambah',
    'buttonOnclick' => null,
    'searchId'      => 'searchInput',
    'placeholder'   => 'Cari...',
    'filters'       => [],
    'stats'         => [],
    'exportRoute'   => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
    <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

    
    <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-neutral-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-700 flex items-center justify-center shrink-0">
                <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => 'icons.' . $icon] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
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
            <div class="flex flex-col justify-center">
                <p class="text-base font-semibold text-neutral-700 leading-tight"><?php echo e($title); ?></p>
                <?php if($subtitle): ?>
                    <p class="text-xs text-neutral-500 leading-tight mt-0.5"><?php echo e($subtitle); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <?php if($exportRoute): ?>
                <a href="<?php echo e($exportRoute); ?>"
                   title="Export Excel"
                   class="flex items-center gap-2 text-sm font-medium px-2.5 py-2.5 sm:px-4 rounded-lg border border-neutral-200 text-neutral-600 hover:bg-neutral-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    <span class="hidden sm:inline">Export Excel</span>
                </a>
            <?php endif; ?>

            <?php if($route): ?>
                <a href="<?php echo e(route($route)); ?>"
                   title="<?php echo e($routeLabel); ?>"
                   class="flex items-center gap-2 text-sm font-medium px-2.5 py-2.5 sm:px-4 rounded-lg bg-primary text-white hover:bg-primary-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    <span class="hidden sm:inline"><?php echo e($routeLabel); ?></span>
                </a>
            <?php elseif($buttonOnclick): ?>
                <button type="button"
                        onclick="<?php echo e($buttonOnclick); ?>"
                        title="<?php echo e($routeLabel); ?>"
                        class="flex items-center gap-2 text-sm font-medium px-2.5 py-2.5 sm:px-4 rounded-lg bg-primary text-white hover:bg-primary-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    <span class="hidden sm:inline"><?php echo e($routeLabel); ?></span>
                </button>
            <?php endif; ?>
        </div>
    </div>

    
    <?php if(!empty($stats)): ?>
        <?php
            $count = count($stats);
            $smCols = ['sm:grid-cols-1', 'sm:grid-cols-2', 'sm:grid-cols-3', 'sm:grid-cols-4'];
            $smClass = $smCols[min($count, 4) - 1] ?? 'sm:grid-cols-4';
            $baseCols = $count >= 3 ? 'grid-cols-2' : 'grid-cols-' . $count;
        ?>
        <div class="grid <?php echo e($baseCols); ?> <?php echo e($smClass); ?> border-b border-neutral-100">
            <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="px-5 py-4 flex flex-col gap-1
                    <?php echo e($index > 0 ? 'border-l border-neutral-100' : ''); ?>

                    <?php echo e(($index >= 2 && $count > 2) ? 'border-t border-neutral-100 sm:border-t-0' : ''); ?>">
                    <span class="text-2xl font-semibold <?php echo e($stat['color'] ?? 'text-neutral-800'); ?> leading-none tabular-nums">
                        <?php echo e($stat['value']); ?>

                    </span>
                    <span class="text-xs text-neutral-500"><?php echo e($stat['label']); ?></span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    
    <form method="GET" action="" class="px-5 py-4 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <label for="<?php echo e($searchId); ?>" class="sr-only"><?php echo e($placeholder); ?></label>
            <input type="text"
                   id="<?php echo e($searchId); ?>"
                   name="search"
                   value="<?php echo e(request('search')); ?>"
                   placeholder="<?php echo e($placeholder); ?>"
                   class="w-full pl-10 pr-4 py-2.5 text-sm rounded-lg border border-neutral-200 text-neutral-700 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
        </div>

        <?php $__currentLoopData = $filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex flex-col">
                <label for="<?php echo e($filter['id'] ?? $filter['name']); ?>" class="sr-only">
                    <?php echo e($filter['placeholder'] ?? $filter['name']); ?>

                </label>
                <select name="<?php echo e($filter['name']); ?>"
                        id="<?php echo e($filter['id'] ?? $filter['name']); ?>"
                        <?php echo e(isset($filter['onchange']) ? 'onchange=this.closest(\'form\').submit()' : ''); ?>

                        class="text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-600 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition bg-white h-full">
                    <option value=""><?php echo e($filter['placeholder'] ?? 'Semua'); ?></option>
                    <?php $__currentLoopData = $filter['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($option['value']); ?>"
                            <?php echo e(request($filter['name']) === (string)$option['value'] ? 'selected' : ''); ?>>
                            <?php echo e($option['label']); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </form>
</div><?php /**PATH D:\Perkuliahan Duniawi\MAGANG GES\PerpusKotaYogyakarta\resources\views/components/admin/page-header.blade.php ENDPATH**/ ?>