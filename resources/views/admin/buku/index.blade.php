@extends('layouts.admin')
@section('title', 'Semua Buku')
@section('page-title', 'Semua Buku')
@section('page-subtitle', 'Koleksi buku perpustakaan dan buku tukar')

@section('content')

@php
$categoryColorMap = [
    'Umum/Komputer'        => 'bg-primary-50 text-primary-700',
    'Filsafat & Psikologi' => 'bg-warning-50 text-warning-700',
    'Agama'                => 'bg-danger-50 text-danger-700',
    'Ilmu Sosial'          => 'bg-success-50 text-success-700',
    'Bahasa'               => 'bg-primary-50 text-primary-800',
    'Sains & Matematika'   => 'bg-success-50 text-success-800',
    'Teknologi'            => 'bg-neutral-100 text-neutral-600',
    'Seni & Rekreasi'      => 'bg-warning-50 text-warning-800',
    'Literatur & Sastra'   => 'bg-neutral-100 text-neutral-500',
    'Geografi & Sejarah'   => 'bg-primary-50 text-primary-600',
];
@endphp

<div class="flex flex-col gap-5">

    {{-- Page Header Card --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        {{-- Title row --}}
        <div class="flex items-center justify-between gap-4 px-5 pt-5 pb-4 border-b border-neutral-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-700 flex items-center justify-center shrink-0">
                    <x-icons.book class="w-5 h-5"/>
                </div>
                <div>
                    <p class="text-sm font-semibold text-neutral-800 leading-tight">Semua Buku</p>
                    <p class="text-xs text-neutral-400 leading-tight">{{ $stats['total'] }} buku terdaftar</p>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <button type="button" onclick="bukaModalBuku()"
                        class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold text-white bg-primary-600 hover:bg-primary-700 transition-colors">
                    Tambah Buku
                </button>
            </div>
        </div>

        {{-- Stats row --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-neutral-100 border-b border-neutral-100">
            @foreach ([
                ['label' => 'Total',    'value' => $stats['total'],    'color' => 'text-neutral-800'],
                ['label' => 'Perpus',   'value' => $stats['perpus'],   'color' => 'text-primary-700'],
                ['label' => 'Tukar',    'value' => $stats['tukar'],    'color' => 'text-warning-700'],
                ['label' => 'Tersedia', 'value' => $stats['tersedia'], 'color' => 'text-success-700'],
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
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input id="searchInput" type="text"
                       placeholder="Cari judul, pengarang, ISBN..."
                       class="w-full pl-9 pr-4 py-2 text-sm text-neutral-700 bg-neutral-50 border border-neutral-200 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
            <select id="kategori"
                    class="px-3 py-2 text-sm text-neutral-600 bg-neutral-50 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition shrink-0">
                <option value="">Semua Kategori</option>
                @foreach ([
                    'Umum/Komputer','Filsafat & Psikologi','Agama','Ilmu Sosial','Bahasa',
                    'Sains & Matematika','Teknologi','Seni & Rekreasi','Literatur & Sastra','Geografi & Sejarah'
                ] as $kat)
                    <option value="{{ $kat }}">{{ $kat }}</option>
                @endforeach
            </select>
            <select id="stok"
                    class="px-3 py-2 text-sm text-neutral-600 bg-neutral-50 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition shrink-0">
                <option value="">Semua Stok</option>
                <option value="tersedia">Tersedia</option>
                <option value="habis">Habis</option>
            </select>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        @if (session('success'))
            <div class="flex items-center gap-2.5 px-5 py-3 bg-success-50 border-b border-success-100 text-success-700 text-sm font-medium">
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left   text-xs font-semibold text-neutral-500 px-5 py-3">Judul</th>
                        <th class="text-left   text-xs font-semibold text-neutral-500 px-4 py-3">Pengarang</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">ISBN</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Kategori</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Sumber</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Stok</th>
                        <th class="text-left   text-xs font-semibold text-neutral-500 px-4 py-3">Lokasi</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50">
                    @forelse ($bukus as $buku)
                        <tr class="hover:bg-neutral-50 transition-colors">

                            <td class="px-5 py-3.5">
                                <p class="text-xs font-semibold text-neutral-800 max-w-50 truncate">{{ $buku->judul }}</p>
                                <p class="text-xs text-neutral-400 mt-0.5">{{ $buku->tahun_terbit ?? '-' }}</p>
                            </td>

                            <td class="px-4 py-3.5">
                                <p class="text-xs text-neutral-600 max-w-35 truncate">{{ $buku->pengarang }}</p>
                            </td>

                            <td class="px-4 py-3.5 text-center">
                                <span class="text-xs font-mono text-neutral-500">{{ $buku->isbn ?? '-' }}</span>
                            </td>

                            <td class="px-4 py-3.5 text-center">
                                @if ($buku->kategori)
                                    @php $catClass = $categoryColorMap[$buku->kategori] ?? 'bg-neutral-100 text-neutral-500'; @endphp
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $catClass }}">
                                        {{ $buku->kategori }}
                                    </span>
                                @else
                                    <span class="text-xs text-neutral-400">—</span>
                                @endif
                            </td>

                            <td class="px-4 py-3.5 text-center">
                                @if ($buku->sumber === 'perpus')
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-primary-50 text-primary-700">Perpus</span>
                                @else
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-warning-50 text-warning-700">Tukar</span>
                                @endif
                            </td>

                            <td class="px-4 py-3.5 text-center">
                                @if ($buku->stok > 0)
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-success-50 text-success-700">{{ $buku->stok }} tersedia</span>
                                @else
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-danger-50 text-danger-700">Habis</span>
                                @endif
                            </td>

                            <td class="px-4 py-3.5">
                                <p class="text-xs text-neutral-500 max-w-30 truncate">{{ $buku->lokasi?->nama_lokasi ?? '—' }}</p>
                            </td>

                            <td class="px-4 py-3.5">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="button"
                                        onclick="bukaModalEditBuku({{ json_encode([
                                            'id'            => $buku->id,
                                            'judul'         => $buku->judul,
                                            'pengarang'     => $buku->pengarang,
                                            'penerbit'      => $buku->penerbit,
                                            'isbn'          => $buku->isbn,
                                            'tahun_terbit'  => $buku->tahun_terbit,
                                            'tempat_terbit' => $buku->tempat_terbit,
                                            'resume'        => $buku->resume,
                                            'stok'          => $buku->stok,
                                            'kategori'      => $buku->kategori,
                                            'sumber'        => $buku->sumber,
                                            'kondisi'       => $buku->kondisi,
                                            'deskripsi'     => $buku->deskripsi,
                                            'lokasi_id'     => $buku->lokasi_id,
                                        ]) }})"
                                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-warning-300 hover:text-warning-600 hover:bg-warning-50 transition-colors">
                                        <x-icons.edit/>
                                        <span>Edit</span>
                                    </button>
                                    <button type="button"
                                        onclick="bukaModalHapusBuku(
                                            '{{ route('admin.buku.destroy', $buku) }}',
                                            '{{ addslashes($buku->judul) }}'
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
                            <td colspan="8" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-10 h-10 rounded-xl bg-neutral-100 flex items-center justify-center">
                                        <x-icons.book class="w-5 h-5 text-neutral-400"/>
                                    </div>
                                    <p class="text-sm font-medium text-neutral-500">Belum ada buku</p>
                                    <p class="text-xs text-neutral-400">Tambah buku terlebih dahulu</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($bukus->hasPages())
            <div class="px-5 py-3.5 bg-neutral-50 border-t border-neutral-100 flex items-center justify-between gap-4 flex-wrap">
                <p class="text-xs text-neutral-400">
                    Menampilkan
                    <span class="font-semibold text-neutral-600">{{ $bukus->firstItem() }}</span>–<span class="font-semibold text-neutral-600">{{ $bukus->lastItem() }}</span>
                    dari <span class="font-semibold text-neutral-600">{{ $bukus->total() }}</span> buku
                </p>
                <div class="flex items-center gap-1">
                    @if ($bukus->onFirstPage())
                        <span class="px-3 py-1.5 rounded-lg text-xs text-neutral-300 border border-neutral-100 cursor-not-allowed">← Prev</span>
                    @else
                        <a href="{{ $bukus->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs text-primary-600 border border-neutral-200 hover:bg-primary-50 transition-colors">← Prev</a>
                    @endif

                    @foreach ($bukus->getUrlRange(1, $bukus->lastPage()) as $page => $url)
                        @if ($page == $bukus->currentPage())
                            <span class="px-3 py-1.5 rounded-lg text-xs bg-primary-600 text-white font-semibold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-1.5 rounded-lg text-xs text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($bukus->hasMorePages())
                        <a href="{{ $bukus->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs text-primary-600 border border-neutral-200 hover:bg-primary-50 transition-colors">Next →</a>
                    @else
                        <span class="px-3 py-1.5 rounded-lg text-xs text-neutral-300 border border-neutral-100 cursor-not-allowed">Next →</span>
                    @endif
                </div>
            </div>
        @endif
    </div>

</div>

@include('admin.buku.create')
@include('admin.buku.edit')
@include('admin.buku.destroy')

@push('scripts')
<script>
(function () {
    const searchInput    = document.getElementById('searchInput');
    const selectKategori = document.getElementById('kategori');
    const selectStok     = document.getElementById('stok');

    function applyFilters() {
        const params = new URLSearchParams();
        const q = searchInput?.value.trim();
        if (q) params.set('search', q);
        if (selectKategori?.value) params.set('kategori', selectKategori.value);
        if (selectStok?.value)     params.set('stok',     selectStok.value);
        window.location.href = `${window.location.pathname}?${params.toString()}`;
    }

    let debounce;
    searchInput?.addEventListener('input', function () {
        clearTimeout(debounce);
        debounce = setTimeout(applyFilters, 400);
    });
    selectKategori?.addEventListener('change', applyFilters);
    selectStok?.addEventListener('change', applyFilters);

    const params = new URLSearchParams(window.location.search);
    if (searchInput && params.get('search'))       searchInput.value    = params.get('search');
    if (selectKategori && params.get('kategori'))  selectKategori.value = params.get('kategori');
    if (selectStok && params.get('stok'))          selectStok.value     = params.get('stok');
})();
</script>
@endpush
@endsection