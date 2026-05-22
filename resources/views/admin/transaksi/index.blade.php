@extends('layouts.admin')
@section('title', 'Transaksi')
@section('page-title', 'Transaksi')
@section('page-subtitle', 'Kelola data transaksi tukar buku')

@push('scripts')
    <script>
        window.Routes = {
            transaksiStore: "{{ route('admin.transaksi.store') }}",
        };
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}';
    </script>
    @vite('resources/js/transaksi-wizard.js')
    <script>
    (function () {
        const searchInput     = document.getElementById('searchInput');
        const selectTanggal   = document.getElementById('filterTanggal');

        function applyFilters() {
            const params = new URLSearchParams();
            const q = searchInput?.value.trim();
            if (q) params.set('search', q);
            if (selectTanggal?.value) params.set('tanggal', selectTanggal.value);
            window.location.href = `${window.location.pathname}?${params.toString()}`;
        }

        let debounce;
        searchInput?.addEventListener('input', function () {
            clearTimeout(debounce);
            debounce = setTimeout(applyFilters, 400);
        });

        selectTanggal?.addEventListener('change', applyFilters);

        const params = new URLSearchParams(window.location.search);
        if (searchInput && params.get('search'))    searchInput.value   = params.get('search');
        if (selectTanggal && params.get('tanggal')) selectTanggal.value = params.get('tanggal');
    })();
    </script>
@endpush

