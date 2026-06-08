@props([
    'label'   => 'Label',
    'value'   => '0',
    'icon'    => 'book-up',
    'color'   => 'primary',
    'badge'   => null,
    'caption' => null,
    'href'    => null,
])

@php
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
@endphp

@if($href)
<a href="{{ $href }}" class="relative overflow-hidden rounded-xl bg-white border border-neutral-200 flex flex-col p-5 w-full hover:shadow-md hover:border-neutral-300 transition-all duration-200 cursor-pointer">
@else
<div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200 flex flex-col p-5 w-full">
@endif

    <div class="absolute top-0 left-0 right-0 h-0.5 {{ $c['accent'] }}"></div>

    <div class="flex items-center gap-3 mb-5 pr-8">
        <div class="shrink-0 w-10 h-10 rounded-xl {{ $c['icon_bg'] }} {{ $c['icon_tx'] }} flex items-center justify-center">
            <x-dynamic-component :component="'icons.' . $icon" class="w-5 h-5"/>
        </div>
        <span class="text-sm text-neutral-500 font-medium leading-tight">{{ $label }}</span>
    </div>

    <div class="flex items-end justify-between gap-3">
        <div class="flex flex-col gap-1.5">
            <span class="text-3xl font-semibold {{ $c['value'] }} leading-none tabular-nums">
                {{ $value }}
            </span>
            @if ($caption)
                <span class="text-xs text-neutral-500 leading-snug">{{ $caption }}</span>
            @endif
        </div>

        @if ($badge)
            <span class="shrink-0 text-xs font-medium px-2.5 py-1 rounded-full whitespace-nowrap {{ $c['badge'] }}">
                {{ $badge }}
            </span>
        @endif
    </div>

    <button
        aria-label="Opsi lainnya"
        class="absolute top-4 right-4 p-1.5 rounded-md text-neutral-300 hover:text-neutral-500 hover:bg-neutral-100 transition-colors">
        <x-icons.ellipsis aria-hidden="true"/>
    </button>

@if($href)
</a>
@else
</div>
@endif