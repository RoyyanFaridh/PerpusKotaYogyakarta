@extends('layouts.admin')
@section('title', 'Manajemen Paket Buku')
@section('page-title', 'Paket Buku')
@section('page-subtitle', 'Kelola rotasi dan visibilitas paket buku')

@section('content')
<div class="flex flex-col gap-5">

    {{-- Page Header --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="flex items-center justify-between gap-4 px-5 pt-5 pb-4 border-b border-neutral-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-warning-50 text-warning-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73L13 2.27a2 2 0 0 0-2 0L4 6.27A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                        <line x1="12" y1="22.08" x2="12" y2="12"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-neutral-800 leading-tight">Paket Buku</p>
                    <p class="text-xs text-neutral-400 leading-tight">{{ $stats['total'] }} paket terdaftar</p>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('admin.buku.index') }}"
                   class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">
                    ← Kembali ke Buku
                </a>
                <button type="button" onclick="bukaModalBuatPaket()"
                        class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold text-white bg-primary-600 hover:bg-primary-700 transition-colors">
                    Buat Paket Baru
                </button>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 divide-x divide-neutral-100">
            @foreach ([
                ['label' => 'Total Paket', 'value' => $stats['total'],      'color' => 'text-neutral-800'],
                ['label' => 'Paket Aktif', 'value' => $stats['aktif'],      'color' => 'text-success-700'],
                ['label' => 'Total Stok',  'value' => $stats['total_stok'], 'color' => 'text-primary-700'],
            ] as $stat)
            <div class="px-5 py-3.5 flex flex-col gap-0.5">
                <span class="text-xs text-neutral-400 font-medium">{{ $stat['label'] }}</span>
                <span class="text-2xl font-semibold tabular-nums {{ $stat['color'] }}">{{ $stat['value'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    @if (session('success'))
        <div class="flex items-center gap-2.5 px-5 py-3 bg-success-50 border border-success-100 rounded-xl text-success-700 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="flex items-center gap-2.5 px-5 py-3 bg-danger-50 border border-danger-100 rounded-xl text-danger-700 text-sm font-medium">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabel --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left   text-xs font-semibold text-neutral-500 px-5 py-3">Nama Paket</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Lokasi</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Eksemplar</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Stok</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Status</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Dibuat</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50">
                    @forelse ($pakets as $paket)
                        <tr class="hover:bg-neutral-50 transition-colors">

                            <td class="px-5 py-3.5">
                                <p class="text-xs font-semibold text-neutral-800">{{ $paket->nama }}</p>
                                <p class="text-xs text-neutral-400 mt-0.5">ID #{{ $paket->id }}</p>
                            </td>

                            <td class="px-4 py-3.5 text-center">
                                <span class="text-xs text-neutral-500">{{ $paket->lokasi?->nama_lokasi ?? '—' }}</span>
                            </td>

                            <td class="px-4 py-3.5 text-center">
                                <span class="text-xs font-semibold tabular-nums text-neutral-700">{{ $paket->eksemplars_count }}</span>
                            </td>

                            <td class="px-4 py-3.5 text-center">
                                <span class="text-xs font-semibold tabular-nums text-neutral-700">{{ $paket->eksemplars_sum_stok ?? 0 }}</span>
                            </td>

                            <td class="px-4 py-3.5 text-center">
                                @if ($paket->is_aktif)
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-success-50 text-success-700">Aktif</span>
                                @else
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-neutral-100 text-neutral-500">Nonaktif</span>
                                @endif
                            </td>

                            <td class="px-4 py-3.5 text-center">
                                <span class="text-xs text-neutral-400">{{ $paket->created_at->format('d M Y') }}</span>
                            </td>

                            <td class="px-4 py-3.5">
                                <div class="flex items-center justify-center gap-1.5">

                                    @if ($paket->is_aktif)
                                        <form method="POST" action="{{ route('admin.paket.nonaktifkan', $paket) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-warning-300 hover:text-warning-600 hover:bg-warning-50 transition-colors">
                                                Nonaktifkan
                                            </button>
                                        </form>
                                    @else
                                        <button type="button"
                                                onclick="bukaModalAktifkanPaket({{ json_encode(['id' => $paket->id, 'nama' => $paket->nama, 'url' => route('admin.paket.aktifkan', $paket)]) }})"
                                                class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-success-300 hover:text-success-600 hover:bg-success-50 transition-colors">
                                            Aktifkan
                                        </button>
                                    @endif

                                    <button type="button"
                                        onclick="bukaModalEditPaket({{ json_encode([
                                            'id'        => $paket->id,
                                            'nama'      => $paket->nama,
                                            'lokasi_id' => $paket->lokasi_id,
                                            'url'       => route('admin.paket.update', $paket),
                                        ]) }})"
                                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-warning-300 hover:text-warning-600 hover:bg-warning-50 transition-colors">
                                        <x-icons.edit/>
                                        <span>Edit</span>
                                    </button>

                                    <button type="button"
                                        onclick="bukaModalHapusPaket(
                                            '{{ route('admin.paket.destroy', $paket) }}',
                                            '{{ addslashes($paket->nama) }}',
                                            {{ $paket->eksemplars_count }}
                                        )"
                                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-danger-300 hover:text-danger-600 hover:bg-danger-50 transition-colors">
                                        <x-icons.delete/>
                                        <span>Hapus</span>
                                    </button>

                                    <a href="{{ route('admin.paket.pemindahan.index', $paket) }}"
                                       class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-primary-300 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                        Riwayat
                                    </a>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-10 h-10 rounded-xl bg-neutral-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-neutral-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 16V8a2 2 0 0 0-1-1.73L13 2.27a2 2 0 0 0-2 0L4 6.27A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-neutral-500">Belum ada paket</p>
                                    <p class="text-xs text-neutral-400">Buat paket baru untuk mengelola rotasi buku</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pakets->hasPages())
            <div class="px-5 py-3.5 bg-neutral-50 border-t border-neutral-100 flex items-center justify-between gap-4 flex-wrap">
                <p class="text-xs text-neutral-400">
                    Menampilkan
                    <span class="font-semibold text-neutral-600">{{ $pakets->firstItem() }}</span>–<span class="font-semibold text-neutral-600">{{ $pakets->lastItem() }}</span>
                    dari <span class="font-semibold text-neutral-600">{{ $pakets->total() }}</span> paket
                </p>
                <div class="flex items-center gap-1">
                    @if ($pakets->onFirstPage())
                        <span class="px-3 py-1.5 rounded-lg text-xs text-neutral-300 border border-neutral-100 cursor-not-allowed">← Prev</span>
                    @else
                        <a href="{{ $pakets->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs text-primary-600 border border-neutral-200 hover:bg-primary-50 transition-colors">← Prev</a>
                    @endif
                    @foreach ($pakets->getUrlRange(1, $pakets->lastPage()) as $page => $url)
                        @if ($page == $pakets->currentPage())
                            <span class="px-3 py-1.5 rounded-lg text-xs bg-primary-600 text-white font-semibold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-1.5 rounded-lg text-xs text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">{{ $page }}</a>
                        @endif
                    @endforeach
                    @if ($pakets->hasMorePages())
                        <a href="{{ $pakets->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs text-primary-600 border border-neutral-200 hover:bg-primary-50 transition-colors">Next →</a>
                    @else
                        <span class="px-3 py-1.5 rounded-lg text-xs text-neutral-300 border border-neutral-100 cursor-not-allowed">Next →</span>
                    @endif
                </div>
            </div>
        @endif
    </div>

