@extends('layouts.admin')
@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')
@section('page-subtitle', 'Kelola akun dan sistem')

@section('content')
<div class="flex flex-col gap-4">

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-success-50 border border-success-200 text-success-700 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-danger-50 border border-danger-200 text-danger-700 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Daftar User --}}
    <div class="relative overflow-hidden rounded-2xl bg-white shadow-sm">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>
        <div class="px-6 sm:px-8 pt-6 pb-5 border-b border-neutral-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-semibold text-neutral-800">Daftar User</h2>
                <p class="text-sm text-neutral-400 mt-0.5">Semua akun yang terdaftar di sistem</p>
            </div>
            @if (auth()->user()->isSuperAdmin())
                <button type="button" onclick="bukaModalUser()"
                        class="flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-lg bg-primary-600 text-white hover:bg-primary-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah User
                </button>
            @endif
        </div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left   text-xs font-medium text-neutral-400 px-5 py-3">Nama</th>
                        <th class="text-left   text-xs font-medium text-neutral-400 px-5 py-3">Email</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Role</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Lokasi Aktif</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Dibuat</th>
                        <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-neutral-50 transition-colors">

                            {{-- Nama --}}
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center text-xs font-bold uppercase shrink-0">
                                        {{ substr($user->nama ?? '?', 0, 1) }}
                                    </div>
                                    <p class="text-xs font-semibold text-neutral-800">{{ $user->nama ?? '-' }}</p>
                                </div>
                            </td>

                            {{-- Email --}}
                            <td class="px-5 py-3.5 text-xs text-neutral-600">{{ $user->email ?? '-' }}</td>

                            {{-- Role --}}
                            <td class="px-5 py-3.5 text-center">
                                @if ($user->isSuperAdmin())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-primary-50 text-primary-700 border border-primary-100">Superadmin</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-neutral-100 text-neutral-600">Admin</span>
                                @endif
                            </td>

                            {{-- Lokasi Aktif --}}
                            <td class="px-5 py-3.5 text-center">
                                @if ($user->isSuperAdmin())
                                    <span class="text-xs text-neutral-300 italic">Semua lokasi</span>
                                @elseif ($user->penugasanAktif === null)
                                    <span class="text-xs text-neutral-300 italic">Belum ditugaskan</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-success-50 text-success-700 border border-success-100">
                                        {{ $user->penugasanAktif->lokasi->nama_lokasi ?? '-' }}
                                    </span>
                                @endif
                            </td>

                            {{-- Dibuat --}}
                            <td class="px-5 py-3.5 text-xs text-neutral-400 text-center">
                                {{ $user->created_at?->format('d M Y') ?? '-' }}
                            </td>

                            {{-- Aksi --}}
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-center gap-1">
                                    @if ($user->id !== auth()->id())

                                        {{-- Tombol Tugaskan / Nonaktifkan & Histori (superadmin only, admin saja) --}}
                                        @if (auth()->user()->isSuperAdmin() && !$user->isSuperAdmin())
                                            @if ($user->penugasanAktif === null)
                                                <button type="button"
                                                        onclick="bukaModalAssign({{ $user->id }}, '{{ e($user->nama) }}')"
                                                        class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-primary-300 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="23" y1="11" x2="17" y2="11"/><line x1="20" y1="8" x2="20" y2="14"/></svg>
                                                    <span>Tugaskan</span>
                                                </button>
                                            @else
                                                <button type="button"
                                                        onclick="bukaModalNonaktifkan({{ $user->id }}, '{{ e($user->nama) }}', '{{ e($user->penugasanAktif->lokasi->nama_lokasi ?? '') }}', {{ $user->penugasanAktif->id }})"
                                                        class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-warning-300 hover:text-warning-600 hover:bg-warning-50 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                                                    <span>Nonaktifkan</span>
                                                </button>
                                            @endif
                                            <button type="button"
                                                    onclick="bukaModalHistori({{ $user->id }}, '{{ e($user->nama) }}')"
                                                    class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-neutral-400 hover:text-neutral-700 hover:bg-neutral-50 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                <span>Histori</span>
                                            </button>
                                        @endif

                                        {{-- Permission (superadmin only, admin saja) --}}
                                        @if (auth()->user()->isSuperAdmin() && !$user->isSuperAdmin())
                                            <button type="button"
                                                    onclick="togglePermission({{ $user->id }})"
                                                    id="btn-permission-{{ $user->id }}"
                                                    class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-primary-300 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                                <x-icons.lock/>
                                                <span>Akses</span>
                                            </button>
                                        @endif

                                        <button type="button" onclick="bukaModalEditUser({{ $user->id }})"
                                                class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-primary-300 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                            <x-icons.edit/>
                                            <span>Edit</span>
                                        </button>

                                        @if (auth()->user()->isSuperAdmin())
                                            <button type="button" onclick="bukaModalHapusUser({{ $user->id }})"
                                                    class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-danger-300 hover:text-danger-600 hover:bg-danger-50 transition-colors">
                                                <x-icons.delete/>
                                                <span>Hapus</span>
                                            </button>
                                        @endif

                                    @else
                                        <button type="button" onclick="bukaModalEditUser({{ $user->id }})"
                                                class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-primary-300 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                            <x-icons.edit/>
                                            <span>Edit</span>
                                        </button>
                                        <span class="text-xs text-neutral-300 px-1">Anda</span>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Accordion Permission --}}
                        @if (!$user->isSuperAdmin() && auth()->user()->isSuperAdmin())
                            <tr id="permission-row-{{ $user->id }}" class="hidden">
                                <td colspan="6" class="px-5 pb-4 pt-1">
                                    <div class="rounded-2xl border border-neutral-100 bg-neutral-50 overflow-hidden">
                                        <div class="px-5 py-3.5 border-b border-neutral-100 flex items-center justify-between bg-white">
                                            <div class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                                <p class="text-sm font-semibold text-neutral-700">Hak Akses — {{ $user->nama }}</p>
                                            </div>
                                            <button type="button" onclick="togglePermission({{ $user->id }})"
                                                    aria-label="Tutup hak akses"
                                                    class="p-1 rounded-lg text-neutral-300 hover:text-neutral-500 hover:bg-neutral-100 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                            </button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.pengaturan.user.permissions', $user) }}"
                                              class="px-5 py-5">
                                            @csrf
                                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                                @foreach ($allPermissions as $modul => $permissions)
                                                    <div class="flex flex-col gap-2">
                                                        <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wide">{{ $modul }}</p>
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
                                            <div class="flex justify-end mt-4 pt-3 border-t border-neutral-100">
                                                <button type="submit"
                                                        class="px-4 py-2 text-sm font-medium rounded-lg bg-primary-600 text-white hover:bg-primary-700 transition-colors">
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
                            <td colspan="6" class="px-5 py-12 text-center text-sm text-neutral-400">Belum ada user terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Include modals user CRUD --}}
    @include('admin.pengaturan.create')
    @foreach ($users as $userItem)
        @include('admin.pengaturan.edit', ['user' => $userItem])
        @include('admin.pengaturan.destroy', ['user' => $userItem])
    @endforeach

