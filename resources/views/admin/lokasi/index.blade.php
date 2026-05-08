@extends('layouts.admin')
@section('title', 'Lokasi')
@section('page-title', 'Lokasi')
@section('page-subtitle', 'Kelola data lokasi perpustakaan')

@section('content')
<div class="flex flex-col gap-4">

    <x-admin.page-header
        title="Lokasi"
        :subtitle="$lokasis->total() . ' lokasi terdaftar'"
        icon="location"
        button-onclick="bukaModalLokasi()"
        route-label="Tambah Lokasi"
        placeholder="Cari nama lokasi, alamat..."
        search-id="searchInput"
        :stats="[
            ['label' => 'Total', 'value' => $lokasis->total(), 'color' => 'text-neutral-800'],
        ]"
    />

    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Nama Lokasi</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Alamat</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">No. Telepon</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Penanggung Jawab</th>
                        <th class="text-right text-xs font-medium text-neutral-400 px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50" id="tableBody">
                    @forelse ($lokasis as $lokasi)
                        <tr class="hover:bg-neutral-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <p class="text-xs font-semibold text-neutral-800">{{ $lokasi->nama_lokasi }}</p>
                            </td>
                            <td class="px-5 py-3.5">
                                <p class="text-xs text-neutral-500 max-w-[200px] truncate">{{ $lokasi->alamat }}</p>
                            </td>
                            <td class="px-5 py-3.5 text-xs text-neutral-500 font-mono">
                                {{ $lokasi->no_telp ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5">
                                @if ($lokasi->user)
                                    <span class="text-[0.68rem] font-medium px-2 py-0.5 rounded-full bg-primary-50 text-primary-700">
                                        {{ $lokasi->user->nama }}
                                    </span>
                                @else
                                    <span class="text-[0.68rem] text-neutral-400">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-xs text-neutral-400">
                                {{ $lokasi->created_at->format('d M Y') }}
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.lokasi.edit', $lokasi) }}"
                                        class="p-1.5 rounded-lg text-neutral-400 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.lokasi.destroy', $lokasi) }}"
                                          onsubmit="return confirm('Hapus lokasi ini?')">
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
                            <td colspan="6" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-10 h-10 rounded-xl bg-neutral-100 flex items-center justify-center">
                                        <x-icons.location class="w-5 h-5 text-neutral-400"/>
                                    </div>
                                    <p class="text-sm font-medium text-neutral-500">Belum ada lokasi</p>
                                    <p class="text-xs text-neutral-400">Tambah lokasi terlebih dahulu</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($lokasis->hasPages())
            <div class="px-5 py-3 bg-neutral-50 border-t border-neutral-100">
                {{ $lokasis->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>

{{-- Buka modal otomatis jika validasi gagal --}}
@if ($errors->any())
    <script>document.addEventListener('DOMContentLoaded', bukaModalLokasi);</script>
@endif

@include('admin.lokasi.create')
@endsection