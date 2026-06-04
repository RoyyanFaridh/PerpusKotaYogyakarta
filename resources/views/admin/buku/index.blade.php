@extends('layouts.admin')
@section('title', 'Semua Buku')
@section('page-title', 'Semua Buku')
@section('page-subtitle', 'Koleksi buku perpustakaan kota')

@section('content')
<div class="flex flex-col gap-5">

    {{-- Page Header --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="flex items-center justify-between gap-4 px-5 pt-5 pb-4 border-b border-neutral-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-700 flex items-center justify-center shrink-0">
                    <x-icons.book class="w-5 h-5"/>
                </div>
                <div>
                    <p class="text-sm font-semibold text-neutral-800 leading-tight">Semua Buku</p>
                    <p class="text-xs text-neutral-400 leading-tight">{{ $stats['total_judul'] }} judul terdaftar</p>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button
                        @click="open = !open"
                        class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-medium text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Export
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 transition-transform duration-150" :class="{ 'rotate-180': open }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </button>

                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-1.5 w-48 rounded-lg border border-neutral-200 bg-white shadow-lg shadow-neutral-200/60 z-10"
                        style="display: none;"
                    >
                        <div class="py-1">
                            <a href="{{ route('admin.buku.export') }}"
                            class="flex items-center gap-2.5 px-3.5 py-2 text-xs text-neutral-700 hover:bg-neutral-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-neutral-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>
                                </svg>
                                Export Internal
                            </a>
                            <a href="{{ route('admin.buku.export') }}?publik=1"
                            class="flex items-center gap-2.5 px-3.5 py-2 text-xs text-neutral-700 hover:bg-neutral-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-neutral-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                                </svg>
                                Export Katalog Publik
                            </a>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="bukaModalBuku()"
                        class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold text-white bg-primary-600 hover:bg-primary-700 transition-colors">
                    Tambah Buku
                </button>
                <a href="{{ route('admin.paket.index') }}"
                class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">
                    Kelola Paket
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-neutral-100 border-b border-neutral-100">
            @foreach ([
                ['label' => 'Total Judul',   'value' => $stats['total_judul'],   'color' => 'text-neutral-800'],
                ['label' => 'Total Stok',    'value' => $stats['total_stok'],    'color' => 'text-primary-700'],
                ['label' => 'Dalam Paket',   'value' => $stats['dalam_paket'],   'color' => 'text-warning-700'],
                ['label' => 'Stok Tersedia', 'value' => $stats['stok_tersedia'], 'color' => 'text-success-700'],
            ] as $stat)
            <div class="px-5 py-3.5 flex flex-col gap-0.5">
                <span class="text-xs text-neutral-400 font-medium">{{ $stat['label'] }}</span>
                <span class="text-2xl font-semibold tabular-nums {{ $stat['color'] }}">{{ $stat['value'] }}</span>
            </div>
            @endforeach
        </div>

        {{-- Filter --}}
        <div class="flex flex-wrap items-center gap-3 px-5 py-3.5">
            <div class="relative flex-1 min-w-48">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input id="filterSearch" type="text"
                       placeholder="Cari judul, pengarang, ISBN..."
                       class="w-full pl-9 pr-4 py-2 text-sm text-neutral-700 bg-neutral-50 border border-neutral-200 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
            <select id="filterKategori"
                    class="px-3 py-2 text-sm text-neutral-600 bg-neutral-50 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition shrink-0">
                <option value="">Semua Kategori</option>
                @foreach ([
                    'Umum/Komputer','Filsafat & Psikologi','Agama','Ilmu Sosial','Bahasa',
                    'Sains & Matematika','Teknologi','Seni & Rekreasi','Literatur & Sastra','Geografi & Sejarah'
                ] as $kat)
                    <option value="{{ $kat }}">{{ $kat }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-2.5 px-5 py-3 bg-success-50 border border-success-100 rounded-xl text-success-700 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    {{-- Paket Groups --}}
    <div id="paketContainer" class="flex flex-col gap-4">
        @forelse ($pakets as $paket)
            <x-admin.buku.paket-group :paket="$paket"/>
        @empty
            <div class="rounded-xl border border-neutral-200 bg-white p-12 flex flex-col items-center gap-2">
                <div class="w-10 h-10 rounded-xl bg-neutral-100 flex items-center justify-center">
                    <x-icons.book class="w-5 h-5 text-neutral-400"/>
                </div>
                <p class="text-sm font-medium text-neutral-500">Belum ada paket</p>
                <p class="text-xs text-neutral-400">Buat paket terlebih dahulu sebelum menambah buku</p>
            </div>
        @endforelse

        {{-- Tanpa Paket --}}
        @if ($tanpaPaket->isNotEmpty())
            <div class="rounded-xl border border-neutral-200 bg-white overflow-hidden"
                 x-data="{ open: true }">
                <button type="button"
                        @click="open = !open"
                        class="w-full flex items-center justify-between px-5 py-3.5 bg-neutral-50 hover:bg-neutral-100 transition-colors border-b border-neutral-200">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-neutral-100 text-neutral-400 flex items-center justify-center shrink-0">
                            <x-icons.book class="w-4 h-4"/>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-semibold text-neutral-800 leading-tight">Tanpa Paket</p>
                            <p class="text-xs text-neutral-400 mt-0.5">{{ $tanpaPaket->count() }} eksemplar</p>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-neutral-400 transition-transform"
                         :class="open ? 'rotate-180' : ''"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>
                <div x-show="open" x-collapse>
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-neutral-100 bg-neutral-50/50">
                                <th class="text-left text-xs font-medium text-neutral-500 px-5 py-2.5">Judul</th>
                                <th class="text-center text-xs font-medium text-neutral-500 px-4 py-2.5">ISBN</th>
                                <th class="text-center text-xs font-medium text-neutral-500 px-4 py-2.5">Kategori</th>
                                <th class="text-center text-xs font-medium text-neutral-500 px-4 py-2.5">Stok</th>
                                <th class="text-center text-xs font-medium text-neutral-500 px-4 py-2.5">Tampil</th>
                                <th class="text-center text-xs font-medium text-neutral-500 px-4 py-2.5">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-50">
                            @foreach ($tanpaPaket as $eksemplar)
                                <x-admin.buku.eksemplar-row :eksemplar="$eksemplar"/>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

</div>

@include('admin.buku.create')
@include('admin.buku.edit')
@include('admin.buku.destroy')
@include('admin.paket.create')

@push('scripts')
<script>
(function () {
    const searchInput = document.getElementById('filterSearch');
    const kategoriSel = document.getElementById('filterKategori');
    const btnExport   = document.getElementById('btnExport');
    const exportBase  = '{{ route('admin.buku.export') }}';

    function filterRows() {
        const q   = searchInput?.value.toLowerCase().trim() ?? '';
        const kat = kategoriSel?.value.toLowerCase() ?? '';

        document.querySelectorAll('#paketContainer tbody tr').forEach(row => {
            const text    = row.textContent.toLowerCase();
            const katCell = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() ?? '';
            const matchQ  = !q   || text.includes(q);
            const matchK  = !kat || katCell.includes(kat);
            row.style.display = matchQ && matchK ? '' : 'none';
        });

        // Sync export button dengan filter kategori
        if (btnExport) {
            const params = new URLSearchParams();
            if (kat) params.set('kategori', kategoriSel.value);
            const qs = params.toString();
            btnExport.href = qs ? `${exportBase}?${qs}` : exportBase;
        }
    }

    let debounce;
    searchInput?.addEventListener('input', () => {
        clearTimeout(debounce);
        debounce = setTimeout(filterRows, 250);
    });
    kategoriSel?.addEventListener('change', filterRows);
})();

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
    .catch(() => alert('Gagal mengubah visibilitas.'))
    .finally(() => {
        btn.disabled = false;
        btn.classList.remove('opacity-50', 'cursor-wait');
    });
}
</script>
@endpush
@endsection