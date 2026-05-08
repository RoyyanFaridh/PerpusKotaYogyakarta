@extends('layouts.admin')
@section('title', 'Semua Buku')
@section('page-title', 'Semua Buku')
@section('page-subtitle', 'Koleksi buku perpustakaan dan buku tukar')

@section('content')
<div class="flex flex-col gap-4">

    <x-admin.page-header
        title="Semua Buku"
        :subtitle="$stats['total'] . ' buku terdaftar'"
        icon="book"
        button-onclick="openTambah()"
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
                    ['value' => 'Novel',     'label' => 'Novel'],
                    ['value' => 'Sains',     'label' => 'Sains'],
                    ['value' => 'Sejarah',   'label' => 'Sejarah'],
                    ['value' => 'Teknologi', 'label' => 'Teknologi'],
                    ['value' => 'Anak-anak', 'label' => 'Anak-anak'],
                    ['value' => 'Lainnya',   'label' => 'Lainnya'],
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

    {{-- Flash Message --}}
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
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Judul</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Pengarang</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">ISBN</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Kategori</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Sumber</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Stok</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Lokasi</th>
                        <th class="text-right text-xs font-medium text-neutral-400 px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50" id="tableBody">
                    @forelse ($bukus as $buku)
                        <tr class="hover:bg-neutral-50 transition-colors table-row-data"
                            data-search="{{ strtolower($buku->judul) }} {{ strtolower($buku->pengarang) }} {{ strtolower($buku->isbn ?? '') }}">
                            <td class="px-5 py-3.5">
                                <p class="text-xs font-semibold text-neutral-800 max-w-[200px] truncate">{{ $buku->judul }}</p>
                                <p class="text-[0.68rem] text-neutral-400 mt-0.5">{{ $buku->tahun_terbit ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-3.5 text-xs text-neutral-600 whitespace-nowrap">
                                {{ $buku->pengarang }}
                            </td>
                            <td class="px-5 py-3.5 text-xs font-mono text-neutral-500">
                                {{ $buku->isbn ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5">
                                @if ($buku->kategori)
                                    <span class="text-[0.68rem] font-medium px-2 py-0.5 rounded-full bg-primary-50 text-primary-700">
                                        {{ $buku->kategori }}
                                    </span>
                                @else
                                    <span class="text-[0.68rem] text-neutral-400">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                @if ($buku->sumber === 'perpus')
                                    <span class="text-[0.68rem] font-medium px-2 py-0.5 rounded-full bg-primary-50 text-primary-700">Perpus</span>
                                @else
                                    <span class="text-[0.68rem] font-medium px-2 py-0.5 rounded-full bg-warning-50 text-warning-700">Tukar</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                @if ($buku->stok > 0)
                                    <span class="text-[0.68rem] font-medium px-2 py-0.5 rounded-full bg-success-50 text-success-700">{{ $buku->stok }} tersedia</span>
                                @else
                                    <span class="text-[0.68rem] font-medium px-2 py-0.5 rounded-full bg-danger-50 text-danger-700">Habis</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-xs text-neutral-500 whitespace-nowrap">
                                {{ $buku->lokasi?->nama_lokasi ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-1.5">
                                    {{-- Edit --}}
                                    <button onclick="openEdit({{ $buku->id }})"
                                        class="p-1.5 rounded-lg text-neutral-400 hover:text-primary-600 hover:bg-primary-50 transition-colors"
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </button>
                                    {{-- Hapus --}}
                                    @include('admin.buku.destroy', ['buku' => $buku])
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

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Client-side search
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