@section('content')
<div class="flex flex-col gap-4">

    <x-admin.page-header
        title="Semua Transaksi"
        :subtitle="$transaksi->total() . ' transaksi terdaftar'"
        icon="transaksi"
        button-onclick="openModal()"
        route-label="Tambah Transaksi"
        placeholder="Cari member, buku..."
        search-id="searchInput"
        :export-route="route('admin.transaksi.export')"
        :stats="[
            ['label' => 'Total',      'value' => $transaksi->total(), 'color' => 'text-neutral-800'],
            ['label' => 'Hari Ini',   'value' => $transaksiHariIni,  'color' => 'text-primary-700'],
            ['label' => 'Minggu Ini', 'value' => $transaksiMingguIni,'color' => 'text-success-700'],
            ['label' => 'Bulan Ini',  'value' => $transaksiBulanIni, 'color' => 'text-warning-700'],
        ]"
        :filters="[
            [
                'name'        => 'tanggal',
                'id'          => 'filterTanggal',
                'placeholder' => 'Semua Waktu',
                'options'     => [
                    ['value' => 'hari_ini',   'label' => 'Hari Ini'],
                    ['value' => 'minggu_ini', 'label' => 'Minggu Ini'],
                    ['value' => 'bulan_ini',  'label' => 'Bulan Ini'],
                ],
            ],
        ]"
    />

    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        @if (session('success'))
            <div class="flex items-center gap-2.5 px-5 py-3 bg-success-50 border-b border-success-100 text-success-700 text-sm font-medium">
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-center text-xs font-medium text-neutral-400 px-2 py-3.5">ID</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-2 py-3.5">Member</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3.5">Buku Diserahkan</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3.5">Buku Diterima</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3.5">Tanggal</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3.5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50" id="tableBody">
                    @forelse ($transaksi as $item)
                        @php
                            $txnId = '#TXN-' . str_pad($item->id, 4, '0', STR_PAD_LEFT);
                        @endphp
                        <tr class="hover:bg-neutral-50 transition-colors table-row-data"
                            data-search="{{ strtolower($item->member->nama ?? '') }} {{ strtolower($item->bukuDiserahkan->judul ?? '') }} {{ strtolower($item->bukuDiterima->judul ?? '') }}">

                            <td class="px-2 py-4 text-center">
                                <span class="text-xs font-mono font-medium text-neutral-500">
                                    {{ $txnId }}
                                </span>
                            </td>

                            <td class="px-2 py-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white text-xs font-bold shrink-0">
                                        {{ strtoupper(substr($item->member->nama ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-neutral-800 leading-tight">{{ $item->member->nama ?? '-' }}</p>
                                        <p class="text-xs text-neutral-400">{{ $item->member->no_telp ?? '' }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4 max-w-40 text-center">
                                <p class="text-sm font-medium text-neutral-700 truncate">{{ $item->bukuDiserahkan->judul ?? '-' }}</p>
                                <p class="text-xs text-neutral-400 mt-0.5">{{ $item->bukuDiserahkan->pengarang ?? '' }}</p>
                            </td>

                            <td class="px-5 py-4 max-w-40 text-center">
                                <p class="text-sm font-medium text-neutral-700 truncate">{{ $item->bukuDiterima->judul ?? '-' }}</p>
                                <p class="text-xs text-neutral-400 mt-0.5">{{ $item->bukuDiterima->pengarang ?? '' }}</p>
                            </td>

                            <td class="px-5 py-4 whitespace-nowrap text-center">
                                <p class="text-sm font-medium text-neutral-700">{{ $item->tanggal_tukar?->format('d M Y') ?? '-' }}</p>
                                <p class="text-xs text-neutral-400 mt-0.5">{{ $item->tanggal_tukar?->diffForHumans() ?? '' }}</p>
                            </td>

                            <td class="py-4">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="button"
                                            onclick="openEditTransaksi({{ $item->id }})"
                                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-warning-300 hover:text-warning-600 hover:bg-warning-50 transition-colors">
                                        <x-icons.edit/>
                                        <span>Edit</span>
                                    </button>

                                    <button type="button"
                                            onclick="bukaModalHapusTransaksi(
                                                '{{ route('admin.transaksi.destroy', $item) }}',
                                                '{{ $txnId }}'
                                            )"
                                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-danger-300 hover:text-danger-600 hover:bg-danger-50 transition-colors">
                                        <x-icons.delete/>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-14 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-11 h-11 rounded-xl bg-neutral-100 flex items-center justify-center">
                                        <x-icons.transaksi class="w-5 h-5 text-neutral-400"/>
                                    </div>
                                    <p class="text-sm font-medium text-neutral-500">Belum ada transaksi</p>
                                    <p class="text-xs text-neutral-400">Klik "Transaksi Baru" untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <tr id="noResultRow" class="hidden">
                        <td colspan="6" class="px-5 py-10 text-center text-sm text-neutral-400">
                            Tidak ada hasil yang cocok.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if ($transaksi->hasPages())
            <div class="px-5 py-3.5 bg-neutral-50 border-t border-neutral-100 flex items-center justify-between gap-4 flex-wrap">
                <p class="text-xs text-neutral-400">
                    Menampilkan
                    <span class="font-semibold text-neutral-600">{{ $transaksi->firstItem() }}</span>–<span class="font-semibold text-neutral-600">{{ $transaksi->lastItem() }}</span>
                    dari <span class="font-semibold text-neutral-600">{{ $transaksi->total() }}</span> transaksi
                </p>
                <div class="flex items-center gap-1">
                    @if ($transaksi->onFirstPage())
                        <span class="px-3 py-1.5 rounded-lg text-xs text-neutral-300 border border-neutral-100 cursor-not-allowed">← Prev</span>
                    @else
                        <a href="{{ $transaksi->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs text-primary-600 border border-neutral-200 hover:bg-primary-50 transition-colors">← Prev</a>
                    @endif

                    @foreach ($transaksi->getUrlRange(1, $transaksi->lastPage()) as $page => $url)
                        @if ($page == $transaksi->currentPage())
                            <span class="px-3 py-1.5 rounded-lg text-xs bg-primary text-white font-semibold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-1.5 rounded-lg text-xs text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($transaksi->hasMorePages())
                        <a href="{{ $transaksi->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs text-primary-600 border border-neutral-200 hover:bg-primary-50 transition-colors">Next →</a>
                    @else
                        <span class="px-3 py-1.5 rounded-lg text-xs text-neutral-300 border border-neutral-100 cursor-not-allowed">Next →</span>
                    @endif
                </div>
            </div>
        @endif
    </div>

</div>

@include('admin.transaksi.create')
@include('admin.transaksi.edit')
@include('admin.transaksi.destroy')

@endsection