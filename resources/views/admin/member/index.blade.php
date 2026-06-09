@extends('layouts.admin')
@section('title', 'Member')
@section('page-title', 'Member')
@section('page-subtitle', 'Kelola data member perpustakaan')

@section('content')
<div class="flex flex-col gap-4">

    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="flex items-center justify-between gap-4 px-5 pt-5 pb-4 border-b border-neutral-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-700 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-neutral-800 leading-tight">Daftar Member</p>
                    <p class="text-xs text-neutral-400 leading-tight">{{ $members->total() }} member terdaftar</p>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('admin.member.export') }}"
                title="Export Excel"
                class="flex items-center gap-1.5 px-2.5 py-2 sm:px-3.5 rounded-lg text-xs font-medium text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">
                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    <span class="hidden sm:inline">Export Excel</span>
                </a>
                <button type="button"
                        onclick="bukaModalMember()"
                        title="Tambah Member"
                        class="flex items-center gap-1.5 px-2.5 py-2 sm:px-3.5 rounded-lg text-xs font-semibold text-white bg-primary-600 hover:bg-primary-700 transition-colors">
                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    <span class="hidden sm:inline">Tambah Member</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 border-b border-neutral-100">
            <div class="px-5 py-3.5 flex flex-col gap-0.5">
                <span class="text-xs text-neutral-400 font-medium">Total Member</span>
                <span class="text-2xl font-semibold tabular-nums text-neutral-800">{{ $totalMember }}</span>
            </div>
        </div>

        <div class="flex items-center gap-3 px-5 py-3.5">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input id="searchInput" type="text"
                       placeholder="Cari nama atau nomor telepon..."
                       class="w-full pl-9 pr-4 py-2 text-sm text-neutral-700 bg-neutral-50 border border-neutral-200 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
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

    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left   text-xs font-semibold text-neutral-500 px-5 py-3">Nama</th>
                        <th class="text-left   text-xs font-semibold text-neutral-500 px-4 py-3">Email</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">No. Telepon</th>
                        <th class="text-left   text-xs font-semibold text-neutral-500 px-4 py-3">Alamat</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse ($members as $member)
                        <tr class="hover:bg-neutral-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <p class="text-xs font-semibold text-neutral-800">{{ $member->nama }}</p>
                            </td>
                            <td class="px-4 py-3.5 text-xs text-neutral-500">
                                {{ $member->email ?? '—' }}
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <span class="text-xs font-mono font-semibold text-neutral-800">{{ $member->no_telp }}</span>
                            </td>
                            <td class="px-4 py-3.5 max-w-xs">
                                <p class="text-xs text-neutral-500 whitespace-normal leading-relaxed">
                                    {{ $member->alamat ?? '—' }}
                                </p>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="button"
                                            onclick="bukaModalEdit({{ json_encode([
                                                'id'      => $member->id,
                                                'no_telp' => $member->no_telp,
                                                'nama'    => $member->nama,
                                                'email'   => $member->email,
                                                'alamat'  => $member->alamat,
                                            ]) }})"
                                            class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-warning-300 hover:text-warning-600 hover:bg-warning-50 transition-colors">
                                        <x-icons.edit/>
                                        <span>Edit</span>
                                    </button>
                                    <button type="button"
                                            onclick="bukaModalHapusMember(
                                                '{{ route('admin.member.destroy', $member) }}',
                                                '{{ addslashes($member->nama) }}'
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
                            <td colspan="5" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-10 h-10 rounded-2xl bg-neutral-100 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-neutral-400"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-neutral-500">Belum ada member</p>
                                    <p class="text-xs text-neutral-400">Tambah member terlebih dahulu</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($members->hasPages())
            <div class="px-5 py-3 bg-neutral-50 border-t border-neutral-100">
                {{ $members->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>

@include('admin.member.create')
@include('admin.member.edit')
@include('admin.member.destroy')

@push('scripts')
<script>
(function () {
    const searchInput = document.getElementById('searchInput');
    let debounce;
    searchInput?.addEventListener('input', function () {
        clearTimeout(debounce);
        const q = this.value.trim();
        debounce = setTimeout(() => {
            const params = new URLSearchParams(window.location.search);
            if (q) params.set('search', q);
            else params.delete('search');
            params.delete('page');
            window.location.href = `${window.location.pathname}?${params.toString()}`;
        }, 400);
    });

    const params = new URLSearchParams(window.location.search);
    if (searchInput && params.get('search')) {
        searchInput.value = params.get('search');
    }
})();
</script>
@endpush
@endsection