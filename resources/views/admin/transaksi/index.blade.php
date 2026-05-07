@extends('layouts.admin')
@section('title', 'Transaksi')
@section('page-title', 'Transaksi')
@section('page-subtitle', 'Kelola data transaksi tukar buku')

@section('content')
<div class="flex flex-col gap-4">

    {{-- Header + Stats + Search --}}
    <x-admin.page-header
        title="Semua Transaksi"
        :subtitle="$transaksi->total() . ' transaksi terdaftar'"
        icon="transaksi"
        route="admin.transaksi.create"
        route-label="Tambah"
        placeholder="Cari member, buku..."
        search-id="searchInput"
        :stats="[
            ['label' => 'Total',     'value' => $transaksi->total(),             'color' => 'text-neutral-800'],
            ['label' => 'Pending',   'value' => $allTransaksi['pending']   ?? 0, 'color' => 'text-warning-700'],
            ['label' => 'Disetujui', 'value' => $allTransaksi['disetujui'] ?? 0, 'color' => 'text-success-700'],
            ['label' => 'Ditolak',   'value' => $allTransaksi['ditolak']   ?? 0, 'color' => 'text-danger-700'],
        ]"
        :filters="[
            [
                'name'        => 'status',
                'id'          => 'filterStatus',
                'placeholder' => 'Semua Status',
                'options'     => [
                    ['value' => 'pending',   'label' => 'Pending'],
                    ['value' => 'disetujui', 'label' => 'Disetujui'],
                    ['value' => 'ditolak',   'label' => 'Ditolak'],
                ],
            ],
        ]"
    />

    {{-- Tabel --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        @if (session('success'))
            <div class="flex items-center gap-2.5 px-5 py-3 bg-success-50 border-b border-success-100 text-success-700 text-xs font-medium">
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="transaksiTable">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">ID</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Member</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Buku Diserahkan</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Buku Diterima</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Tanggal</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Status</th>
                        <th class="text-right text-xs font-medium text-neutral-400 px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50" id="tableBody">
                    @forelse ($transaksi as $index => $item)
                        @php
                            $statusMap = [
                                'disetujui' => ['label' => 'Disetujui', 'class' => 'bg-success-50 text-success-700', 'dot' => 'bg-success-400'],
                                'ditolak'   => ['label' => 'Ditolak',   'class' => 'bg-danger-50 text-danger-700',   'dot' => 'bg-danger-400'],
                                'pending'   => ['label' => 'Pending',   'class' => 'bg-warning-50 text-warning-700', 'dot' => 'bg-warning-400 animate-pulse'],
                            ];
                            $s = $statusMap[$item->status->value] ?? $statusMap['pending'];
                        @endphp
                        <tr class="hover:bg-neutral-50 transition-colors table-row-data"
                            data-status="{{ $item->status->value }}"
                            data-search="{{ strtolower($item->member->nama ?? '') }} {{ strtolower($item->bukuTukar->judul ?? '') }} {{ strtolower($item->bukuPerpus->judul ?? '') }}">

                            <td class="px-5 py-3.5">
                                <span class="text-xs font-mono font-medium text-neutral-500">
                                    #TXN-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-primary flex items-center justify-center text-white text-[0.65rem] font-bold shrink-0">
                                        {{ strtoupper(substr($item->member->nama ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-neutral-800 leading-tight">{{ $item->member->nama ?? '-' }}</p>
                                        <p class="text-[0.68rem] text-neutral-400">{{ $item->member->nik ?? '' }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-3.5 max-w-[160px]">
                                <p class="text-xs font-medium text-neutral-700 truncate">{{ $item->bukuTukar->judul ?? '-' }}</p>
                            </td>

                            <td class="px-5 py-3.5 max-w-[160px]">
                                <p class="text-xs font-medium text-neutral-700 truncate">{{ $item->bukuPerpus->judul ?? '-' }}</p>
                            </td>

                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <p class="text-xs font-medium text-neutral-700">{{ \Carbon\Carbon::parse($item->tanggal_tukar)->format('d M Y') }}</p>
                                <p class="text-[0.68rem] text-neutral-400 mt-0.5">{{ \Carbon\Carbon::parse($item->tanggal_tukar)->diffForHumans() }}</p>
                            </td>

                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center gap-1.5 text-[0.68rem] font-medium px-2 py-0.5 rounded-full {{ $s['class'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $s['dot'] }}"></span>
                                    {{ $s['label'] }}
                                </span>
                            </td>

                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.transaksi.show', $item->id) }}"
                                       class="p-1.5 rounded-lg text-neutral-400 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.transaksi.edit', $item->id) }}"
                                       class="p-1.5 rounded-lg text-neutral-400 hover:text-warning-600 hover:bg-warning-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.transaksi.destroy', $item->id) }}"
                                          onsubmit="return confirm('Hapus transaksi #{{ str_pad($item->id,4,'0',STR_PAD_LEFT) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-neutral-400 hover:text-danger-600 hover:bg-danger-50 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                                <path d="M10 11v6"/><path d="M14 11v6"/>
                                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-10 h-10 rounded-xl bg-neutral-100 flex items-center justify-center">
                                        <x-icons.transaksi class="w-5 h-5 text-neutral-400"/>
                                    </div>
                                    <p class="text-sm font-medium text-neutral-500">Belum ada transaksi</p>
                                    <p class="text-xs text-neutral-400">Transaksi akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <tr id="noResultRow" class="hidden">
                        <td colspan="7" class="px-5 py-10 text-center text-xs text-neutral-400">
                            Tidak ada hasil yang cocok.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if ($transaksi->hasPages())
            <div class="px-5 py-3 bg-neutral-50 border-t border-neutral-100 flex items-center justify-between gap-4 flex-wrap">
                <p class="text-[0.7rem] text-neutral-400">
                    Menampilkan <span class="font-semibold text-neutral-600">{{ $transaksi->firstItem() }}</span>–<span class="font-semibold text-neutral-600">{{ $transaksi->lastItem() }}</span>
                    dari <span class="font-semibold text-neutral-600">{{ $transaksi->total() }}</span> transaksi
                </p>
                <div class="flex items-center gap-1">
                    @if ($transaksi->onFirstPage())
                        <span class="px-3 py-1.5 rounded-lg text-[0.75rem] text-neutral-300 border border-neutral-100 cursor-not-allowed">← Prev</span>
                    @else
                        <a href="{{ $transaksi->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-[0.75rem] text-primary-600 border border-neutral-200 hover:bg-primary-50 transition-colors">← Prev</a>
                    @endif

                    @foreach ($transaksi->getUrlRange(1, $transaksi->lastPage()) as $page => $url)
                        @if ($page == $transaksi->currentPage())
                            <span class="px-3 py-1.5 rounded-lg text-[0.75rem] bg-primary text-white font-semibold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-1.5 rounded-lg text-[0.75rem] text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($transaksi->hasMorePages())
                        <a href="{{ $transaksi->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-[0.75rem] text-primary-600 border border-neutral-200 hover:bg-primary-50 transition-colors">Next →</a>
                    @else
                        <span class="px-3 py-1.5 rounded-lg text-[0.75rem] text-neutral-300 border border-neutral-100 cursor-not-allowed">Next →</span>
                    @endif
                </div>
            </div>
        @endif
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput  = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const rows         = document.querySelectorAll('.table-row-data');
    const noResultRow  = document.getElementById('noResultRow');

    const filterTable = () => {
        const query  = searchInput.value.toLowerCase().trim();
        const status = filterStatus.value.toLowerCase();
        let visible  = 0;

        rows.forEach(row => {
            const matchSearch = !query  || row.dataset.search.includes(query);
            const matchStatus = !status || row.dataset.status === status;
            const show        = matchSearch && matchStatus;
            row.classList.toggle('hidden', !show);
            if (show) visible++;
        });

        noResultRow.classList.toggle('hidden', visible > 0);
    };

    searchInput.addEventListener('input', filterTable);
    filterStatus.addEventListener('change', filterTable);
});
</script>
@endsection