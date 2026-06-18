@props(['paket'])

@php
$isAktif = $paket->is_aktif;
@endphp

<div class="rounded-xl border border-neutral-200 bg-white overflow-hidden"
     x-data="{ open: true }">

    {{-- Header Paket --}}
    <div class="w-full flex items-center justify-between gap-2 px-5 py-3.5 bg-neutral-50 hover:bg-neutral-100 transition-colors border-b border-neutral-200">
        <button type="button"
                @click="open = !open"
                class="flex items-center gap-3 flex-1 min-w-0 text-left">
            <div class="w-8 h-8 rounded-lg {{ $isAktif ? 'bg-warning-50 text-warning-700' : 'bg-neutral-100 text-neutral-400' }} flex items-center justify-center shrink-0">
                <x-icons.package class="w-4 h-4"/>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-neutral-800 leading-tight truncate">{{ $paket->nama }}</p>
                <p class="text-xs text-neutral-400 mt-0.5">
                    {{ $paket->lokasi?->nama_lokasi ?? 'Belum ada lokasi' }}
                    · {{ $paket->eksemplars_count }} eksemplar
                    · {{ $paket->eksemplars_sum_stok ?? 0 }} stok
                </p>
            </div>
        </button>

        <div class="flex items-center gap-2 shrink-0">
            <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $isAktif ? 'bg-warning-50 text-warning-700' : 'bg-neutral-100 text-neutral-500' }}">
                {{ $isAktif ? 'Aktif' : 'Tidak Aktif' }}
            </span>

            <a href="{{ route('admin.buku.export', ['paket' => $paket->id]) }}"
               title="Export buku di paket ini"
               class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-600 border border-neutral-200 bg-white hover:bg-neutral-50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                <span class="hidden sm:inline">Export</span>
            </a>

            <button type="button" @click="open = !open" aria-label="Buka/tutup daftar buku">
                <svg class="w-4 h-4 text-neutral-400 transition-transform"
                     :class="open ? 'rotate-180' : ''"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <polyline points="6 9 12 15 18 9"/>
                </svg>
            </button>
        </div>
    </div>

    <div x-show="open" x-collapse>
        @if ($paket->eksemplars->isEmpty())
            <div class="px-5 py-8 text-center">
                <p class="text-xs text-neutral-400">Belum ada buku dalam paket ini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-150 text-sm">
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
                        @foreach ($paket->eksemplars as $eksemplar)
                            <x-admin.buku.eksemplar-row :eksemplar="$eksemplar"/>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>