</div>

<div id="modal-nonaktifkan"
     class="fixed inset-0 z-[500] flex items-center justify-center p-4 hidden"
     role="dialog" aria-modal="true" aria-labelledby="modal-nonaktifkan-title">

    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="tutupModalNonaktifkan()"></div>

    <div class="relative w-full max-w-sm bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-warning-400"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-neutral-100">
            <div>
                <h3 id="modal-nonaktifkan-title" class="text-sm font-semibold text-neutral-800">Nonaktifkan Penugasan</h3>
                <p id="modal-nonaktifkan-subtitle" class="text-xs text-neutral-400 mt-0.5"></p>
            </div>
            <button type="button" onclick="tutupModalNonaktifkan()"
                    aria-label="Tutup"
                    class="p-1.5 rounded-lg text-neutral-300 hover:text-neutral-500 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="px-6 py-5">
            <p class="text-sm text-neutral-600">
                Admin <span id="modal-nonaktifkan-nama" class="font-semibold text-neutral-800"></span>
                akan dinonaktifkan dari lokasi
                <span id="modal-nonaktifkan-lokasi" class="font-semibold text-neutral-800"></span>.
            </p>
            <p class="text-xs text-neutral-400 mt-1.5">Penugasan akan tersimpan di histori dan dapat ditugaskan ulang kapan saja.</p>
        </div>

        {{-- Footer --}}
        <form id="form-nonaktifkan" method="POST" action=""
              class="flex items-center justify-end gap-2 px-6 py-4 border-t border-neutral-100 bg-neutral-50">
            @csrf
            @method('DELETE')
            <button type="button" onclick="tutupModalNonaktifkan()"
                    class="px-4 py-2 text-sm font-medium rounded-lg text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">
                Batal
            </button>
            <button type="submit"
                    class="px-4 py-2 text-sm font-medium rounded-lg bg-warning-500 text-white hover:bg-warning-600 transition-colors">
                Ya, Nonaktifkan
            </button>
        </form>
    </div>
