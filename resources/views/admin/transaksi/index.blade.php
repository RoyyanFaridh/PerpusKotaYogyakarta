{{-- resources/views/admin/transaksi.blade.php --}}
@extends('layouts.admin')

@section('title', 'Transaksi')

@section('content')
<div class="min-h-screen px-6 py-8">

    {{-- ── Header ── --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-[0.70rem] font-semibold tracking-[0.22em] uppercase text-primary-500 mb-1 flex items-center gap-2">
                <span class="block w-5 h-px bg-primary-400 rounded"></span>
                Manajemen
            </p>
            <h1 class="font-extrabold text-primary-900 text-[1.8rem] leading-tight">
                Data <span class="text-primary">Transaksi</span>
            </h1>
        </div>

        {{-- Search & Filter --}}
        <div class="flex items-center gap-3 flex-wrap">
            {{-- Search --}}
            <div class="relative flex items-center bg-white border border-primary-100 rounded-lg shadow-sm overflow-hidden focus-within:border-primary focus-within:shadow-md transition-all duration-200">
                <span class="pl-3 pr-2 text-neutral-400">
                    <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35" stroke-linecap="round"/>
                    </svg>
                </span>
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari member, buku…"
                    class="border-none outline-none text-[0.85rem] text-primary-900 bg-transparent py-2 pr-3 w-48 placeholder-neutral-400"
                >
            </div>

            {{-- Filter Status --}}
            <select
                id="filterStatus"
                class="border border-primary-100 bg-white text-[0.85rem] text-primary-900 rounded-lg px-3 py-2 outline-none shadow-sm cursor-pointer focus:border-primary transition-all duration-200"
            >
                <option value="">Semua Status</option>
                <option value="menunggu">Menunggu</option>
                <option value="diproses">Diproses</option>
                <option value="selesai">Selesai</option>
                <option value="ditolak">Ditolak</option>
            </select>

            {{-- Tambah Transaksi --}}
            <a href="{{ route('admin.transaksi.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white text-[0.85rem] font-semibold rounded-lg shadow-md hover:bg-primary-700 hover:-translate-y-px hover:shadow-lg transition-all duration-200 whitespace-nowrap">
                <svg class="w-4 h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2.5">
                    <path d="M12 5v14M5 12h14" stroke-linecap="round"/>
                </svg>
                Tambah
            </a>
        </div>
    </div>

    {{-- ── Stats Mini ── --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        @php
            $stats = [
                ['label' => 'Total',     'value' => $transaksi->total() ?? 0,                                              'color' => 'text-primary'],
                ['label' => 'Menunggu',  'value' => $transaksi->where('status','menunggu')->count()  ?? 0,                 'color' => 'text-amber-500'],
                ['label' => 'Diproses',  'value' => $transaksi->where('status','diproses')->count()  ?? 0,                 'color' => 'text-blue-500'],
                ['label' => 'Selesai',   'value' => $transaksi->where('status','selesai')->count()   ?? 0,                 'color' => 'text-emerald-500'],
            ];
        @endphp
        @foreach ($stats as $s)
            <div class="bg-white rounded-xl border border-primary-100 px-5 py-4 shadow-sm">
                <div class="font-extrabold text-[1.7rem] {{ $s['color'] }}">{{ $s['value'] }}</div>
                <div class="text-[0.72rem] font-medium tracking-widest uppercase text-neutral-400 mt-0.5">{{ $s['label'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- ── Tabel ── --}}
    <div class="bg-white rounded-2xl border border-primary-100 shadow-sm overflow-hidden">

        {{-- Flash message --}}
        @if (session('success'))
            <div class="flex items-center gap-3 px-6 py-3 bg-emerald-50 border-b border-emerald-100 text-emerald-700 text-sm font-medium">
                <svg class="w-4 h-4 shrink-0 fill-emerald-500" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="transaksiTable">
                <thead>
                    <tr class="border-b border-primary-100 bg-primary-50/60">
                        <th class="px-5 py-3.5 text-left text-[0.70rem] font-semibold tracking-[0.12em] uppercase text-primary-400 whitespace-nowrap">#</th>
                        <th class="px-5 py-3.5 text-left text-[0.70rem] font-semibold tracking-[0.12em] uppercase text-primary-400 whitespace-nowrap">ID</th>
                        <th class="px-5 py-3.5 text-left text-[0.70rem] font-semibold tracking-[0.12em] uppercase text-primary-400 whitespace-nowrap">Member</th>
                        <th class="px-5 py-3.5 text-left text-[0.70rem] font-semibold tracking-[0.12em] uppercase text-primary-400 whitespace-nowrap">Buku Diserahkan</th>
                        <th class="px-5 py-3.5 text-left text-[0.70rem] font-semibold tracking-[0.12em] uppercase text-primary-400 whitespace-nowrap">Buku Diterima</th>
                        <th class="px-5 py-3.5 text-left text-[0.70rem] font-semibold tracking-[0.12em] uppercase text-primary-400 whitespace-nowrap">Tanggal</th>
                        <th class="px-5 py-3.5 text-left text-[0.70rem] font-semibold tracking-[0.12em] uppercase text-primary-400 whitespace-nowrap">Status</th>
                        <th class="px-5 py-3.5 text-center text-[0.70rem] font-semibold tracking-[0.12em] uppercase text-primary-400 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-primary-50" id="tableBody">
                    @forelse ($transaksi as $index => $item)
                        @php
                            $statusMap = [
                                'menunggu' => ['label' => 'Menunggu',  'class' => 'bg-amber-50 text-amber-600 border-amber-200'],
                                'diproses' => ['label' => 'Diproses',  'class' => 'bg-blue-50 text-blue-600 border-blue-200'],
                                'selesai'  => ['label' => 'Selesai',   'class' => 'bg-emerald-50 text-emerald-600 border-emerald-200'],
                                'ditolak'  => ['label' => 'Ditolak',   'class' => 'bg-red-50 text-red-500 border-red-200'],
                            ];
                            $s = $statusMap[$item->status] ?? ['label' => $item->status, 'class' => 'bg-neutral-100 text-neutral-500 border-neutral-200'];
                        @endphp
                        <tr class="hover:bg-primary-50/40 transition-colors duration-150 group table-row-data"
                            data-status="{{ $item->status }}"
                            data-search="{{ strtolower($item->member->nama ?? '') }} {{ strtolower($item->bukuTukar->judul ?? '') }} {{ strtolower($item->bukuPerpus->judul ?? '') }}">

                            {{-- No --}}
                            <td class="px-5 py-4 text-neutral-400 text-[0.80rem]">
                                {{ $transaksi->firstItem() + $index }}
                            </td>

                            {{-- ID --}}
                            <td class="px-5 py-4">
                                <span class="font-mono text-[0.78rem] font-semibold text-primary-400 bg-primary-50 px-2 py-0.5 rounded">
                                    #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>

                            {{-- Member --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-primary flex items-center justify-center text-white text-[0.65rem] font-bold shrink-0">
                                        {{ strtoupper(substr($item->member->nama ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-primary-900 text-[0.85rem] leading-tight">
                                            {{ $item->member->nama ?? '-' }}
                                        </div>
                                        <div class="text-[0.72rem] text-neutral-400">
                                            {{ $item->member->email ?? '' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Buku Diserahkan --}}
                            <td class="px-5 py-4 max-w-[180px]">
                                <div class="font-medium text-primary-800 text-[0.83rem] leading-snug line-clamp-2">
                                    {{ $item->bukuTukar->judul ?? '-' }}
                                </div>
                                @if ($item->bukuTukar->penulis ?? false)
                                    <div class="text-[0.70rem] text-neutral-400 mt-0.5">{{ $item->bukuTukar->penulis }}</div>
                                @endif
                            </td>

                            {{-- Buku Diterima --}}
                            <td class="px-5 py-4 max-w-[180px]">
                                <div class="font-medium text-primary-800 text-[0.83rem] leading-snug line-clamp-2">
                                    {{ $item->bukuPerpus->judul ?? '-' }}
                                </div>
                                @if ($item->bukuPerpus->penulis ?? false)
                                    <div class="text-[0.70rem] text-neutral-400 mt-0.5">{{ $item->bukuPerpus->penulis }}</div>
                                @endif
                            </td>

                            {{-- Tanggal --}}
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="text-[0.83rem] font-medium text-primary-800">
                                    {{ \Carbon\Carbon::parse($item->tanggal_tukar)->format('d M Y') }}
                                </div>
                                <div class="text-[0.70rem] text-neutral-400 mt-0.5">
                                    {{ \Carbon\Carbon::parse($item->tanggal_tukar)->diffForHumans() }}
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[0.70rem] font-semibold border {{ $s['class'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full
                                        {{ $item->status === 'menunggu' ? 'bg-amber-400 animate-pulse' : '' }}
                                        {{ $item->status === 'diproses' ? 'bg-blue-400 animate-pulse' : '' }}
                                        {{ $item->status === 'selesai'  ? 'bg-emerald-400' : '' }}
                                        {{ $item->status === 'ditolak'  ? 'bg-red-400' : '' }}
                                    "></span>
                                    {{ $s['label'] }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Detail --}}
                                    <a href="{{ route('admin.transaksi.show', $item->id) }}"
                                       title="Detail"
                                       class="w-7 h-7 rounded-lg bg-primary-50 border border-primary-100 flex items-center justify-center text-primary hover:bg-primary hover:text-white hover:border-primary transition-all duration-200">
                                        <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.transaksi.edit', $item->id) }}"
                                       title="Edit"
                                       class="w-7 h-7 rounded-lg bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-500 hover:bg-amber-500 hover:text-white hover:border-amber-500 transition-all duration-200">
                                        <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('admin.transaksi.destroy', $item->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus transaksi #{{ str_pad($item->id,4,'0',STR_PAD_LEFT) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                title="Hapus"
                                                class="w-7 h-7 rounded-lg bg-red-50 border border-red-100 flex items-center justify-center text-red-400 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-200">
                                            <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6l-1 14H6L5 6"/>
                                                <path d="M10 11v6M14 11v6"/>
                                                <path d="M9 6V4h6v2"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyRow">
                            <td colspan="8" class="px-5 py-16 text-center">
                                <div class="flex flex-col items-center gap-3 text-neutral-400">
                                    <svg class="w-10 h-10 stroke-current fill-none opacity-40" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path d="M9 17H7A5 5 0 017 7h2M15 7h2a5 5 0 010 10h-2M8 12h8"/>
                                    </svg>
                                    <p class="text-sm font-medium">Belum ada transaksi</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    {{-- Empty state saat filter/search kosong --}}
                    <tr id="noResultRow" class="hidden">
                        <td colspan="8" class="px-5 py-12 text-center text-neutral-400 text-sm">
                            Tidak ada hasil yang cocok.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($transaksi->hasPages())
            <div class="px-6 py-4 border-t border-primary-100 flex items-center justify-between gap-4 flex-wrap">
                <p class="text-[0.78rem] text-neutral-400">
                    Menampilkan <span class="font-semibold text-primary-700">{{ $transaksi->firstItem() }}</span>–<span class="font-semibold text-primary-700">{{ $transaksi->lastItem() }}</span>
                    dari <span class="font-semibold text-primary-700">{{ $transaksi->total() }}</span> transaksi
                </p>
                <div class="flex items-center gap-1">
                    {{-- Prev --}}
                    @if ($transaksi->onFirstPage())
                        <span class="px-3 py-1.5 rounded-lg text-[0.78rem] text-neutral-300 border border-neutral-100 cursor-not-allowed">← Prev</span>
                    @else
                        <a href="{{ $transaksi->previousPageUrl() }}"
                           class="px-3 py-1.5 rounded-lg text-[0.78rem] text-primary border border-primary-100 hover:bg-primary hover:text-white hover:border-primary transition-all duration-200">← Prev</a>
                    @endif

                    {{-- Page numbers --}}
                    @foreach ($transaksi->getUrlRange(1, $transaksi->lastPage()) as $page => $url)
                        @if ($page == $transaksi->currentPage())
                            <span class="px-3 py-1.5 rounded-lg text-[0.78rem] bg-primary text-white font-semibold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                               class="px-3 py-1.5 rounded-lg text-[0.78rem] text-primary border border-primary-100 hover:bg-primary-50 transition-all duration-200">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($transaksi->hasMorePages())
                        <a href="{{ $transaksi->nextPageUrl() }}"
                           class="px-3 py-1.5 rounded-lg text-[0.78rem] text-primary border border-primary-100 hover:bg-primary hover:text-white hover:border-primary transition-all duration-200">Next →</a>
                    @else
                        <span class="px-3 py-1.5 rounded-lg text-[0.78rem] text-neutral-300 border border-neutral-100 cursor-not-allowed">Next →</span>
                    @endif
                </div>
            </div>
        @endif

    </div>
    {{-- /Tabel --}}

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