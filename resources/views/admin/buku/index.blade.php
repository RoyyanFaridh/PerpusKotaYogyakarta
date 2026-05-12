@extends('layouts.admin')
@section('title', 'Semua Buku')
@section('page-title', 'Semua Buku')
@section('page-subtitle', 'Koleksi buku perpustakaan dan buku tukar')

@section('content')

@php
$categoryColorMap = [
    'Umum/Komputer'        => 'bg-indigo-50 text-indigo-700',
    'Filsafat & Psikologi' => 'bg-violet-50 text-violet-700',
    'Agama'                => 'bg-rose-50 text-rose-700',
    'ILmu Sosial'          => 'bg-amber-50 text-amber-700',
    'Bahasa'               => 'bg-teal-50 text-teal-700',
    'Sains & Matematika'   => 'bg-success-50 text-success-700',
    'Teknologi'            => 'bg-danger-50 text-danger-700',
    'Seni & Rekreasi'      => 'bg-primary-50 text-primary-700',
    'Literatur & Sastra'   => 'bg-neutral-100 text-neutral-500',
    'Geografi & Sejarah'   => 'bg-sky-100 text-sky-500',
];
@endphp

<div class="flex flex-col gap-4">

    <x-admin.page-header
        title="Semua Buku"
        :subtitle="$stats['total'] . ' buku terdaftar'"
        icon="book"
        button-onclick="bukaModalBuku()"
        route-label="Tambah Buku"
        placeholder="Cari judul, pengarang, ISBN..."
        search-id="searchInput"
        :stats="[
            ['label' => 'Total',    'value' => $stats['total'],    'color' => 'text-neutral-800'],
            ['label' => 'Perpus',   'value' => $stats['perpus'],   'color' => 'text-primary-700'],
            ['label' => 'Tukar',    'value' => $stats['tukar'],    'color' => 'text-warning-700'],
            ['label' => 'Tersedia', 'value' => $stats['tersedia'], 'color' => 'text-success-700'],
        ]"
        :filters="[
            [
                'name'        => 'kategori',
                'placeholder' => 'Semua Kategori',
                'options'     => [
                    ['value' => 'Umum/Komputer',        'label' => 'Umum/Komputer'],
                    ['value' => 'Filsafat & Psikologi', 'label' => 'Filsafat & Psikologi'],
                    ['value' => 'Agama',                'label' => 'Agama'],
                    ['value' => 'ILmu Sosial',          'label' => 'ILmu Sosial'],
                    ['value' => 'Bahasa',               'label' => 'Bahasa'],
                    ['value' => 'Sains & Matematika',   'label' => 'Sains & Matematika'],
                    ['value' => 'Teknologi',            'label' => 'Teknologi'],
                    ['value' => 'Seni & Rekreasi',      'label' => 'Seni & Rekreasi'],
                    ['value' => 'Literatur & Sastra',   'label' => 'Literatur & Sastra'],
                    ['value' => 'Geografi & Sejarah',   'label' => 'Geografi & Sejarah'],
                ],
            ],
            [
                'name'        => 'stok',
                'placeholder' => 'Semua Stok',
                'options'     => [
                    ['value' => 'tersedia', 'label' => 'Tersedia'],
                    ['value' => 'habis',    'label' => 'Habis'],
                ],
            ],
        ]"
    />

    @if (session('success'))
        <div class="flex items-center gap-2.5 px-5 py-3 rounded-xl bg-success-50 border border-success-100 text-success-700 text-xs font-medium">
            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Judul</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Pengarang</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">ISBN</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Kategori</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Sumber</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Stok</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Lokasi</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50" id="tableBody">
                    @forelse ($bukus as $buku)
                        <tr class="hover:bg-neutral-50 transition-colors table-row-data"
                            data-search="{{ strtolower($buku->judul) }} {{ strtolower($buku->pengarang) }} {{ strtolower($buku->isbn ?? '') }}">

                            {{-- Judul --}}
                            <td class="px-5 py-3.5">
                                <p class="text-xs font-semibold text-neutral-800 max-w-50 truncate">{{ $buku->judul }}</p>
                                <p class="text-[0.68rem] text-neutral-400 mt-0.5">{{ $buku->tahun_terbit ?? '-' }}</p>
                            </td>

                            {{-- Pengarang --}}
                            <td class="px-5 py-3.5 text-xs text-neutral-600 whitespace-nowrap">
                                {{ $buku->pengarang }}
                            </td>

                            {{-- ISBN --}}
                            <td class="px-5 py-3.5 text-xs font-mono text-neutral-500">
                                {{ $buku->isbn ?? '-' }}
                            </td>

                            {{-- Kategori --}}
                            <td class="px-5 py-3.5">
                                @if ($buku->kategori)
                                    @php $catClass = $categoryColorMap[$buku->kategori] ?? 'bg-neutral-100 text-neutral-500'; @endphp
                                    <span class="text-[0.68rem] font-medium px-2 py-0.5 rounded-full {{ $catClass }}">
                                        {{ $buku->kategori }}
                                    </span>
                                @else
                                    <span class="text-[0.68rem] text-neutral-400">-</span>
                                @endif
                            </td>

                            {{-- Sumber --}}
                            <td class="px-5 py-3.5">
                                @if ($buku->sumber === 'perpus')
                                    <span class="text-[0.68rem] font-medium px-2 py-0.5 rounded-full bg-primary-50 text-primary-700">Perpus</span>
                                @else
                                    <span class="text-[0.68rem] font-medium px-2 py-0.5 rounded-full bg-warning-50 text-warning-700">Tukar</span>
                                @endif
                            </td>

                            {{-- Stok --}}
                            <td class="px-5 py-3.5">
                                @if ($buku->stok > 0)
                                    <span class="text-[0.68rem] font-medium px-2 py-0.5 rounded-full bg-success-50 text-success-700">{{ $buku->stok }} tersedia</span>
                                @else
                                    <span class="text-[0.68rem] font-medium px-2 py-0.5 rounded-full bg-danger-50 text-danger-700">Habis</span>
                                @endif
                            </td>

                            {{-- Lokasi --}}
                            <td class="px-5 py-3.5 text-xs text-neutral-500 whitespace-nowrap">
                                {{ $buku->lokasi?->nama_lokasi ?? '-' }}
                            </td>

                            {{-- Aksi --}}
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button"
                                        onclick="bukaModalEditBuku({{ json_encode([
                                            'id'           => $buku->id,
                                            'judul'        => $buku->judul,
                                            'pengarang'    => $buku->pengarang,
                                            'penerbit'     => $buku->penerbit,
                                            'isbn'         => $buku->isbn,
                                            'tahun_terbit' => $buku->tahun_terbit,
                                            'tempat_terbit'=> $buku->tempat_terbit,
                                            'resume'       => $buku->resume,
                                            'stok'         => $buku->stok,
                                            'kategori'     => $buku->kategori,
                                            'sumber'       => $buku->sumber,
                                            'kondisi'      => $buku->kondisi,
                                            'deskripsi'    => $buku->deskripsi,
                                            'lokasi_id'    => $buku->lokasi_id,
                                            'member_id'    => $buku->member_id,
                                        ]) }})"
                                        class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-primary-300 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                        <x-icons.edit/>
                                        <span>Edit</span>
                                    </button>

                                    <button type="button"
                                        onclick="bukaModalHapusBuku(
                                            '{{ route('admin.buku.destroy', $buku) }}',
                                            '{{ addslashes($buku->judul) }}'
                                        )"
                                        class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-danger-300 hover:text-danger-600 hover:bg-danger-50 transition-colors">
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

                    <tr id="noResultRow" class="hidden">
                        <td colspan="8" class="px-5 py-10 text-center text-xs text-neutral-400">
                            Tidak ada hasil yang cocok.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if ($bukus->hasPages())
            <div class="px-5 py-3 bg-neutral-50 border-t border-neutral-100">
                {{ $bukus->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>

@include('admin.buku.create')
@include('admin.buku.edit')
@include('admin.buku.destroy')

<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const rows        = document.querySelectorAll('.table-row-data');
    const noResultRow = document.getElementById('noResultRow');

    searchInput?.addEventListener('input', () => {
        const q = searchInput.value.toLowerCase().trim();
        let visible = 0;
        rows.forEach(row => {
            const match = !q || row.dataset.search.includes(q);
            row.classList.toggle('hidden', !match);
            if (match) visible++;
        });
        noResultRow.classList.toggle('hidden', visible > 0);
    });
});

function confirmHapus(e, judul) {
    if (!confirm(`Hapus buku "${judul}"?\nTindakan ini tidak bisa dibatalkan.`)) {
        e.preventDefault();
        return false;
    }
    return true;
}
</script>

@endsection