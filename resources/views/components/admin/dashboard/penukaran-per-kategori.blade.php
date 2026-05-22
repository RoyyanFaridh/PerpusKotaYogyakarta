@php
    $kategoris = $kategoris ?? [
        ['nama' => 'Umum/Komputer',        'jumlah' => 84,  'warna' => 'indigo'],
        ['nama' => 'Filsafat & Psikologi', 'jumlah' => 57,  'warna' => 'violet'],
        ['nama' => 'Agama',                'jumlah' => 43,  'warna' => 'rose'],
        ['nama' => 'Ilmu Sosial',          'jumlah' => 38,  'warna' => 'amber'],
        ['nama' => 'Bahasa',               'jumlah' => 29,  'warna' => 'teal'],
        ['nama' => 'Sains & Matematika',   'jumlah' => 17,  'warna' => 'success'],
        ['nama' => 'Teknologi',            'jumlah' => 12,  'warna' => 'danger'],
        ['nama' => 'Seni & Rekreasi',      'jumlah' => 9,   'warna' => 'primary'],
        ['nama' => 'Literatur & Sastra',   'jumlah' => 7,   'warna' => 'neutral'],
        ['nama' => 'Geografi & Sejarah',   'jumlah' => 5,   'warna' => 'sky'],
    ];

    $total = collect($kategoris)->sum('jumlah');

    $colorMap = [
        'indigo' => ['bar' => 'bg-indigo-400', 'badge' => 'bg-indigo-50 text-indigo-700',   'dot' => 'bg-indigo-400'],
        'violet' => ['bar' => 'bg-violet-400', 'badge' => 'bg-violet-50 text-violet-700',   'dot' => 'bg-violet-400'],
        'rose'   => ['bar' => 'bg-rose-400',   'badge' => 'bg-rose-50 text-rose-700',       'dot' => 'bg-rose-400'],
        'amber'  => ['bar' => 'bg-amber-400',  'badge' => 'bg-amber-50 text-amber-700',     'dot' => 'bg-amber-400'],
        'teal'   => ['bar' => 'bg-teal-400',   'badge' => 'bg-teal-50 text-teal-700',       'dot' => 'bg-teal-400'],
        'sky'    => ['bar' => 'bg-sky-400',    'badge' => 'bg-sky-100 text-sky-500',        'dot' => 'bg-sky-400'],
        'success'=> ['bar' => 'bg-success-400','badge' => 'bg-success-50 text-success-700', 'dot' => 'bg-success-400'],
        'danger' => ['bar' => 'bg-danger-400', 'badge' => 'bg-danger-50 text-danger-700',   'dot' => 'bg-danger-400'],
        'primary'=> ['bar' => 'bg-primary-400','badge' => 'bg-primary-50 text-primary-700', 'dot' => 'bg-primary-400'],
        'neutral'=> ['bar' => 'bg-neutral-400','badge' => 'bg-neutral-100 text-neutral-600','dot' => 'bg-neutral-400'],
    ];

    $colorDefault = ['bar' => 'bg-neutral-300', 'badge' => 'bg-neutral-100 text-neutral-500', 'dot' => 'bg-neutral-300'];
@endphp

<div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">

    <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

    <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-neutral-100">
        <div class="flex items-center gap-3">
            <div class="shrink-0 w-9 h-9 rounded-lg bg-primary-50 text-primary-700 flex items-center justify-center">
                <x-icons.book-up class="w-4.5 h-4.5"/>
            </div>
            <div>
                <h2 class="text-sm font-medium text-neutral-500 leading-tight">Penukaran per Kategori</h2>
                <p class="text-xs text-neutral-400 mt-0.5">
                    Total <span class="font-semibold text-neutral-600">{{ number_format($total) }}</span> penukaran bulan ini
                </p>
            </div>
        </div>
        <button class="p-1.5 rounded-md text-neutral-300 hover:text-neutral-500 hover:bg-neutral-100 transition-colors">
            <x-icons.ellipsis/>
        </button>
    </div>

    <ul class="divide-y divide-neutral-50 px-5">
        @foreach ($kategoris as $item)
            @php
                $persen = $total > 0 ? round(($item['jumlah'] / $total) * 100) : 0;
                $colors = $colorMap[$item['warna']] ?? $colorDefault;
            @endphp
            <li class="py-3 flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full shrink-0 {{ $colors['dot'] }}"></span>
                        <span class="text-sm font-medium text-neutral-700">{{ $item['nama'] }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-bold text-neutral-800">{{ number_format($item['jumlah']) }}</span>
                        <span class="text-xs font-medium px-1.5 py-0.5 rounded-full {{ $colors['badge'] }}">
                            {{ $persen }}%
                        </span>
                    </div>
                </div>
                <div class="w-full h-1.5 bg-neutral-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-700 {{ $colors['bar'] }}"
                         style="width: {{ $persen }}%"></div>
                </div>
            </li>
        @endforeach
    </ul>

    <div class="px-5 py-3 bg-neutral-50 border-t border-neutral-100">
        <p class="text-xs text-neutral-400">
            Data dihitung dari seluruh transaksi tukar yang berhasil dikonfirmasi.
        </p>
    </div>

</div>