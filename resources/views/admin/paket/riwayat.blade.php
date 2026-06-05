@extends('layouts.admin')
@section('title', 'Riwayat Pemindahan Paket')
@section('page-title', 'Riwayat Pemindahan')
@section('page-subtitle', 'Catatan perpindahan lokasi paket')

@section('content')
<div class="flex flex-col gap-5">

    {{-- Header --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>
        <div class="flex items-center justify-between gap-4 px-5 pt-5 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-neutral-800 leading-tight">{{ $paket->nama }}</p>
                    <p class="text-xs text-neutral-400 leading-tight">Riwayat pemindahan lokasi</p>
                </div>
            </div>
            <a href="{{ route('admin.paket.index') }}"
               class="flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">
                ← Kembali
            </a>
        </div>
    </div>

    {{-- Tabel Riwayat --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left   text-xs font-semibold text-neutral-500 px-5 py-3">Dari</th>
                        <th class="text-left   text-xs font-semibold text-neutral-500 px-4 py-3">Ke</th>
                        <th class="text-left   text-xs font-semibold text-neutral-500 px-4 py-3">Catatan</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Oleh</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50">
                    @forelse ($riwayat as $item)
                        <tr class="hover:bg-neutral-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <span class="text-xs text-neutral-500">
                                    {{ $item->lokasiAsal?->nama_lokasi ?? '—' }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="text-xs font-medium text-neutral-700">
                                    {{ $item->lokasiTujuan?->nama_lokasi ?? '—' }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="text-xs text-neutral-400">{{ $item->catatan ?? '—' }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <span class="text-xs text-neutral-500">{{ $item->user?->nama ?? '—' }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <p class="text-xs font-medium text-neutral-700">{{ $item->dipindah_pada->format('d M Y') }}</p>
                                <p class="text-xs text-neutral-400 mt-0.5">{{ $item->dipindah_pada->format('H:i') }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-10 h-10 rounded-xl bg-neutral-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-neutral-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-neutral-500">Belum ada riwayat pemindahan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($riwayat->hasPages())
            <div class="px-5 py-3.5 bg-neutral-50 border-t border-neutral-100 flex items-center justify-between gap-4 flex-wrap">
                <p class="text-xs text-neutral-400">
                    Menampilkan
                    <span class="font-semibold text-neutral-600">{{ $riwayat->firstItem() }}</span>–<span class="font-semibold text-neutral-600">{{ $riwayat->lastItem() }}</span>
                    dari <span class="font-semibold text-neutral-600">{{ $riwayat->total() }}</span> riwayat
                </p>
                <div class="flex items-center gap-1">
                    @if ($riwayat->onFirstPage())
                        <span class="px-3 py-1.5 rounded-lg text-xs text-neutral-300 border border-neutral-100 cursor-not-allowed">← Prev</span>
                    @else
                        <a href="{{ $riwayat->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs text-primary-600 border border-neutral-200 hover:bg-primary-50 transition-colors">← Prev</a>
                    @endif
                    @foreach ($riwayat->getUrlRange(1, $riwayat->lastPage()) as $page => $url)
                        @if ($page == $riwayat->currentPage())
                            <span class="px-3 py-1.5 rounded-lg text-xs bg-primary-600 text-white font-semibold">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-1.5 rounded-lg text-xs text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">{{ $page }}</a>
                        @endif
                    @endforeach
                    @if ($riwayat->hasMorePages())
                        <a href="{{ $riwayat->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs text-primary-600 border border-neutral-200 hover:bg-primary-50 transition-colors">Next →</a>
                    @else
                        <span class="px-3 py-1.5 rounded-lg text-xs text-neutral-300 border border-neutral-100 cursor-not-allowed">Next →</span>
                    @endif
                </div>
            </div>
        @endif
    </div>

</div>
@endsection