</div>


<div id="modal-assign"
     class="fixed inset-0 z-[500] flex items-center justify-center p-4 hidden"
     role="dialog" aria-modal="true" aria-labelledby="modal-assign-title">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="tutupModalAssign()"></div>

    <div class="relative w-full max-w-sm bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-neutral-100">
            <div>
                <h3 id="modal-assign-title" class="text-sm font-semibold text-neutral-800">Tugaskan ke Lokasi</h3>
                <p id="modal-assign-subtitle" class="text-xs text-neutral-400 mt-0.5"></p>
            </div>
            <button type="button" onclick="tutupModalAssign()"
                    aria-label="Tutup"
                    class="p-1.5 rounded-lg text-neutral-300 hover:text-neutral-500 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        {{-- Form --}}
        <form id="form-assign" method="POST" action="" class="px-6 py-5 flex flex-col gap-4">
            @csrf
            <div class="flex flex-col gap-1.5">
                <label for="select-lokasi" class="text-xs font-medium text-neutral-600">Pilih Lokasi</label>
                <select id="select-lokasi" name="lokasi_id" required
                        class="w-full text-sm border border-neutral-200 rounded-lg px-3 py-2 text-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                    <option value="" disabled selected>-- Pilih lokasi --</option>
                    @foreach ($lokasis as $lokasi)
                        <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-neutral-400">Admin hanya bisa aktif di satu lokasi dalam satu waktu.</p>
            </div>

            <div class="flex items-center justify-end gap-2 pt-1">
                <button type="button" onclick="tutupModalAssign()"
                        class="px-4 py-2 text-sm font-medium rounded-lg text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium rounded-lg bg-primary-600 text-white hover:bg-primary-700 transition-colors">
                    Tugaskan
                </button>
            </div>
        </form>
    </div>
</div>


<div id="modal-histori"
     class="fixed inset-0 z-[500] flex items-center justify-center p-4 hidden"
     role="dialog" aria-modal="true" aria-labelledby="modal-histori-title">

    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="tutupModalHistori()"></div>

    <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-neutral-300"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-neutral-100">
            <div>
                <h3 id="modal-histori-title" class="text-sm font-semibold text-neutral-800">Histori Penugasan</h3>
                <p id="modal-histori-subtitle" class="text-xs text-neutral-400 mt-0.5"></p>
            </div>
            <button type="button" onclick="tutupModalHistori()"
                    aria-label="Tutup"
                    class="p-1.5 rounded-lg text-neutral-300 hover:text-neutral-500 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        {{-- Body: diisi JS --}}
        <div id="modal-histori-body" class="px-6 py-5 max-h-96 overflow-y-auto custom-scroll">
            <p class="text-sm text-neutral-400 text-center py-6">Memuat data...</p>
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
            card.style.opacity    = '0';
            card.style.transform  = 'translateY(-4px)';
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
            card.style.opacity   = '0';
            card.style.transform = 'translateY(-4px)';
            card.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
            requestAnimationFrame(() => requestAnimationFrame(() => {
                card.style.opacity   = '1';
                card.style.transform = 'translateY(0)';
            }));
            setTimeout(() => row.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 50);
        }, 160);

        if (btn) btn.classList.add('border-primary-300', 'text-primary-600', 'bg-primary-50');
    }
}

