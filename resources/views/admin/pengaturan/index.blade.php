@extends('layouts.admin')
@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')
@section('page-subtitle', 'Kelola akun dan sistem')

@section('content')
<div class="flex flex-col gap-4">

    @if (session('success'))
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-success-50 border border-success-200 text-success-700 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-danger-50 border border-danger-200 text-danger-700 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Backup Database --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>
        <div class="px-6 py-4 border-b border-neutral-100">
            <h2 class="text-sm font-semibold text-neutral-800">Backup Database</h2>
            <p class="text-xs text-neutral-400 mt-0.5">Unduh salinan data perpustakaan</p>
        </div>
        <div class="px-6 py-5 flex items-center justify-between">
            <div class="flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-neutral-400 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <p class="text-xs text-neutral-400">File backup diunduh dalam format <span class="font-mono">.sql</span>. Simpan di tempat yang aman.</p>
            </div>
            <a href="{{ route('admin.pengaturan.backup') }}"
               class="flex items-center gap-2 px-4 py-2 text-xs font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition shrink-0 ml-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Unduh Backup
            </a>
        </div>
    </div>

    {{-- Daftar User --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>
        <div class="px-6 py-4 border-b border-neutral-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-semibold text-neutral-800">Daftar User</h2>
                <p class="text-xs text-neutral-400 mt-0.5">Semua akun yang terdaftar di sistem</p>
            </div>
            <a href="{{ route('admin.pengaturan.create') }}"
               class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah User
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Nama</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Email</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Role</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Dibuat</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-t border-neutral-50 hover:bg-neutral-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center text-xs font-bold uppercase shrink-0">
                                        {{ substr($user->nama ?? '?', 0, 1) }}
                                    </div>
                                    <p class="text-xs font-semibold text-neutral-800">{{ $user->nama ?? '-' }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-xs text-neutral-600 text-center">{{ $user->email ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-center">
                                @if ($user->isSuperAdmin())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[0.68rem] font-medium bg-primary-50 text-primary-700 border border-primary-100">Superadmin</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[0.68rem] font-medium bg-neutral-100 text-neutral-600">Admin</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-xs text-neutral-400 text-center">{{ $user->created_at?->format('d M Y') ?? '-' }}</td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-center gap-1">
                                    @if ($user->id !== auth()->id())
                                        @if (!$user->isSuperAdmin())
                                            <button type="button"
                                                    onclick="togglePermission({{ $user->id }})"
                                                    id="btn-permission-{{ $user->id }}"
                                                    class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-primary-300 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                                Akses
                                            </button>
                                        @endif
                                        <a href="{{ route('admin.pengaturan.edit', $user) }}"
                                           class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-primary-300 hover:text-primary-600 hover:bg-primary-50 transition-colors"
                                           title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                            <span>Edit</span>
                                        </a>
                                        <a href="{{ route('admin.pengaturan.destroy', $user) }}"
                                           class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-danger-300 hover:text-danger-600 hover:bg-danger-50 transition-colors"
                                           title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                            <span>Hapus</span>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.pengaturan.edit', $user) }}"
                                           class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-primary-300 hover:text-primary-600 hover:bg-primary-50 transition-colors"
                                           title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                            <span>Edit</span>
                                        </a>
                                        <span class="text-[0.68rem] text-neutral-300 px-1">Anda</span>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Accordion Permission --}}
                        @if (!$user->isSuperAdmin())
                            <tr id="permission-row-{{ $user->id }}" class="hidden">
                                <td colspan="5" class="px-5 pb-4 pt-1">
                                    <div class="rounded-xl border border-neutral-200 bg-neutral-50 overflow-hidden">
                                        <div class="px-4 py-3 border-b border-neutral-200 flex items-center justify-between bg-white">
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-primary-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                                <p class="text-xs font-semibold text-neutral-700">Hak Akses — {{ $user->nama }}</p>
                                            </div>
                                            <button type="button" onclick="togglePermission({{ $user->id }})"
                                                    class="text-neutral-300 hover:text-neutral-500 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                            </button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.pengaturan.user.permissions', $user) }}" class="px-4 py-4">
                                            @csrf
                                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                                @foreach ($allPermissions as $modul => $permissions)
                                                    <div class="flex flex-col gap-2">
                                                        <p class="text-[0.68rem] font-semibold text-neutral-400 uppercase tracking-wide">{{ $modul }}</p>
                                                        <div class="flex flex-col gap-1">
                                                            @foreach ($permissions as $permission)
                                                                @php
                                                                    $label = match(true) {
                                                                        str_ends_with($permission, '.create') => 'Tambah',
                                                                        str_ends_with($permission, '.edit')   => 'Edit',
                                                                        str_ends_with($permission, '.delete') => 'Hapus',
                                                                        default => $permission,
                                                                    };
                                                                    $checked = in_array($permission, $user->getPermissionList());
                                                                @endphp
                                                                <label class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg bg-white border {{ $checked ? 'border-primary-200 text-primary-700' : 'border-neutral-100 text-neutral-500' }} cursor-pointer hover:border-primary-200 hover:text-primary-700 transition-colors">
                                                                    <input type="checkbox"
                                                                           name="permissions[]"
                                                                           value="{{ $permission }}"
                                                                           {{ $checked ? 'checked' : '' }}
                                                                           class="w-3 h-3 rounded accent-primary-500 shrink-0">
                                                                    <span class="text-xs">{{ $label }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="flex justify-end mt-4 pt-3 border-t border-neutral-200">
                                                <button type="submit"
                                                        class="px-4 py-2 text-xs font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition">
                                                    Simpan Hak Akses
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-xs text-neutral-400">Belum ada user terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
function togglePermission(userId) {
    const row = document.getElementById('permission-row-' + userId);
    const btn = document.getElementById('btn-permission-' + userId);
    if (!row) return;

    const isHidden = row.classList.contains('hidden');

    document.querySelectorAll('[id^="permission-row-"]').forEach(r => {
        if (!r.classList.contains('hidden')) {
            const card = r.querySelector('td > div');
            card.style.transition = 'opacity 0.15s ease, transform 0.15s ease';
            card.style.opacity = '0';
            card.style.transform = 'translateY(-4px)';
            setTimeout(() => r.classList.add('hidden'), 150);
        }
    });

    document.querySelectorAll('[id^="btn-permission-"]').forEach(b => {
        b.classList.remove('border-primary-300', 'text-primary-600', 'bg-primary-50');
    });

    if (isHidden) {
        setTimeout(() => {
            row.classList.remove('hidden');
            const card = row.querySelector('td > div');
            card.style.opacity = '0';
            card.style.transform = 'translateY(-4px)';
            card.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
            requestAnimationFrame(() => requestAnimationFrame(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }));
            setTimeout(() => row.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 50);
        }, 160);

        if (btn) {
            btn.classList.add('border-primary-300', 'text-primary-600', 'bg-primary-50');
        }
    }
}
</script>
@endsection