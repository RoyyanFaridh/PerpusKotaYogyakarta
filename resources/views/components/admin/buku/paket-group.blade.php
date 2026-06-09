@props(['paket'])

@php
$isAktif = $paket->is_aktif;
@endphp

<div class="rounded-xl border border-neutral-200 bg-white overflow-hidden"
     x-data="{ open: true }">

    {{-- Header Paket --}}
    <button type="button"
            @click="open = !open"
            class="w-full flex items-center justify-between px-5 py-3.5 bg-neutral-50 hover:bg-neutral-100 transition-colors border-b border-neutral-200">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg {{ $isAktif ? 'bg-warning-50 text-warning-700' : 'bg-neutral-100 text-neutral-400' }} flex items-center justify-center shrink-0">
                <x-icons.package class="w-4 h-4"/>
            </div>
            <div class="text-left">
                <p class="text-sm font-semibold text-neutral-800 leading-tight">{{ $paket->nama }}</p>
                <p class="text-xs text-neutral-400 mt-0.5">
                    {{ $paket->lokasi?->nama_lokasi ?? 'Belum ada lokasi' }}
                    · {{ $paket->eksemplars_count }} eksemplar
                    · {{ $paket->eksemplars_sum_stok ?? 0 }} stok
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $isAktif ? 'bg-warning-50 text-warning-700' : 'bg-neutral-100 text-neutral-500' }}">
                {{ $isAktif ? 'Aktif' : 'Tidak Aktif' }}
            </span>
            <svg class="w-4 h-4 text-neutral-400 transition-transform"
                 :class="open ? 'rotate-180' : ''"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="6 9 12 15 18 9"/>
            </svg>
        </div>
    </button>

    <div x-show="open" x-collapse>
        @if ($paket->eksemplars->isEmpty())
            <div class="px-5 py-8 text-center">
                <p class="text-xs text-neutral-400">Belum ada buku dalam paket ini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[600px] text-sm">
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