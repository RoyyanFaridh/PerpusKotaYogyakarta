@extends('layouts.admin')
@section('title', 'Semua Buku')
@section('page-title', 'Semua Buku')
@section('page-subtitle', 'Koleksi buku perpustakaan kota')

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
                <button type="button" onclick="bukaModalRelokasi()"
                        class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">
                    Relokasi Buku
                </button>
                <a href="{{ route('admin.paket.index') }}"
                   class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">
                    Kelola Paket
                </a>
            </div>
        </div>

        {{-- Stats row --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-neutral-100 border-b border-neutral-100">
            @foreach ([
                ['label' => 'Total',       'value' => $stats['total'],       'color' => 'text-neutral-800'],
                ['label' => 'Donasi',      'value' => $stats['donasi'],      'color' => 'text-primary-700'],
                ['label' => 'Dalam Paket', 'value' => $stats['dalam_paket'], 'color' => 'text-warning-700'],
                ['label' => 'Tersedia',    'value' => $stats['tersedia'],    'color' => 'text-success-700'],
            ] as $stat)
            <div class="px-5 py-3.5 flex flex-col gap-0.5">
                <span class="text-xs text-neutral-400 font-medium">{{ $stat['label'] }}</span>
                <span class="text-2xl font-semibold tabular-nums {{ $stat['color'] }}">{{ $stat['value'] }}</span>
            </div>
            @endforeach
        </div>

        {{-- Search & Filter row --}}
        <div class="flex flex-wrap items-center gap-3 px-5 py-3.5">
            <div class="relative flex-1 min-w-48">
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
            <select id="lokasi"
                    class="px-3 py-2 text-sm text-neutral-600 bg-neutral-50 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition shrink-0">
                <option value="">Semua Lokasi</option>
                @foreach ($lokasis as $lokasi)
                    <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>
                @endforeach
            </select>
            
            <select id="paket"
                    class="px-3 py-2 text-sm text-neutral-600 bg-neutral-50 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition shrink-0">
                <option value="">Semua Paket</option>
                <option value="tanpa_paket">Tanpa Paket</option>
                @foreach ($pakets as $paket)
                    <option value="{{ $paket->id }}">{{ $paket->nama }}</option>
                @endforeach
            </select>
            <select id="visibility"
                    class="px-3 py-2 text-sm text-neutral-600 bg-neutral-50 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition shrink-0">
                <option value="">Semua Visibilitas</option>
                <option value="visible">Tampil</option>
                <option value="hidden">Disembunyikan</option>
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
                        <th class="text-center text-xs font-semibold text-neutral-500 px-5 py-3 w-[22%]">Judul</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Cover</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-5 py-3 w-[20%]">Judul</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">ISBN</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Kategori</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Stok</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Lokasi</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Paket</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Tampil</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50">
                    @forelse ($bukus as $buku)
                        <tr class="hover:bg-neutral-50 transition-colors">

                            {{-- Cover --}}
                            <td class="px-4 py-3.5 text-center">
                                @if ($buku->cover)
                                    <img src="{{ Storage::url($buku->cover) }}"
                                         alt="Cover {{ $buku->judul }}"
                                         class="w-10 h-14 object-cover rounded-md border border-neutral-100 mx-auto">
                                @else
                                    <div class="w-10 h-14 rounded-md border border-neutral-100 bg-neutral-50 flex items-center justify-center mx-auto">
                                        <svg class="w-4 h-4 text-neutral-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>
                                        </svg>
                                    </div>
                                @endif
                            </td>

                            {{-- Judul + Pengarang + Tahun --}}
                            <td class="px-5 py-3.5">
                                <p class="text-xs font-semibold text-neutral-800 leading-snug line-clamp-2">{{ $buku->judul }}</p>
                                <p class="text-xs text-neutral-400 mt-1 flex items-center gap-1 flex-wrap">
                                    <span>{{ $buku->pengarang }}</span>
                                    @if ($buku->tahun_terbit)
                                        <span class="inline-block w-1 h-1 rounded-full bg-neutral-300 shrink-0"></span>
                                        <span>{{ $buku->tahun_terbit }}</span>
                                    @endif
                                </p>
                            </td>

                            {{-- ISBN --}}
                            <td class="px-4 py-3.5 text-center">
                                <span class="text-xs font-mono text-neutral-500">{{ $buku->isbn ?? '-' }}</span>
                            </td>

                            {{-- Kategori --}}
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

                            {{-- Stok --}}
                            <td class="px-4 py-3.5 text-center">
                                @if ($buku->stok > 0)
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-success-50 text-success-700">{{ $buku->stok }} tersedia</span>
                                @else
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-danger-50 text-danger-700">Habis</span>
                                @endif
                            </td>

                            {{-- Lokasi --}}
                            <td class="px-4 py-3.5 min-w-35 text-center">
                                <p class="text-xs text-neutral-500 leading-snug">{{ $buku->lokasi?->nama_lokasi ?? '—' }}</p>
                            </td>

                            {{-- Paket --}}
                            <td class="px-4 py-3.5 text-center">
                                @if ($buku->paket)
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full
                                        {{ $buku->paket->is_aktif ? 'bg-warning-50 text-warning-700' : 'bg-neutral-100 text-neutral-500' }}">
                                        {{ $buku->paket->nama }}
                                    </span>
                                @else
                                    <span class="text-xs text-neutral-400">—</span>
                                @endif
                            </td>

                            {{-- Tampil / Toggle Visibility --}}
                            <td class="px-4 py-3.5 text-center">
                                @if ($buku->paket_id)
                                    {{-- Dikontrol paket, toggle dinonaktifkan --}}
                                    <span class="text-xs text-neutral-400" title="Dikontrol oleh paket">
                                        via paket
                                    </span>
                                @else
                                    <button type="button"
                                        onclick="toggleVisibilityBuku({{ $buku->id }}, {{ $buku->is_visible ? 'true' : 'false' }}, this)"
                                        title="{{ $buku->is_visible ? 'Klik untuk sembunyikan' : 'Klik untuk tampilkan' }}"
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium transition-colors
                                            {{ $buku->is_visible
                                                ? 'bg-success-50 text-success-700 hover:bg-success-100'
                                                : 'bg-neutral-100 text-neutral-500 hover:bg-neutral-200' }}">
                                        {{ $buku->is_visible ? 'Tampil' : 'Tersembunyi' }}
                                    </button>
                                @endif
                            </td>

                            {{-- Aksi --}}
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
                                            'deskripsi'     => $buku->deskripsi,
                                            'lokasi_id'     => $buku->lokasi_id,
                                            'paket_id'      => $buku->paket_id,
                                            'is_visible'    => $buku->is_visible,
                                            'cover'         => $buku->cover,
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
@include('admin.buku.relokasi')
@include('admin.paket.create')

@push('scripts')
<script>
(function () {
    const searchInput    = document.getElementById('searchInput');
    const selectKategori = document.getElementById('kategori');
    const selectLokasi   = document.getElementById('lokasi');
    const selectPaket    = document.getElementById('paket');
    const selectVis      = document.getElementById('visibility');

    function applyFilters() {
        const params = new URLSearchParams();
        const q = searchInput?.value.trim();
        if (q)                     params.set('search',     q);
        if (selectKategori?.value) params.set('kategori',   selectKategori.value);
        if (selectLokasi?.value)   params.set('lokasi',     selectLokasi.value);
        if (selectPaket?.value)    params.set('paket',      selectPaket.value);
        if (selectVis?.value)      params.set('visibility', selectVis.value);
        window.location.href = `${window.location.pathname}?${params.toString()}`;
    }

    let debounce;
    searchInput?.addEventListener('input', function () {
        clearTimeout(debounce);
        debounce = setTimeout(applyFilters, 400);
    });
    selectKategori?.addEventListener('change', applyFilters);
    selectLokasi?.addEventListener('change',   applyFilters);
    selectPaket?.addEventListener('change',    applyFilters);
    selectVis?.addEventListener('change',      applyFilters);

    // Restore filter state dari URL
    const params = new URLSearchParams(window.location.search);
    if (searchInput    && params.get('search'))     searchInput.value    = params.get('search');
    if (selectKategori && params.get('kategori'))   selectKategori.value = params.get('kategori');
    if (selectLokasi   && params.get('lokasi'))     selectLokasi.value   = params.get('lokasi');
    if (selectPaket    && params.get('paket'))      selectPaket.value    = params.get('paket');
    if (selectVis      && params.get('visibility')) selectVis.value      = params.get('visibility');
})();

// Toggle visibility inline (tanpa reload penuh)
function toggleVisibilityBuku(id, currentlyVisible, btn) {
    btn.disabled = true;
    btn.classList.add('opacity-50', 'cursor-wait');

    fetch(`/admin/buku/${id}/toggle-visibility`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
    })
    .then(r => r.json())
    .then(data => {
        const nowVisible = data.is_visible;
        btn.textContent = nowVisible ? 'Tampil' : 'Tersembunyi';
        btn.title       = nowVisible ? 'Klik untuk sembunyikan' : 'Klik untuk tampilkan';
        btn.onclick     = () => toggleVisibilityBuku(id, nowVisible, btn);

        // Swap badge colour
        btn.classList.remove(
            'bg-success-50', 'text-success-700', 'hover:bg-success-100',
            'bg-neutral-100', 'text-neutral-500', 'hover:bg-neutral-200'
        );
        if (nowVisible) {
            btn.classList.add('bg-success-50', 'text-success-700', 'hover:bg-success-100');
        } else {
            btn.classList.add('bg-neutral-100', 'text-neutral-500', 'hover:bg-neutral-200');
        }
    })
    .catch(() => {
        alert('Gagal mengubah visibilitas. Coba lagi.');
    })
    .finally(() => {
        btn.disabled = false;
        btn.classList.remove('opacity-50', 'cursor-wait');
    });
}
</script>
@endpush
@endsection