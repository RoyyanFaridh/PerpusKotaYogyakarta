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
            ['label' => 'Total',       'value' => $kegiatans->total(), 'color' => 'text-neutral-800'],
            ['label' => 'Akan Datang', 'value' => $kegiatans->getCollection()->filter(fn($k) => $k->status_otomatis === 'akan_berlangsung')->count(),  'color' => 'text-blue-600'],
            ['label' => 'Berlangsung', 'value' => $kegiatans->getCollection()->filter(fn($k) => $k->status_otomatis === 'sedang_berlangsung')->count(), 'color' => 'text-yellow-600'],
            ['label' => 'Selesai',     'value' => $kegiatans->getCollection()->filter(fn($k) => $k->status_otomatis === 'selesai')->count(),            'color' => 'text-green-600'],
        ]"
    />

    @if (session('success'))
        <div class="flex items-center gap-2.5 px-5 py-3 bg-success-50 border border-success-100 rounded-xl text-success-700 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left text-xs font-semibold text-neutral-500 px-5 py-3">Tanggal & Jam</th>
                        <th class="text-left text-xs font-semibold text-neutral-500 px-4 py-3">Nama Kegiatan</th>
                        <th class="text-left text-xs font-semibold text-neutral-500 px-4 py-3">Lokasi</th>
                        <th class="text-left text-xs font-semibold text-neutral-500 px-4 py-3">Deskripsi</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Status</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50" id="tableBody">
                    @forelse ($kegiatans as $kegiatan)
                        @php $statusOtomatis = $kegiatan->status_otomatis; @endphp
                        <tr class="hover:bg-neutral-50 transition-colors {{ $statusOtomatis === 'selesai' ? 'opacity-50' : '' }}">

                            {{-- Tanggal & Jam --}}
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <p class="text-xs font-semibold text-neutral-800">
                                    {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y') }}
                                    @if ($kegiatan->tanggal_selesai && $kegiatan->tanggal_selesai->ne($kegiatan->tanggal_mulai))
                                        <span class="text-neutral-400 font-normal">
                                            – {{ $kegiatan->tanggal_selesai->format('d M Y') }}
                                        </span>
                                    @endif
                                </p>
                                @if ($kegiatan->jam_pelaksanaan)
                                    <p class="text-[0.68rem] text-neutral-400 flex items-center gap-1 mt-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($kegiatan->jam_pelaksanaan)->format('H:i') }}
                                        @if ($kegiatan->jam_selesai)
                                            – {{ \Carbon\Carbon::parse($kegiatan->jam_selesai)->format('H:i') }}
                                        @endif
                                        WIB
                                    </p>
                                @endif
                            </td>

                            {{-- Nama --}}
                            <td class="px-4 py-3.5">
                                <p class="text-xs font-semibold text-neutral-800">{{ $kegiatan->nama_kegiatan }}</p>
                            </td>

                            {{-- Lokasi --}}
                            <td class="px-4 py-3.5">
                                @if ($kegiatan->lokasi)
                                    <span class="text-xs text-neutral-600">{{ $kegiatan->lokasi->nama_lokasi }}</span>
                                @else
                                    <span class="text-xs text-neutral-300">—</span>
                                @endif
                            </td>

                            {{-- Deskripsi --}}
                            <td class="px-4 py-3.5 max-w-50">
                                <p class="text-xs text-neutral-500 truncate">{{ $kegiatan->deskripsi ?? '—' }}</p>
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-3.5 text-center">
                                @php
                                    $statusMap = [
                                        'akan_berlangsung'   => ['label' => 'Akan Berlangsung',  'class' => 'bg-blue-50 text-blue-600',     'dot' => 'bg-blue-400'],
                                        'sedang_berlangsung' => ['label' => 'Sedang Berlangsung', 'class' => 'bg-yellow-50 text-yellow-600', 'dot' => 'bg-yellow-400'],
                                        'selesai'            => ['label' => 'Selesai',            'class' => 'bg-neutral-100 text-neutral-400', 'dot' => 'bg-neutral-300'],
                                    ];
                                    $st = $statusMap[$statusOtomatis];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 text-[0.68rem] font-medium px-2 py-0.5 rounded-full {{ $st['class'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $st['dot'] }}
                                        {{ $statusOtomatis === 'sedang_berlangsung' ? 'animate-pulse' : '' }}">
                                    </span>
                                    {{ $st['label'] }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-4 py-3.5">
                                <div class="flex items-center justify-center gap-1.5">

                                    {{-- Export Buku --}}
                                    @if ($kegiatan->pakets->isNotEmpty())
                                        <a href="{{ route('admin.kegiatan.export-buku', $kegiatan) }}"
                                        class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-success-300 hover:text-success-600 hover:bg-success-50 transition-colors">
                                            <x-icons.download/>
                                            <span>Export</span>
                                        </a>
                                    @endif

                                    <button type="button"
                                            onclick="bukaModalEditKegiatan({{ $kegiatan->id }})"
                                            class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-warning-300 hover:text-warning-600 hover:bg-warning-50 transition-colors">
                                        <x-icons.edit/>
                                        <span>Edit</span>
                                    </button>

                                    <button type="button"
                                            onclick="bukaModalHapusKegiatan(
                                                '{{ route('admin.kegiatan.destroy', $kegiatan) }}',
                                                '{{ addslashes($kegiatan->nama_kegiatan) }}'
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
                            <td colspan="6" class="px-5 py-12 text-center">
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

@include('admin.kegiatan.create')
@include('admin.kegiatan.edit')
@include('admin.kegiatan.destroy')
@endsection