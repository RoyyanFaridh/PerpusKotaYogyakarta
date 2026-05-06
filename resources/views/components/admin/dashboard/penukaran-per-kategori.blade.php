@php
    $kategoris = $kategoris ?? [
        ['nama' => 'Novel',      'jumlah' => 84,  'warna' => 'primary'],
        ['nama' => 'Sains',      'jumlah' => 57,  'warna' => 'success'],
        ['nama' => 'Sejarah',    'jumlah' => 43,  'warna' => 'warning'],
        ['nama' => 'Teknologi',  'jumlah' => 38,  'warna' => 'danger'],
        ['nama' => 'Anak-anak',  'jumlah' => 29,  'warna' => 'primary'],
        ['nama' => 'Lainnya',    'jumlah' => 17,  'warna' => 'neutral'],
    ];

    $total = collect($kategoris)->sum('jumlah');

    $colorMap = [
        'primary' => ['bar' => 'bg-primary-400', 'badge' => 'bg-primary-50 text-primary-700', 'dot' => 'bg-primary-400'],
        'success' => ['bar' => 'bg-success-500', 'badge' => 'bg-success-50 text-success-700', 'dot' => 'bg-success-500'],
        'warning' => ['bar' => 'bg-warning-400', 'badge' => 'bg-warning-50 text-warning-700', 'dot' => 'bg-warning-400'],
        'danger'  => ['bar' => 'bg-danger-400',  'badge' => 'bg-danger-50 text-danger-700',   'dot' => 'bg-danger-400'],
        'neutral' => ['bar' => 'bg-neutral-300', 'badge' => 'bg-neutral-100 text-neutral-500', 'dot' => 'bg-neutral-300'],
    ];
@endphp

<div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">

    <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

    <div class="flex items-center justify-between px-4 pt-4 pb-3 border-b border-neutral-100">
        <div class="flex items-center gap-2.5">
            <div class="shrink-0 w-8 h-8 rounded-lg bg-primary-50 text-primary-700 flex items-center justify-center">
                <x-icons.book-up class="w-4 h-4"/>
            </div>
            <div>
                <h2 class="text-xs font-medium text-neutral-500 leading-tight">Penukaran per Kategori</h2>
                <p class="text-[0.68rem] text-neutral-400 mt-0.5">Total <span class="font-semibold text-neutral-600">{{ number_format($total) }}</span> penukaran bulan ini</p>
            </div>
        </div>
        <button class="p-1 rounded-md text-neutral-300 hover:text-neutral-500 hover:bg-neutral-100 transition-colors">
            <x-icons.ellipsis/>
        </button>
    </div>

    <ul class="divide-y divide-neutral-50 px-4">
        @foreach ($kategoris as $item)
            @php
                $persen = $total > 0 ? round(($item['jumlah'] / $total) * 100) : 0;
                $colors = $colorMap[$item['warna']] ?? $colorMap['neutral'];
            @endphp
            <li class="py-2.5 flex flex-col gap-1.5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ $colors['dot'] }}"></span>
                        <span class="text-xs font-medium text-neutral-700">{{ $item['nama'] }}</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-xs font-bold text-neutral-800">{{ number_format($item['jumlah']) }}</span>
                        <span class="text-[0.65rem] font-medium px-1.5 py-0.5 rounded-full {{ $colors['badge'] }}">
                            {{ $persen }}%
                        </span>
                    </div>
                </div>
                <div class="w-full h-1 bg-neutral-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-700 {{ $colors['bar'] }}"
                         style="width: {{ $persen }}%"></div>
                </div>
            </li>
        @endforeach
    </ul>

    <div class="px-4 py-2.5 bg-neutral-50 border-t border-neutral-100">
        <p class="text-[0.65rem] text-neutral-400">
            Data dihitung dari seluruh transaksi tukar yang berhasil dikonfirmasi.
        </p>
    </div>

</div>