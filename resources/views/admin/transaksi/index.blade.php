@extends('layouts.admin')
@section('title', 'Transaksi')
@section('page-title', 'Transaksi')
@section('page-subtitle', 'Kelola data transaksi tukar buku')

@push('scripts')
    <script>
        window.Routes = {
            transaksiStore: "{{ route('admin.transaksi.store') }}",
            setLokasi:      "{{ route('admin.transaksi.set-lokasi') }}",
        };
        window.LokasiData = {
            lokasiPilihan:   @json($lokasiPilihan),
            activeLokasiId:  @json($activeLokasiId),
            jumlahPenugasan: {{ $lokasiPilihan->count() }},
            isSuperAdmin:    @json(auth()->user()->isSuperAdmin()),
        };
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}';
    </script>
    @vite('resources/js/transaksi-wizard.js')
    <script>
        (function initFilters() {
        const searchInput   = document.getElementById('searchInput');
        const filterTanggal = document.getElementById('filterTanggal');
        const filterLokasi  = document.getElementById('filterLokasi');

        if (!searchInput && !filterTanggal && !filterLokasi) return;

        function applyFilters() {
            const params = new URLSearchParams(window.location.search);

            const search = searchInput?.value.trim();
            search ? params.set('search', search) : params.delete('search');

            const tanggal = filterTanggal?.value;
            tanggal ? params.set('tanggal', tanggal) : params.delete('tanggal');

            const lokasi = filterLokasi?.value;
            lokasi ? params.set('lokasi', lokasi) : params.delete('lokasi');

            params.delete('page');

            window.location.href = '?' + params.toString();
        }

        // Sync state select dengan URL saat load
        const params = new URLSearchParams(window.location.search);
        if (searchInput  && params.get('search'))  searchInput.value   = params.get('search');
        if (filterTanggal && params.get('tanggal')) filterTanggal.value = params.get('tanggal');
        if (filterLokasi  && params.get('lokasi'))  filterLokasi.value  = params.get('lokasi');

        let searchTimer;
        searchInput?.addEventListener('input', () => {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(applyFilters, 400);
        });

        filterTanggal?.addEventListener('change', applyFilters);
        filterLokasi?.addEventListener('change', applyFilters);
    })();
    </script>
@endpush

