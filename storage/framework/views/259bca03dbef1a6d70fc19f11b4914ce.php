<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label'   => 'Label',
    'value'   => '0',
    'icon'    => 'book-up',
    'color'   => 'primary',
    'badge'   => null,
    'caption' => null,
    'href'    => null,
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
    'label'   => 'Label',
    'value'   => '0',
    'icon'    => 'book-up',
    'color'   => 'primary',
    'badge'   => null,
    'caption' => null,
    'href'    => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $colorMap = [
        'primary' => [
            'icon_bg' => 'bg-primary-50',
            'icon_tx' => 'text-primary-700',
            'value'   => 'text-primary-800',
            'badge'   => 'bg-primary-50 text-primary-700',
            'accent'  => 'bg-primary-400',
        ],
        'success' => [
            'icon_bg' => 'bg-success-50',
            'icon_tx' => 'text-success-700',
            'value'   => 'text-success-800',
            'badge'   => 'bg-success-50 text-success-700',
            'accent'  => 'bg-success-500',
        ],
        'warning' => [
            'icon_bg' => 'bg-warning-50',
            'icon_tx' => 'text-warning-700',
            'value'   => 'text-warning-800',
            'badge'   => 'bg-warning-50 text-warning-700',
            'accent'  => 'bg-warning-500',
        ],
        'danger' => [
            'icon_bg' => 'bg-danger-50',
            'icon_tx' => 'text-danger-700',
            'value'   => 'text-danger-800',
            'badge'   => 'bg-danger-50 text-danger-700',
            'accent'  => 'bg-danger-500',
        ],
    ];
    $c = $colorMap[$color] ?? $colorMap['primary'];
?>

<?php if($href): ?>
<a href="<?php echo e($href); ?>" class="relative overflow-hidden rounded-xl bg-white border border-neutral-200 flex flex-col p-5 w-full hover:shadow-md hover:border-neutral-300 transition-all duration-200 cursor-pointer">
<?php else: ?>
<div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200 flex flex-col p-5 w-full">
<?php endif; ?>

    <div class="absolute top-0 left-0 right-0 h-0.5 <?php echo e($c['accent']); ?>"></div>

    <div class="flex items-center gap-3 mb-5 pr-8">
        <div class="shrink-0 w-10 h-10 rounded-xl <?php echo e($c['icon_bg']); ?> <?php echo e($c['icon_tx']); ?> flex items-center justify-center">
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
        <span class="text-sm text-neutral-500 font-medium leading-tight"><?php echo e($label); ?></span>
    </div>

    <div class="flex items-end justify-between gap-3">
        <div class="flex flex-col gap-1.5">
            <span class="text-3xl font-semibold <?php echo e($c['value']); ?> leading-none tabular-nums">
                <?php echo e($value); ?>

            </span>
            <?php if($caption): ?>
                <span class="text-xs text-neutral-500 leading-snug"><?php echo e($caption); ?></span>
            <?php endif; ?>
        </div>

        <?php if($badge): ?>
            <span class="shrink-0 text-xs font-medium px-2.5 py-1 rounded-full whitespace-nowrap <?php echo e($c['badge']); ?>">
                <?php echo e($badge); ?>

            </span>
        <?php endif; ?>
    </div>

    <button
        aria-label="Opsi lainnya"
        class="absolute top-4 right-4 p-1.5 rounded-md text-neutral-300 hover:text-neutral-500 hover:bg-neutral-100 transition-colors">
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

<?php if($href): ?>
</a>
<?php else: ?>
</div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/components/admin/dashboard/stat-card.blade.php ENDPATH**/ ?>