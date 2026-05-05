@props([
    'label'   => 'Label',
    'value'   => '0',
    'icon'    => 'document',  {{-- 'document' | 'book' | 'clock' | 'swap' | 'check' --}}
    'color'   => 'primary',   {{-- 'primary' | 'success' | 'warning' | 'danger' --}}
    'badge'   => null,        {{-- opsional: '+8% dari kemarin' --}}
    'caption' => null,        {{-- opsional: 'Total transaksi tukar buku' --}}
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

<div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200 flex flex-col min-h-40 p-5 pb-0">

    <button class="absolute top-4 right-4 p-1 rounded-md text-neutral-300 hover:text-neutral-500 hover:bg-neutral-100 transition-colors">
        <x-icons.ellipsis/>
    </button>

    <div class="flex items-center gap-3 mb-5 pr-7">
        <div class="shrink-0 w-9 h-9 rounded-xl {{ $c['icon_bg'] }} {{ $c['icon_tx'] }} flex items-center justify-center">
            @if ($icon === 'book')
                <x-icons.book/>
            @elseif ($icon === 'clock')
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
            @elseif ($icon === 'swap')
                <x-icons.transaksi/>
            @elseif ($icon === 'check')
                <x-icons.clock/>
            @else
                <x-icons.book-up/>
            @endif
        </div>
        <span class="text-md text-neutral-500 font-semibold leading-tight">{{ $label }}</span>
    </div>

    <div class="flex items-center justify-between gap-3 flex-1 pb-5">
        <div class="flex flex-col gap-3">
            <span class="text-3xl font-bold {{ $c['value'] }} leading-none">{{ $value }}</span>
            @if ($caption)
                <span class="text-xs text-neutral-400 leading-snug">{{ $caption }}</span>
            @endif
        </div>

        @if ($badge)
            <span class="text-xs font-medium px-2.5 py-1 rounded-full whitespace-nowrap {{ $c['badge'] }}">
                {{ $badge }}
            </span>
        @endif
    </div>

    <div class="absolute top-0 left-0 right-0 h-0.5 {{ $c['accent'] }}"></div>

</div>