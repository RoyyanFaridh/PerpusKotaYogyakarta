<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['class']));

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

foreach (array_filter((['class']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php if (isset($component)) { $__componentOriginalb8c63901edd685c28abddfe7934b0b5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8c63901edd685c28abddfe7934b0b5d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.book-up','data' => ['class' => $class]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.book-up'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($class)]); ?>

<?php echo e($slot ?? ""); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb8c63901edd685c28abddfe7934b0b5d)): ?>
<?php $attributes = $__attributesOriginalb8c63901edd685c28abddfe7934b0b5d; ?>
<?php unset($__attributesOriginalb8c63901edd685c28abddfe7934b0b5d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb8c63901edd685c28abddfe7934b0b5d)): ?>
<?php $component = $__componentOriginalb8c63901edd685c28abddfe7934b0b5d; ?>
<?php unset($__componentOriginalb8c63901edd685c28abddfe7934b0b5d); ?>
<?php endif; ?><?php /**PATH D:\Perkuliahan Duniawi\MAGANG GES\PerpusKotaYogyakarta\storage\framework\views/dcbb38d1a2e3d14c1940a77efb33165f.blade.php ENDPATH**/ ?>