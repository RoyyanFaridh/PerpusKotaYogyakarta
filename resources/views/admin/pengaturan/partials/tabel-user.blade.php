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
                    <th class="text-left   text-xs font-medium text-neutral-400 px-5 py-3">Username</th>
                    <th class="text-left   text-xs font-medium text-neutral-400 px-5 py-3">Email</th>
                    <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Role</th>
                    <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Lokasi Aktif</th>
                    <th class="text-center text-xs font-medium text-neutral-400 px-5 py-3">Status</th>
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
                                <div>
                                    <p class="text-xs font-semibold text-neutral-800">{{ $user->nama ?? '-' }}</p>
                                    @if (!$user->is_active)
                                        <span class="text-xs text-danger-400 italic">Nonaktif</span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Username --}}
                        <td class="px-5 py-3.5 text-xs text-neutral-600">{{ $user->username ?? '-' }}</td>

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

                        {{-- Lokasi Aktif — penugasanAktif sekarang koleksi --}}
                        <td class="px-5 py-3.5 text-center">
                            @if ($user->isSuperAdmin())
                                <span class="text-xs text-neutral-300 italic">Semua lokasi</span>
                            @elseif ($user->penugasanAktif->isEmpty())
                                <span class="text-xs text-neutral-300 italic">Belum ditugaskan</span>
                            @else
                                <div class="flex flex-wrap justify-center gap-1">
                                    @foreach ($user->penugasanAktif as $penugasan)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-success-50 text-success-700 border border-success-100">
                                            {{ $penugasan->lokasi->nama_lokasi ?? '-' }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </td>

                        {{-- Status is_active --}}
                        <td class="px-5 py-3.5 text-center">
                            @if ($user->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-success-50 text-success-700 border border-success-100">Aktif</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-neutral-100 text-neutral-400">Nonaktif</span>
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

                                    @if (auth()->user()->isSuperAdmin() && !$user->isSuperAdmin())
                                        {{-- Penugasan Lokasi --}}
                                        <button type="button"
                                                onclick="bukaModalPenugasan(
                                                    {{ $user->id }},
                                                    '{{ e($user->nama) }}',
                                                    {{ $user->penugasanAktif->pluck('lokasi_id')->toJson() }}
                                                )"
                                                class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-primary-300 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="23" y1="11" x2="17" y2="11"/><line x1="20" y1="8" x2="20" y2="14"/></svg>
                                            <span>Penugasan</span>
                                        </button>

                                        {{-- Histori --}}
                                        <button type="button"
                                                onclick="bukaModalHistori({{ $user->id }}, '{{ e($user->nama) }}')"
                                                class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-neutral-400 hover:text-neutral-700 hover:bg-neutral-50 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                            <span>Histori</span>
                                        </button>

                                        {{-- Akses --}}
                                        <button type="button"
                                                onclick="togglePermission({{ $user->id }})"
                                                id="btn-permission-{{ $user->id }}"
                                                class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-primary-300 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                            <x-icons.lock/>
                                            <span>Akses</span>
                                        </button>

                                        {{-- Toggle Aktif --}}
                                        <button type="button"
                                                onclick="bukaModalToggleAktifUser({{ $user->id }})"
                                                class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 {{ $user->is_active ? 'hover:border-warning-300 hover:text-warning-600 hover:bg-warning-50' : 'hover:border-success-300 hover:text-success-600 hover:bg-success-50' }} transition-colors">
                                            @if ($user->is_active)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18.36 6.64A9 9 0 0 1 20.77 15"/><path d="M6.16 6.16a9 9 0 1 0 12.68 12.68"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
                                                <span>Nonaktifkan</span>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2a10 10 0 1 1 0 20A10 10 0 0 1 12 2z"/><polyline points="9 11 12 14 22 4"/></svg>
                                                <span>Aktifkan</span>
                                            @endif
                                        </button>
                                    @endif

                                    <button type="button" onclick="bukaModalEditUser({{ $user->id }})"
                                            class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-primary-300 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                        <x-icons.edit/>
                                        <span>Edit</span>
                                    </button>

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
                        @include('admin.pengaturan.partials.accordion-permission', ['user' => $user])

                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-12 text-center text-sm text-neutral-400">Belum ada user terdaftar.</td>
                            </tr>
                        @endforelse
            </tbody>
        </table>
    </div>
</div>