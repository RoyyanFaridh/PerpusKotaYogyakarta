@extends('layouts.admin')
@section('title', 'Buku Perpustakaan')
@section('page-title', 'Buku Perpustakaan')
@section('page-subtitle', 'Kelola koleksi buku perpustakaan')

@section('content')
<div class="flex flex-col gap-4">

    {{-- Header + Tambah --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>
        <div class="flex items-center justify-between px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-primary-50 text-primary-700 flex items-center justify-center shrink-0">
                    <x-icons.book class="w-4.5 h-4.5"/>
                </div>
                <div>
                    <p class="text-sm font-medium text-neutral-700">Total Koleksi</p>
                    <p class="text-xs text-neutral-400">{{ $books->total() }} buku terdaftar</p>
                </div>
            </div>
            <a href="{{ route('admin.buku-perpus.create') }}"
               class="flex items-center gap-2 text-xs font-medium px-3.5 py-2 rounded-lg bg-primary text-white hover:bg-primary-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Buku
            </a>
        </div>
    </div>

    {{-- Filter & Search --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>
        <div class="px-5 py-4 flex flex-col sm:flex-row gap-3">
            {{-- Search --}}
            <div class="relative flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-neutral-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari judul, pengarang, ISBN..."
                    onchange="this.form.submit()"
                    form="filter-form"
                    class="w-full pl-9 pr-4 py-2 text-xs rounded-lg border border-neutral-200 text-neutral-700 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"
                />
            </div>

            <form id="filter-form" method="GET" action="{{ route('admin.buku-perpus.index') }}" class="flex gap-2">
                <input type="hidden" name="search" value="{{ request('search') }}">

                {{-- Filter Kategori --}}
                <select name="kategori" onchange="this.form.submit()"
                    class="text-xs px-3 py-2 rounded-lg border border-neutral-200 text-neutral-600 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition bg-white">
                    <option value="">Semua Kategori</option>
                    @foreach (['Novel', 'Sains', 'Sejarah', 'Teknologi', 'Anak-anak', 'Lainnya'] as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') === $kat ? 'selected' : '' }}>
                            {{ $kat }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter Stok --}}
                <select name="stok" onchange="this.form.submit()"
                    class="text-xs px-3 py-2 rounded-lg border border-neutral-200 text-neutral-600 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition bg-white">
                    <option value="">Semua Stok</option>
                    <option value="tersedia" {{ request('stok') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="habis"    {{ request('stok') === 'habis'    ? 'selected' : '' }}>Habis</option>
                </select>

                {{-- Reset --}}
                @if (request()->hasAny(['search', 'kategori', 'stok']))
                    <a href="{{ route('admin.buku-perpus.index') }}"
                       class="flex items-center text-xs px-3 py-2 rounded-lg border border-neutral-200 text-neutral-500 hover:bg-neutral-50 transition-colors whitespace-nowrap">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Judul</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Pengarang</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">ISBN</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Kategori</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Stok</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Lokasi</th>
                        <th class="text-right text-xs font-medium text-neutral-400 px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50">
                    @forelse ($books as $book)
                        <tr class="hover:bg-neutral-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <p class="text-xs font-semibold text-neutral-800 max-w-[200px] truncate">{{ $book->judul }}</p>
                                <p class="text-[0.68rem] text-neutral-400 mt-0.5">{{ $book->tahun_terbit ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-3.5 text-xs text-neutral-600 whitespace-nowrap">
                                {{ $book->pengarang }}
                            </td>
                            <td class="px-5 py-3.5 text-xs font-mono text-neutral-500">
                                {{ $book->isbn ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5">
                                @if ($book->kategori)
                                    <span class="text-[0.68rem] font-medium px-2 py-0.5 rounded-full bg-primary-50 text-primary-700">
                                        {{ $book->kategori }}
                                    </span>
                                @else
                                    <span class="text-[0.68rem] text-neutral-400">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                @if ($book->stok > 0)
                                    <span class="text-[0.68rem] font-medium px-2 py-0.5 rounded-full bg-success-50 text-success-700">
                                        {{ $book->stok }} tersedia
                                    </span>
                                @else
                                    <span class="text-[0.68rem] font-medium px-2 py-0.5 rounded-full bg-danger-50 text-danger-700">
                                        Habis
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-xs text-neutral-500 whitespace-nowrap">
                                {{ $book->lokasi?->nama ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.buku-perpus.edit', $book) }}"
                                       class="p-1.5 rounded-lg text-neutral-400 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.buku-perpus.destroy', $book) }}"
                                          onsubmit="return confirm('Hapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-1.5 rounded-lg text-neutral-400 hover:text-danger-600 hover:bg-danger-50 transition-colors">
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
                            <td colspan="7" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-10 h-10 rounded-xl bg-neutral-100 flex items-center justify-center">
                                        <x-icons.book class="w-5 h-5 text-neutral-400"/>
                                    </div>
                                    <p class="text-sm font-medium text-neutral-500">Belum ada buku</p>
                                    <p class="text-xs text-neutral-400">Tambah buku perpustakaan terlebih dahulu</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($books->hasPages())
            <div class="px-5 py-3 bg-neutral-50 border-t border-neutral-100">
                {{ $books->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>
@endsection