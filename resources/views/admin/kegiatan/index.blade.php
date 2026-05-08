@extends('layouts.admin')
@section('title', 'Kegiatan')
@section('page-title', 'Kegiatan')
@section('page-subtitle', 'Kelola rencana kegiatan perpustakaan')

@section('content')
<div class="flex flex-col gap-4">

    <x-admin.page-header
        title="Kegiatan"
        :subtitle="$kegiatans->total() . ' kegiatan terdaftar'"
        icon="calendar"
        button-onclick="bukaModalKegiatan()"
        route-label="Tambah Kegiatan"
        placeholder="Cari nama kegiatan, deskripsi..."
        search-id="searchInput"
        :stats="[
            ['label' => 'Total',      'value' => $kegiatans->total(),                                              'color' => 'text-neutral-800'],
            ['label' => 'Akan Datang','value' => $kegiatans->getCollection()->where('status','akan_berlangsung')->count(), 'color' => 'text-blue-600'],
            ['label' => 'Berlangsung','value' => $kegiatans->getCollection()->where('status','sedang_berlangsung')->count(),'color' => 'text-yellow-600'],
            ['label' => 'Selesai',    'value' => $kegiatans->getCollection()->where('status','selesai')->count(),           'color' => 'text-green-600'],
        ]"
    />

    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Tanggal</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Nama Kegiatan</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Deskripsi</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Status</th>
                        <th class="text-right text-xs font-medium text-neutral-400 px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50" id="tableBody">
                    @forelse ($kegiatans as $kegiatan)
                        <tr class="hover:bg-neutral-50 transition-colors">

                            {{-- Tanggal --}}
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <p class="text-xs font-semibold text-neutral-800">
                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y') }}
                                    </p>
                                    @if ($kegiatan->tanggal_selesai && $kegiatan->tanggal_selesai != $kegiatan->tanggal_mulai)
                                        <p class="text-[0.68rem] text-neutral-400">
                                            s/d {{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('d M Y') }}
                                        </p>
                                    @endif
                                </div>
                            </td>

                            {{-- Nama Kegiatan --}}
                            <td class="px-5 py-3.5">
                                <p class="text-xs font-semibold text-neutral-800">{{ $kegiatan->nama_kegiatan }}</p>
                            </td>

                            {{-- Deskripsi --}}
                            <td class="px-5 py-3.5">
                                <p class="text-xs text-neutral-500 max-w-[260px] truncate">
                                    {{ $kegiatan->deskripsi ?? '-' }}
                                </p>
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-3.5">
                                @php
                                    $statusMap = [
                                        'akan_berlangsung'  => ['label' => 'Akan Berlangsung', 'class' => 'bg-blue-50 text-blue-600',   'dot' => 'bg-blue-400'],
                                        'sedang_berlangsung'=> ['label' => 'Sedang Berlangsung','class' => 'bg-yellow-50 text-yellow-600','dot' => 'bg-yellow-400'],
                                        'selesai'           => ['label' => 'Selesai',           'class' => 'bg-green-50 text-green-600', 'dot' => 'bg-green-400'],
                                    ];
                                    $st = $statusMap[$kegiatan->status] ?? ['label' => $kegiatan->status, 'class' => 'bg-neutral-100 text-neutral-500', 'dot' => 'bg-neutral-400'];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 text-[0.68rem] font-medium px-2 py-0.5 rounded-full {{ $st['class'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $st['dot'] }}
                                        {{ $kegiatan->status === 'sedang_berlangsung' ? 'animate-pulse' : '' }}">
                                    </span>
                                    {{ $st['label'] }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button
                                        onclick="bukaModalEditKegiatan({{ $kegiatan->id }})"
                                        class="p-1.5 rounded-lg text-neutral-400 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </button>
                                    <form method="POST" action="{{ route('admin.kegiatan.destroy', $kegiatan) }}"
                                          onsubmit="return confirm('Hapus kegiatan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-neutral-400 hover:text-danger-600 hover:bg-danger-50 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                                <path d="M10 11v6"/><path d="M14 11v6"/>
                                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-10 h-10 rounded-xl bg-neutral-100 flex items-center justify-center">
                                        <x-icons.calendar class="w-5 h-5 text-neutral-400"/>
                                    </div>
                                    <p class="text-sm font-medium text-neutral-500">Belum ada kegiatan</p>
                                    <p class="text-xs text-neutral-400">Tambah kegiatan terlebih dahulu</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($kegiatans->hasPages())
            <div class="px-5 py-3 bg-neutral-50 border-t border-neutral-100">
                {{ $kegiatans->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>

{{-- Buka modal otomatis jika validasi gagal --}}
@if ($errors->any())
    <script>document.addEventListener('DOMContentLoaded', bukaModalKegiatan);</script>
@endif

@include('admin.kegiatan.create')
@endsection