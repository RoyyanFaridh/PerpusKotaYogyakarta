@props([
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
])

<div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
    <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

    <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-neutral-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-700 flex items-center justify-center shrink-0">
                @if ($icon === 'book')
                    <x-icons.book class="w-5 h-5"/>
                @elseif ($icon === 'transaksi')
                    <x-icons.transaksi class="w-5 h-5"/>
                @elseif ($icon === 'user')
                    <x-icons.user class="w-5 h-5"/>
                @elseif ($icon === 'location')
                    <x-icons.location class="w-5 h-5"/>
                @else
                    <x-icons.book class="w-5 h-5"/>
                @endif
            </div>
            <div>
                <p class="text-base font-medium text-neutral-700">{{ $title }}</p>
                @if ($subtitle)
                    <p class="text-sm text-neutral-400">{{ $subtitle }}</p>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-2">
            @if ($exportRoute)
                <a href="{{ $exportRoute }}"
                   class="flex items-center gap-1.5 text-sm font-medium px-4 py-2 rounded-lg border border-neutral-200 text-neutral-600 hover:bg-neutral-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    Export Excel
                </a>
            @endif

            @if ($route)
                <a href="{{ route($route) }}"
                   class="flex items-center gap-2 text-sm font-medium px-4 py-2 rounded-lg bg-primary text-white hover:bg-primary-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    {{ $routeLabel }}
                </a>
            @elseif ($buttonOnclick)
                <button type="button" onclick="{{ $buttonOnclick }}"
                        class="flex items-center gap-2 text-sm font-medium px-4 py-2 rounded-lg bg-primary text-white hover:bg-primary-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    {{ $routeLabel }}
                </button>
            @endif
        </div>
    </div>

    @if (!empty($stats))
        @php
            $cols = [1 => 'grid-cols-1', 2 => 'grid-cols-2', 3 => 'grid-cols-3', 4 => 'grid-cols-4'];
            $colClass = $cols[count($stats)] ?? 'grid-cols-4';
        @endphp
        <div class="grid {{ $colClass }} divide-x divide-neutral-100 border-b border-neutral-100">
            @foreach ($stats as $stat)
                <div class="px-5 py-4 flex flex-col gap-0.5">
                    <span class="text-2xl font-bold {{ $stat['color'] ?? 'text-neutral-800' }} leading-none">{{ $stat['value'] }}</span>
                    <span class="text-xs text-neutral-400">{{ $stat['label'] }}</span>
                </div>
            @endforeach
        </div>
    @endif

    <div class="px-5 py-4 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="{{ $searchId }}" placeholder="{{ $placeholder }}"
                class="w-full pl-10 pr-4 py-2.5 text-sm rounded-lg border border-neutral-200 text-neutral-700 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
        </div>
        @foreach ($filters as $filter)
            <select name="{{ $filter['name'] }}" id="{{ $filter['id'] ?? $filter['name'] }}"
                {{ isset($filter['onchange']) ? 'onchange=this.form.submit()' : '' }}
                class="text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-600 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition bg-white">
                <option value="">{{ $filter['placeholder'] ?? 'Semua' }}</option>
                @foreach ($filter['options'] as $option)
                    <option value="{{ $option['value'] }}" {{ request($filter['name']) === $option['value'] ? 'selected' : '' }}>
                        {{ $option['label'] }}
                    </option>
                @endforeach
            </select>
        @endforeach
    </div>
</div>