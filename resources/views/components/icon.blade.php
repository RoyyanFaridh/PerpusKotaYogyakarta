@props([
    'name',
    'size' => 'md',
    'variant' => null,
    'strokeWidth' => 2,
])

@php
    $sizes = [
        'xs' => 'w-3 h-3',
        'sm' => 'w-4 h-4',
        'md' => 'w-5 h-5',
        'lg' => 'w-6 h-6',
        'xl' => 'w-7 h-7',
    ];

    $variants = [
        'success' => 'text-success-600',
        'danger'  => 'text-danger-600',
        'warning' => 'text-warning-600',
        'primary' => 'text-primary-600',
        'neutral' => 'text-neutral-500',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $variantClass = $variant ? ($variants[$variant] ?? '') : '';

    $finalClass = trim($sizeClass . ' ' . $variantClass);

    $component = 'icons.' . $name;

    if (!view()->exists('components.' . $component)) {
        $component = 'icons.document';
    }
@endphp

<x-dynamic-component 
    :component="$component"
    {{ $attributes->merge([
        'class' => $finalClass,
        'stroke-width' => $strokeWidth
    ]) }}
/>