function bukaModalAssign(userId, nama) {
    const modal    = document.getElementById('modal-assign');
    const form     = document.getElementById('form-assign');
    const subtitle = document.getElementById('modal-assign-subtitle');
    const select   = document.getElementById('select-lokasi');

    // Set action URL dengan user ID yang benar
    form.action = `/admin/pengaturan/user/${userId}/lokasi`;
    subtitle.textContent = nama;
    select.value = '';

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function tutupModalAssign() {
    document.getElementById('modal-assign').classList.add('hidden');
    document.body.style.overflow = '';
}

function bukaModalNonaktifkan(userId, nama, lokasi, userLokasiId) {
    const modal    = document.getElementById('modal-nonaktifkan');
    const form     = document.getElementById('form-nonaktifkan');
    const elNama   = document.getElementById('modal-nonaktifkan-nama');
    const elLokasi = document.getElementById('modal-nonaktifkan-lokasi');
    const subtitle = document.getElementById('modal-nonaktifkan-subtitle');

    form.action         = `/admin/pengaturan/user/${userId}/lokasi/${userLokasiId}`;
    elNama.textContent  = nama;
    elLokasi.textContent = lokasi;
    subtitle.textContent = nama;

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function tutupModalNonaktifkan() {
    document.getElementById('modal-nonaktifkan').classList.add('hidden');
    document.body.style.overflow = '';
}

function bukaModalHistori(userId, nama) {
    const modal    = document.getElementById('modal-histori');
    const subtitle = document.getElementById('modal-histori-subtitle');
    const body     = document.getElementById('modal-histori-body');

    subtitle.textContent  = nama;
    body.innerHTML        = '<p class="text-sm text-neutral-400 text-center py-6">Memuat data...</p>';

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    fetch(`/admin/pengaturan/user/${userId}/lokasi/histori`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => {
        if (!res.ok) throw new Error('Gagal memuat data.');
        return res.json();
    })
    .then(data => {
        if (!data.histori || data.histori.length === 0) {
            body.innerHTML = '<p class="text-sm text-neutral-400 text-center py-6">Belum ada histori penugasan.</p>';
            return;
        }

        const rows = data.histori.map(item => {
            const assignedAt   = item.assigned_at   ?? '-';
            const unassignedAt = item.unassigned_at ?? null;
            const assignedBy   = item.assigned_by_nama ?? '-';
            const lokasi       = item.lokasi_nama ?? '-';

            const statusBadge = unassignedAt
                ? `<span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-neutral-100 text-neutral-500">Selesai</span>`
                : `<span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-success-50 text-success-700 border border-success-100">Aktif</span>`;

            const unassignBtn = unassignedAt
                ? `<span class="text-xs text-neutral-300">${unassignedAt}</span>`
                : `<form method="POST" action="/admin/pengaturan/user/${userId}/lokasi/${item.id}" onsubmit="return confirm('Nonaktifkan penugasan ini?')">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                       <input type="hidden" name="_method" value="DELETE">
                       <button type="submit" class="text-xs text-danger-500 hover:text-danger-700 hover:underline transition-colors">
                           Nonaktifkan
                       </button>
                   </form>`;

            return `
                <div class="flex items-start justify-between gap-3 py-3 border-b border-neutral-100 last:border-0">
                    <div class="flex flex-col gap-0.5 min-w-0">
                        <p class="text-xs font-semibold text-neutral-700 truncate">${lokasi}</p>
                        <p class="text-xs text-neutral-400">Ditugaskan ${assignedAt} oleh ${assignedBy}</p>
                    </div>
                    <div class="flex flex-col items-end gap-1.5 shrink-0">
                        ${statusBadge}
                        ${unassignBtn}
                    </div>
                </div>`;
        }).join('');

        body.innerHTML = `<div class="flex flex-col divide-y divide-neutral-100">${rows}</div>`;
    })
    .catch(() => {
        body.innerHTML = '<p class="text-sm text-danger-500 text-center py-6">Gagal memuat histori. Coba lagi.</p>';
    });
}

function tutupModalHistori() {
    document.getElementById('modal-histori').classList.add('hidden');
    document.body.style.overflow = '';
}

// Escape key menutup modal manapun yang terbuka
document.addEventListener('keydown', e => {
    if (e.key !== 'Escape') return;
    tutupModalAssign();
    tutupModalHistori();
    tutupModalNonaktifkan();
});
</script>
@endsection