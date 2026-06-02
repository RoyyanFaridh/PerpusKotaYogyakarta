@extends('layouts.admin')
@section('title', 'Manajemen Paket Buku')
@section('page-title', 'Paket Buku')
@section('page-subtitle', 'Kelola rotasi dan visibilitas paket buku')

@section('content')

<div class="flex flex-col gap-5">

    {{-- Page Header Card --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        {{-- Title row --}}
        <div class="flex items-center justify-between gap-4 px-5 pt-5 pb-4 border-b border-neutral-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-warning-50 text-warning-700 flex items-center justify-center shrink-0">
                    {{-- package icon --}}
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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

        {{-- Stats row --}}
        <div class="grid grid-cols-3 divide-x divide-neutral-100">
            @foreach ([
                ['label' => 'Total Paket',  'value' => $stats['total'],    'color' => 'text-neutral-800'],
                ['label' => 'Paket Aktif',  'value' => $stats['aktif'],    'color' => 'text-success-700'],
                ['label' => 'Total Buku',   'value' => $stats['total_buku'], 'color' => 'text-primary-700'],
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
            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="flex items-center gap-2.5 px-5 py-3 bg-danger-50 border border-danger-100 rounded-xl text-danger-700 text-sm font-medium">
            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Paket List --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left   text-xs font-semibold text-neutral-500 px-5 py-3">Nama Paket</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Jumlah Buku</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Status</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Dibuat</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50">
                    @forelse ($pakets as $paket)
                        <tr class="hover:bg-neutral-50 transition-colors">

                            {{-- Nama --}}
                            <td class="px-5 py-3.5">
                                <p class="text-xs font-semibold text-neutral-800 leading-snug">{{ $paket->nama }}</p>
                                <p class="text-xs text-neutral-400 mt-0.5">ID #{{ $paket->id }}</p>
                            </td>

                            {{-- Jumlah Buku --}}
                            <td class="px-4 py-3.5 text-center">
                                <span class="text-xs font-semibold tabular-nums text-neutral-700">
                                    {{ $paket->bukus_count ?? $paket->bukus->count() }}
                                </span>
                            </td>

                            {{-- Status aktif / tidak --}}
                            <td class="px-4 py-3.5 text-center">
                                @if ($paket->is_aktif)
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-success-50 text-success-700">Aktif</span>
                                @else
                                    <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-neutral-100 text-neutral-500">Nonaktif</span>
                                @endif
                            </td>

                            {{-- Tanggal --}}
                            <td class="px-4 py-3.5 text-center">
                                <span class="text-xs text-neutral-400">{{ $paket->created_at->format('d M Y') }}</span>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-4 py-3.5">
                                <div class="flex items-center justify-center gap-1.5">

                                    {{-- Toggle aktif/nonaktif --}}
                                    @if ($paket->is_aktif)
                                        <form method="POST" action="{{ route('admin.paket.nonaktifkan', $paket) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-warning-300 hover:text-warning-600 hover:bg-warning-50 transition-colors">
                                                Nonaktifkan
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.paket.aktifkan', $paket) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-success-300 hover:text-success-600 hover:bg-success-50 transition-colors">
                                                Aktifkan
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Edit nama --}}
                                    <button type="button"
                                        onclick="bukaModalEditPaket({{ json_encode(['id' => $paket->id, 'nama' => $paket->nama, 'url' => route('admin.paket.update', $paket)]) }})"
                                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-warning-300 hover:text-warning-600 hover:bg-warning-50 transition-colors">
                                        <x-icons.edit/>
                                        <span>Edit</span>
                                    </button>

                                    {{-- Hapus --}}
                                    <button type="button"
                                        onclick="bukaModalHapusPaket(
                                            '{{ route('admin.paket.destroy', $paket) }}',
                                            '{{ addslashes($paket->nama) }}',
                                            {{ $paket->bukus_count ?? $paket->bukus->count() }}
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
                            <td colspan="5" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-10 h-10 rounded-xl bg-neutral-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-neutral-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

{{-- Modal Buat Paket --}}
<div id="modalBuatPaket"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 backdrop-blur-sm p-4">
    <div class="absolute inset-0" onclick="tutupModalBuatPaket()"></div>
    <div class="relative z-10 w-full max-w-md rounded-2xl bg-white overflow-hidden shadow-xl">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>
        <div class="px-6 pt-6 pb-2 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-neutral-800">Buat Paket Baru</h2>
            <button type="button" onclick="tutupModalBuatPaket()"
                    class="w-7 h-7 flex items-center justify-center rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.paket.store') }}" class="px-6 pb-6 pt-4 flex flex-col gap-4">
            @csrf
            <div class="flex flex-col gap-1.5">
                <label for="namaPaketBaru" class="text-xs font-medium text-neutral-600">Nama Paket</label>
                <input id="namaPaketBaru" name="nama" type="text" required maxlength="255"
                       placeholder="Contoh: Paket Rotasi Juni 2025"
                       class="w-full px-3 py-2 text-sm text-neutral-700 bg-neutral-50 border border-neutral-200 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
            <div class="flex items-center gap-2 pt-1">
                <button type="button" onclick="tutupModalBuatPaket()"
                        class="flex-1 px-4 py-2 text-sm font-medium rounded-lg text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2 text-sm font-semibold rounded-lg bg-primary-600 text-white hover:bg-primary-700 transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit Nama Paket --}}
<div id="modalEditPaket"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 backdrop-blur-sm p-4">
    <div class="absolute inset-0" onclick="tutupModalEditPaket()"></div>
    <div class="relative z-10 w-full max-w-md rounded-2xl bg-white overflow-hidden shadow-xl">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-warning-400"></div>
        <div class="px-6 pt-6 pb-2 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-neutral-800">Edit Nama Paket</h2>
            <button type="button" onclick="tutupModalEditPaket()"
                    class="w-7 h-7 flex items-center justify-center rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="formEditPaket" method="POST" action="" class="px-6 pb-6 pt-4 flex flex-col gap-4">
            @csrf
            @method('PUT')
            <div class="flex flex-col gap-1.5">
                <label for="namaEditPaket" class="text-xs font-medium text-neutral-600">Nama Paket</label>
                <input id="namaEditPaket" name="nama" type="text" required maxlength="255"
                       class="w-full px-3 py-2 text-sm text-neutral-700 bg-neutral-50 border border-neutral-200 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
            <div class="flex items-center gap-2 pt-1">
                <button type="button" onclick="tutupModalEditPaket()"
                        class="flex-1 px-4 py-2 text-sm font-medium rounded-lg text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2 text-sm font-semibold rounded-lg bg-warning-500 text-white hover:bg-warning-600 transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Hapus Paket --}}
<div id="modalHapusPaket"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 backdrop-blur-sm p-4">
    <div class="absolute inset-0" onclick="tutupModalHapusPaket()"></div>
    <div class="relative z-10 w-full max-w-md rounded-2xl bg-white overflow-hidden shadow-xl">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-danger-400"></div>
        <div class="px-6 sm:px-8 pt-7 pb-6 flex flex-col items-center text-center gap-3">
            <div class="w-12 h-12 rounded-full bg-danger-50 border border-danger-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-danger-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    <path d="M10 11v6"/><path d="M14 11v6"/>
                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
            </div>
            <div>
                <h2 class="text-base font-semibold text-neutral-800">Hapus Paket?</h2>
                <p id="hapusPaketDesc" class="text-sm text-neutral-400 mt-1.5 leading-relaxed"></p>
            </div>
        </div>
        <div class="flex items-center gap-2 px-6 sm:px-8 pb-6">
            <button type="button" onclick="tutupModalHapusPaket()"
                    class="flex-1 px-4 py-2 text-sm font-medium rounded-lg text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 transition-colors">
                Batal
            </button>
            <form id="formHapusPaket" method="POST" action="" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full px-4 py-2 text-sm font-medium rounded-lg bg-danger-500 text-white hover:bg-danger-600 transition-colors">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function bukaModalBuatPaket() {
    const el = document.getElementById('modalBuatPaket');
    el.classList.remove('hidden');
    el.classList.add('flex');
    document.body.style.overflow = 'hidden';
    setTimeout(() => document.getElementById('namaPaketBaru')?.focus(), 50);
}
function tutupModalBuatPaket() {
    const el = document.getElementById('modalBuatPaket');
    el.classList.add('hidden');
    el.classList.remove('flex');
    document.body.style.overflow = '';
}

function bukaModalEditPaket(data) {
    document.getElementById('formEditPaket').action = data.url;
    document.getElementById('namaEditPaket').value  = data.nama;
    const el = document.getElementById('modalEditPaket');
    el.classList.remove('hidden');
    el.classList.add('flex');
    document.body.style.overflow = 'hidden';
    setTimeout(() => document.getElementById('namaEditPaket')?.focus(), 50);
}
function tutupModalEditPaket() {
    const el = document.getElementById('modalEditPaket');
    el.classList.add('hidden');
    el.classList.remove('flex');
    document.body.style.overflow = '';
}

function bukaModalHapusPaket(action, nama, jumlahBuku) {
    document.getElementById('formHapusPaket').action = action;
    const desc = document.getElementById('hapusPaketDesc');
    if (jumlahBuku > 0) {
        desc.innerHTML = `Paket <strong class="text-neutral-600">${nama}</strong> masih memiliki <strong class="text-danger-600">${jumlahBuku} buku</strong>. Lepas semua buku dari paket sebelum menghapus.`;
        document.querySelector('#formHapusPaket button[type="submit"]').disabled = true;
        document.querySelector('#formHapusPaket button[type="submit"]').classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        desc.innerHTML = `Paket <strong class="text-neutral-600">${nama}</strong> akan dihapus permanen dan tidak bisa dikembalikan.`;
        document.querySelector('#formHapusPaket button[type="submit"]').disabled = false;
        document.querySelector('#formHapusPaket button[type="submit"]').classList.remove('opacity-50', 'cursor-not-allowed');
    }
    const el = document.getElementById('modalHapusPaket');
    el.classList.remove('hidden');
    el.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function tutupModalHapusPaket() {
    const el = document.getElementById('modalHapusPaket');
    el.classList.add('hidden');
    el.classList.remove('flex');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        tutupModalBuatPaket();
        tutupModalEditPaket();
        tutupModalHapusPaket();
    }
});
</script>
@endpush
@endsection