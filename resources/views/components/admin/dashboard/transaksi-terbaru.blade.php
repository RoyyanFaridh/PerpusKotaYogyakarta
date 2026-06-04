@php
    $transaksis ??= [];

    $statusConfig = [
        'pending'   => ['bg' => 'bg-warning-50', 'text' => 'text-warning-700', 'label' => 'Pending'],
        'disetujui' => ['bg' => 'bg-success-50', 'text' => 'text-success-700', 'label' => 'Disetujui'],
        'ditolak'   => ['bg' => 'bg-danger-50',  'text' => 'text-danger-700',  'label' => 'Ditolak'],
    ];
@endphp

<div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200 flex flex-col">

    <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

    {{-- Header --}}
    <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-neutral-100">
        <div class="flex items-center gap-3">
            <div class="shrink-0 w-10 h-10 rounded-xl bg-primary-50 text-primary-700 flex items-center justify-center">
                <x-icons.transaksi class="w-5 h-5"/>
            </div>
            <div class="flex flex-col justify-center">
                <h2 class="text-sm font-semibold text-neutral-700 leading-tight">Transaksi Terbaru</h2>
                <p class="text-xs text-neutral-500 mt-0.5">{{ count($transaksis) }} transaksi ditampilkan</p>
            </div>
        </div>
        <a href="{{ route('admin.transaksi.index') }}"
           class="text-xs font-medium px-3 py-1.5 rounded-lg border border-neutral-200 text-neutral-500 hover:bg-neutral-50 hover:text-neutral-700 transition-colors whitespace-nowrap">
            Lihat semua
        </a>
    </div>

    <div class="overflow-x-auto custom-scroll">
        <table class="w-full text-sm">
            <thead class="sticky top-0 z-10">
                <tr class="border-b border-neutral-100 bg-neutral-50">
                    <th class="text-left text-xs font-medium text-neutral-500 px-5 py-3 whitespace-nowrap">ID</th>
                    <th class="text-left text-xs font-medium text-neutral-500 px-5 py-3 whitespace-nowrap">Member</th>
                    <th class="text-left text-xs font-medium text-neutral-500 px-5 py-3 whitespace-nowrap">Diserahkan</th>
                    <th class="text-left text-xs font-medium text-neutral-500 px-5 py-3 whitespace-nowrap">Diterima</th>
                    <th class="text-left text-xs font-medium text-neutral-500 px-5 py-3 whitespace-nowrap">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100">
                @forelse ($transaksis as $t)
                    @php
                        $status = $t->status ?? 'pending';
                        $sCfg = $statusConfig[$status] ?? $statusConfig['pending'];
                    @endphp
                    <tr class="hover:bg-neutral-50 transition-colors">

                        {{-- ID --}}
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            <span class="text-xs font-mono font-medium text-neutral-500 tabular-nums">
                                #{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>

                        {{-- Member --}}
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-primary flex items-center justify-center text-white text-xs font-semibold shrink-0 select-none">
                                    {{ strtoupper(substr($t->member?->nama ?? 'U', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-neutral-800 leading-tight truncate">{{ $t->member?->nama ?? '-' }}</p>
                                    <p class="text-xs text-neutral-500 leading-tight">{{ $t->member?->no_telp ?? '' }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Diserahkan --}}
                        <td class="px-5 py-3.5 min-w-0 max-w-40">
                            <p class="text-xs font-medium text-neutral-700 truncate">{{ $t->bukuDiserahkan?->buku?->judul ?? '-' }}</p>
                            <p class="text-xs text-neutral-500 mt-0.5 truncate">{{ $t->bukuDiserahkan?->buku?->pengarang ?? '' }}</p>
                        </td>

                        {{-- Diterima --}}
                        <td class="px-5 py-3.5 min-w-0 max-w-40">
                            <p class="text-xs font-medium text-neutral-700 truncate">{{ $t->bukuDiterima?->buku?->judul ?? '-' }}</p>
                            <p class="text-xs text-neutral-500 mt-0.5 truncate">{{ $t->bukuDiterima?->buku?->pengarang ?? '' }}</p>
                        </td>

                        {{-- Tanggal --}}
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            <p class="text-xs font-medium text-neutral-700 tabular-nums">
                                {{ $t->tanggal_tukar?->format('d M Y') ?? '-' }}
                            </p>
                            <p class="text-xs text-neutral-500 mt-0.5">
                                {{ $t->tanggal_tukar?->diffForHumans() ?? '' }}
                            </p>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <div class="w-10 h-10 rounded-xl bg-neutral-100 flex items-center justify-center">
                                    <x-icons.transaksi class="w-5 h-5 text-neutral-400"/>
                                </div>
                                <p class="text-sm font-medium text-neutral-500">Belum ada transaksi</p>
                                <p class="text-xs text-neutral-500">Transaksi terbaru akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if (count($transaksis) > 0)
        <div class="px-5 py-3 bg-neutral-50 border-t border-neutral-100">
            <p class="text-xs text-neutral-500">
                Menampilkan {{ count($transaksis) }} transaksi terbaru.
            </p>
        </div>
    @endif

</div>