@section('content')
<div class="flex flex-col gap-5">

    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="flex items-center justify-between gap-4 px-5 pt-5 pb-4 border-b border-neutral-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-700 flex items-center justify-center shrink-0">
                    <x-icons.transaksi class="w-5 h-5"/>
                </div>
                <div>
                    <p class="text-sm font-semibold text-neutral-800 leading-tight">Semua Transaksi</p>
                    <p class="text-xs text-neutral-400 leading-tight">{{ $transaksi->total() }} transaksi terdaftar</p>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                @php
                    $lokasiParams = $paketUser ? '?lokasi=' . urlencode($paketUser->lokasi?->nama_lokasi ?? '') : '';
                @endphp
                <a href="{{ route('admin.transaksi.export') }}{{ $lokasiParams }}"
                    title="Export Excel"
                    class="flex items-center gap-1.5 px-2.5 py-2 sm:px-3.5 rounded-lg text-xs font-medium text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">
                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    <span class="hidden sm:inline">Export Excel</span>
                </a>
                <button type="button"
                        onclick="openModal()"
                        title="Tambah Transaksi"
                        class="flex items-center gap-1.5 px-2.5 py-2 sm:px-3.5 rounded-lg text-xs font-semibold text-white bg-primary-600 hover:bg-primary-700 transition-colors">
                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    <span class="hidden sm:inline">Tambah Transaksi</span>
                </button>
            </div>
        </div>

        {{-- Stats row --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-neutral-100 border-b border-neutral-100">
            @foreach ([
                ['label' => 'Total',      'value' => $transaksi->total(), 'color' => 'text-neutral-800'],
                ['label' => 'Hari Ini',   'value' => $transaksiHariIni,  'color' => 'text-primary-700'],
                ['label' => 'Minggu Ini', 'value' => $transaksiMingguIni,'color' => 'text-success-700'],
                ['label' => 'Bulan Ini',  'value' => $transaksiBulanIni, 'color' => 'text-primary-700'],
            ] as $stat)
            <div class="px-5 py-3.5 flex flex-col gap-0.5">
                <span class="text-xs text-neutral-400 font-medium">{{ $stat['label'] }}</span>
                <span class="text-2xl font-semibold tabular-nums {{ $stat['color'] }}">{{ $stat['value'] }}</span>
            </div>
            @endforeach
        </div>

        {{-- Search & Filter row --}}
        <div class="flex items-center gap-3 px-5 py-3.5">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input
                    id="searchInput"
                    type="text"
                    placeholder="Cari member, buku..."
                    class="w-full pl-9 pr-4 py-2 text-sm text-neutral-700 bg-neutral-50 border border-neutral-200 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"
                />
            </div>
            <select id="filterTanggal"
                    class="px-3 py-2 text-sm text-neutral-600 bg-neutral-50 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition shrink-0">
                <option value="">Semua Waktu</option>
                <option value="hari_ini">Hari Ini</option>
                <option value="minggu_ini">Minggu Ini</option>
                <option value="bulan_ini">Bulan Ini</option>
            </select>
            <select id="filterLokasi"
                    class="px-3 py-2 text-sm text-neutral-600 bg-neutral-50 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition shrink-0">
                <option value="">Semua Lokasi</option>
                @foreach ($lokasiList as $lokasi)
                    <option value="{{ $lokasi }}">{{ $lokasi }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        @if (session('success'))
            <div class="flex items-center gap-2.5 px-5 py-3 bg-success-50 border-b border-success-100 text-success-700 text-sm font-medium">
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-center text-xs font-semibold text-neutral-500 px-2 py-3 w-12">No.</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-2 py-3">ID</th>
                        <th class="text-left   text-xs font-semibold text-neutral-500 px-4 py-3">Member</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Buku Masuk</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Buku Keluar</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Tanggal & Lokasi</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50" id="tableBody">
                    @forelse ($transaksi as $item)
                        @php
                            $txnId = '#TXN-' . str_pad($item->id, 4, '0', STR_PAD_LEFT);
                            $nomor = ($transaksi->perPage() * ($transaksi->currentPage() - 1)) + $loop->iteration;
                        @endphp
                        <tr class="hover:bg-neutral-50 transition-colors table-row-data"
                            data-search="{{ strtolower($item->member?->nama ?? '') }} {{ strtolower($item->bukuMasuk?->buku?->judul ?? '') }} {{ strtolower($item->bukuKeluar?->buku?->judul ?? '') }}">

                            <td class="px-2 py-3.5 text-center">
                                <span class="text-xs font-mono font-medium text-neutral-500">{{ $nomor }}</span>
                            </td>

                            <td class="px-2 py-3.5 text-center">
                                <span class="text-xs font-mono font-medium text-neutral-500">{{ $txnId }}</span>
                            </td>

                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white text-xs font-bold shrink-0">
                                        {{ strtoupper(substr($item->member->nama ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-neutral-800 leading-tight">{{ $item->member->nama ?? '-' }}</p>
                                        <p class="text-xs text-neutral-400">{{ $item->member->no_telp ?? '' }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3.5 max-w-40 text-center">
                                <p class="text-sm font-medium text-neutral-700 truncate">{{ $item->bukuMasuk?->buku?->judul ?? '-' }}</p>
                                <p class="text-xs text-neutral-400 mt-0.5">{{ $item->bukuMasuk?->buku?->pengarang ?? '' }}</p>
                            </td>

                            <td class="px-4 py-3.5 max-w-40 text-center">
                                <p class="text-sm font-medium text-neutral-700 truncate">{{ $item->bukuKeluar?->buku?->judul ?? '-' }}</p>
                                <p class="text-xs text-neutral-400 mt-0.5">{{ $item->bukuKeluar?->buku?->pengarang ?? '' }}</p>
                            </td>

                            <td class="px-4 py-3.5 text-center">
                                <p class="text-sm font-medium text-neutral-700">{{ $item->lokasi_snapshot ?? '-' }}</p>
                                <p class="text-xs text-neutral-400 mt-0.5">{{ $item->tanggal_tukar?->format('d M Y') ?? '-' }}</p>
                            </td>

                            <td class="px-4 py-3.5">
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
                                    <p class="text-xs text-neutral-400">Klik "Tambah Transaksi" untuk memulai</p>
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
                            <span class="px-3 py-1.5 rounded-lg text-xs bg-primary-600 text-white font-semibold">{{ $page }}</span>
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