@php
    $transaksis ??= [];
@endphp

<div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200 flex flex-col">

    <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

    <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-neutral-100">
        <div class="flex items-center gap-3">
            <div class="shrink-0 w-9 h-9 rounded-xl bg-primary-50 text-primary-700 flex items-center justify-center">
                <x-icons.transaksi class="w-4.5 h-4.5"/>
            </div>
            <div>
                <h2 class="text-sm font-medium text-neutral-500 leading-tight">Transaksi Terbaru</h2>
                <p class="text-xs text-neutral-400 mt-0.5">{{ count($transaksis) }} transaksi ditampilkan</p>
            </div>
        </div>
        {{-- <a href="{{ route('admin.transaksi') }}"
           class="text-xs font-medium px-3 py-1.5 rounded-lg border border-neutral-200 text-neutral-500 hover:bg-neutral-50 hover:text-neutral-700 transition-colors whitespace-nowrap">
            Lihat semua
        </a> --}}
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-neutral-100 bg-neutral-50">
                    <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">ID</th>
                    <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Member</th>
                    <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Buku diserahkan</th>
                    <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Buku diterima</th>
                    <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Tanggal</th>
                    <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-50">
                @forelse ($transaksis as $t)
                    @php
                        $statusMap = [
                            'disetujui' => ['label' => 'Selesai',  'class' => 'bg-success-50 text-success-700'],
                            'ditolak'   => ['label' => 'Ditolak',  'class' => 'bg-danger-50 text-danger-700'],
                            'pending'   => ['label' => 'Pending',  'class' => 'bg-warning-50 text-warning-700'],
                        ];
                        $status = $statusMap[$t->status->value] ?? $statusMap['pending'];
                    @endphp
                    <tr class="hover:bg-neutral-50 transition-colors">
                        <td class="px-5 py-3.5 text-xs font-mono font-medium text-neutral-500 whitespace-nowrap">
                            #TXN-{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-5 py-3.5 text-sm font-medium text-neutral-700 whitespace-nowrap">
                            {{ $t->member?->nama ?? '-' }}
                        </td>
                        <td class="px-5 py-3.5 text-sm text-neutral-600 max-w-[180px] truncate">
                            {{ $t->bukuTukar?->judul ?? '-' }}
                        </td>
                        <td class="px-5 py-3.5 text-sm text-neutral-600 max-w-[180px] truncate">
                            {{ $t->bukuPerpus?->judul ?? '-' }}
                        </td>
                        <td class="px-5 py-3.5 text-xs text-neutral-400 whitespace-nowrap">
                            {{ $t->created_at->format('d/m/y') }}
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $status['class'] }}">
                                {{ $status['label'] }}
                            </span>
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
                                <p class="text-xs text-neutral-400">Transaksi terbaru akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if (count($transaksis) > 0)
        <div class="px-5 py-3 bg-neutral-50 border-t border-neutral-100">
            <p class="text-[0.7rem] text-neutral-400">
                Menampilkan {{ count($transaksis) }} transaksi terbaru.
            </p>
        </div>
    @endif

</div>