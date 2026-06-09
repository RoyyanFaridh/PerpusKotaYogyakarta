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

    {{-- Header --}}
    <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-neutral-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-700 flex items-center justify-center shrink-0">
                <x-dynamic-component :component="'icons.' . $icon" class="w-5 h-5"/>
            </div>
            <div class="flex flex-col justify-center">
                <p class="text-base font-semibold text-neutral-700 leading-tight">{{ $title }}</p>
                @if ($subtitle)
                    <p class="text-xs text-neutral-500 leading-tight mt-0.5">{{ $subtitle }}</p>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-2">
            @if ($exportRoute)
                <a href="{{ $exportRoute }}"
                   title="Export Excel"
                   class="flex items-center gap-2 text-sm font-medium px-2.5 py-2.5 sm:px-4 rounded-lg border border-neutral-200 text-neutral-600 hover:bg-neutral-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    <span class="hidden sm:inline">Export Excel</span>
                </a>
            @endif

            @if ($route)
                <a href="{{ route($route) }}"
                   title="{{ $routeLabel }}"
                   class="flex items-center gap-2 text-sm font-medium px-2.5 py-2.5 sm:px-4 rounded-lg bg-primary text-white hover:bg-primary-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    <span class="hidden sm:inline">{{ $routeLabel }}</span>
                </a>
            @elseif ($buttonOnclick)
                <button type="button"
                        onclick="{{ $buttonOnclick }}"
                        title="{{ $routeLabel }}"
                        class="flex items-center gap-2 text-sm font-medium px-2.5 py-2.5 sm:px-4 rounded-lg bg-primary text-white hover:bg-primary-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    <span class="hidden sm:inline">{{ $routeLabel }}</span>
                </button>
            @endif
        </div>
    </div>

    {{-- Stats --}}
    @if (!empty($stats))
        @php
            $count = count($stats);
            $smCols = ['sm:grid-cols-1', 'sm:grid-cols-2', 'sm:grid-cols-3', 'sm:grid-cols-4'];
            $smClass = $smCols[min($count, 4) - 1] ?? 'sm:grid-cols-4';
            $baseCols = $count >= 3 ? 'grid-cols-2' : 'grid-cols-' . $count;
        @endphp
        <div class="grid {{ $baseCols }} {{ $smClass }} border-b border-neutral-100">
            @foreach ($stats as $index => $stat)
                <div class="px-5 py-4 flex flex-col gap-1
                    {{ $index > 0 ? 'border-l border-neutral-100' : '' }}
                    {{ ($index >= 2 && $count > 2) ? 'border-t border-neutral-100 sm:border-t-0' : '' }}">
                    <span class="text-2xl font-semibold {{ $stat['color'] ?? 'text-neutral-800' }} leading-none tabular-nums">
                        {{ $stat['value'] }}
                    </span>
                    <span class="text-xs text-neutral-500">{{ $stat['label'] }}</span>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Search & Filters --}}
    <form method="GET" action="" class="px-5 py-4 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <label for="{{ $searchId }}" class="sr-only">{{ $placeholder }}</label>
            <input type="text"
                   id="{{ $searchId }}"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="{{ $placeholder }}"
                   class="w-full pl-10 pr-4 py-2.5 text-sm rounded-lg border border-neutral-200 text-neutral-700 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
        </div>

        @foreach ($filters as $filter)
            <div class="flex flex-col">
                <label for="{{ $filter['id'] ?? $filter['name'] }}" class="sr-only">
                    {{ $filter['placeholder'] ?? $filter['name'] }}
                </label>
                <select name="{{ $filter['name'] }}"
                        id="{{ $filter['id'] ?? $filter['name'] }}"
                        {{ isset($filter['onchange']) ? 'onchange=this.closest(\'form\').submit()' : '' }}
                        class="text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-600 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition bg-white h-full">
                    <option value="">{{ $filter['placeholder'] ?? 'Semua' }}</option>
                    @foreach ($filter['options'] as $option)
                        <option value="{{ $option['value'] }}"
                            {{ request($filter['name']) === (string)$option['value'] ? 'selected' : '' }}>
                            {{ $option['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endforeach
    </form>
</div>