</div>

@include('admin.paket.create')
@include('admin.paket.edit')
@include('admin.paket.aktifkan')
@include('admin.paket.destroy')

@push('scripts')
<script>
function bukaModalBuatPaket() {
    const el = document.getElementById('modalBuatPaket');
    el.classList.remove('hidden'); el.classList.add('flex');
    document.body.style.overflow = 'hidden';
    setTimeout(() => document.getElementById('namaPaketBaru')?.focus(), 50);
}
function tutupModalBuatPaket() {
    document.getElementById('modalBuatPaket').classList.add('hidden');
    document.getElementById('modalBuatPaket').classList.remove('flex');
    document.body.style.overflow = '';
}

function bukaModalEditPaket(data) {
    document.getElementById('formEditPaket').action  = data.url;
    document.getElementById('namaEditPaket').value   = data.nama;
    document.getElementById('lokasiEditPaket').value = data.lokasi_id ?? '';
    const el = document.getElementById('modalEditPaket');
    el.classList.remove('hidden'); el.classList.add('flex');
    document.body.style.overflow = 'hidden';
    setTimeout(() => document.getElementById('namaEditPaket')?.focus(), 50);
}
function tutupModalEditPaket() {
    document.getElementById('modalEditPaket').classList.add('hidden');
    document.getElementById('modalEditPaket').classList.remove('flex');
    document.body.style.overflow = '';
}

function bukaModalAktifkanPaket(data) {
    document.getElementById('formAktifkanPaket').action      = data.url;
    document.getElementById('aktifkanPaketNama').textContent  = data.nama;
    document.getElementById('aktifkanLokasiId').value         = '';
    const el = document.getElementById('modalAktifkanPaket');
    el.classList.remove('hidden'); el.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function tutupModalAktifkanPaket() {
    document.getElementById('modalAktifkanPaket').classList.add('hidden');
    document.getElementById('modalAktifkanPaket').classList.remove('flex');
    document.body.style.overflow = '';
}

function bukaModalHapusPaket(action, nama, jumlahEksemplar) {
    document.getElementById('formHapusPaket').action = action;
    const desc = document.getElementById('hapusPaketDesc');
    const btn  = document.getElementById('btnHapusPaket');
    if (jumlahEksemplar > 0) {
        desc.innerHTML = `Paket <strong class="text-neutral-600">${nama}</strong> masih memiliki <strong class="text-danger-600">${jumlahEksemplar} eksemplar</strong>. Lepas semua buku dari paket sebelum menghapus.`;
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        desc.innerHTML = `Paket <strong class="text-neutral-600">${nama}</strong> akan dihapus permanen dan tidak bisa dikembalikan.`;
        btn.disabled = false;
        btn.classList.remove('opacity-50', 'cursor-not-allowed');
    }
    const el = document.getElementById('modalHapusPaket');
    el.classList.remove('hidden'); el.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function tutupModalHapusPaket() {
    document.getElementById('modalHapusPaket').classList.add('hidden');
    document.getElementById('modalHapusPaket').classList.remove('flex');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        tutupModalBuatPaket();
        tutupModalEditPaket();
        tutupModalAktifkanPaket();
        tutupModalHapusPaket();
    }
});
</script>
@endpush
@endsection