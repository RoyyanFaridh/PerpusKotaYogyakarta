@extends('layouts.admin')
@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')
@section('page-subtitle', 'Kelola akun dan sistem')

@section('content')
<div class="flex flex-col gap-4">

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-success-50 border border-success-200 text-success-700 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-danger-50 border border-danger-200 text-danger-700 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        {{-- Profil Akun --}}
        <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
            <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>
            <div class="px-6 py-4 border-b border-neutral-100">
                <h2 class="text-sm font-semibold text-neutral-800">Profil Akun</h2>
                <p class="text-xs text-neutral-400 mt-0.5">Perbarui nama, email dan nomor HP</p>
            </div>
            <form method="POST" action="{{ route('admin.pengaturan.profil') }}" class="px-6 py-5 flex flex-col gap-4">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', auth()->user()?->nama) }}"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('nama') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                    @error('nama') <p class="text-xs text-danger-500">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}"
                        placeholder="contoh@email.com"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('email') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                    @error('email') <p class="text-xs text-danger-500">{{ $message }}</p> @enderror
                </div>

                {{-- Nomor HP --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Nomor HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', auth()->user()?->no_hp) }}"
                        placeholder="08xxxxxxxxxx" maxlength="15"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('no_hp') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                    @error('no_hp') <p class="text-xs text-danger-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end pt-2 border-t border-neutral-100">
                    <button type="submit" class="px-4 py-2 text-xs font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition">
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>

        {{-- Ubah Password --}}
        <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
            <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>
            <div class="px-6 py-4 border-b border-neutral-100">
                <h2 class="text-sm font-semibold text-neutral-800">Ubah Password</h2>
                <p class="text-xs text-neutral-400 mt-0.5">Pastikan password baru cukup kuat</p>
            </div>
            <form method="POST" action="{{ route('admin.pengaturan.password') }}" class="px-6 py-5 flex flex-col gap-4">
                @csrf
                @method('PUT')

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Password Saat Ini</label>
                    <input type="password" name="current_password" placeholder="••••••••"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('current_password') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                    @error('current_password') <p class="text-xs text-danger-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Password Baru</label>
                    <input type="password" name="password" placeholder="••••••••"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('password') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                    @error('password') <p class="text-xs text-danger-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                </div>

                <div class="flex justify-end pt-2 border-t border-neutral-100">
                    <button type="submit" class="px-4 py-2 text-xs font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition">
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>

        {{-- Tambah User --}}
        <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
            <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>
            <div class="px-6 py-4 border-b border-neutral-100">
                <h2 class="text-sm font-semibold text-neutral-800">Tambah User</h2>
                <p class="text-xs text-neutral-400 mt-0.5">Buat akun petugas baru</p>
            </div>
            <form method="POST" action="{{ route('admin.pengaturan.user') }}" class="px-6 py-5 flex flex-col gap-4">
                @csrf

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Nama <span class="text-danger-500">*</span></label>
                    <input type="text" name="new_name" value="{{ old('new_name') }}" placeholder="Nama lengkap"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('new_name') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                    @error('new_name') <p class="text-xs text-danger-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Email</label>
                    <input type="email" name="new_email" value="{{ old('new_email') }}" placeholder="contoh@email.com"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('new_email') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                    @error('new_email') <p class="text-xs text-danger-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Password <span class="text-danger-500">*</span></label>
                    <input type="password" name="new_password" placeholder="••••••••"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('new_password') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                    @error('new_password') <p class="text-xs text-danger-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end pt-2 border-t border-neutral-100">
                    <button type="submit" class="px-4 py-2 text-xs font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition">
                        Buat Akun
                    </button>
                </div>
            </form>
        </div>

        {{-- Backup Database --}}
        <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
            <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>
            <div class="px-6 py-4 border-b border-neutral-100">
                <h2 class="text-sm font-semibold text-neutral-800">Backup Database</h2>
                <p class="text-xs text-neutral-400 mt-0.5">Unduh salinan data perpustakaan</p>
            </div>
            <div class="px-6 py-5 flex flex-col gap-4">
                <div class="flex items-start gap-3 p-3.5 rounded-lg bg-neutral-50 border border-neutral-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-neutral-400 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <div>
                        <p class="text-xs font-medium text-neutral-700">Informasi Backup</p>
                        <p class="text-xs text-neutral-400 mt-0.5">File backup akan diunduh dalam format <span class="font-mono">.sql</span>. Simpan file ini di tempat yang aman.</p>
                    </div>
                </div>

                <div class="flex items-center justify-between py-2.5 px-3.5 rounded-lg border border-neutral-100">
                    <div>
                        <p class="text-xs font-medium text-neutral-700">Backup Terakhir</p>
                        <p class="text-xs text-neutral-400 mt-0.5">{{ $lastBackup ?? 'Belum pernah backup' }}</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-neutral-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                    </svg>
                </div>

                <div class="flex justify-end pt-2 border-t border-neutral-100">
                    <a href="{{ route('admin.pengaturan.backup') }}"
                       class="flex items-center gap-2 px-4 py-2 text-xs font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Unduh Backup
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- Daftar User --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>
        <div class="px-6 py-4 border-b border-neutral-100">
            <h2 class="text-sm font-semibold text-neutral-800">Daftar User</h2>
            <p class="text-xs text-neutral-400 mt-0.5">Semua akun yang terdaftar di sistem</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Nama</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Email</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">No. HP</th>
                        <th class="text-left text-xs font-medium text-neutral-400 px-5 py-3">Dibuat</th>
                        <th class="text-right text-xs font-medium text-neutral-400 px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50">
                    @forelse ($users as $user)
                        <tr class="hover:bg-neutral-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center text-xs font-bold uppercase shrink-0">
                                        {{ substr($user->nama ?? '?', 0, 1) }}
                                    </div>
                                    <p class="text-xs font-semibold text-neutral-800">{{ $user->nama ?? '-' }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-xs text-neutral-600">{{ $user->email ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-xs text-neutral-600">{{ $user->no_hp ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-xs text-neutral-400">
                                {{ $user->created_at?->format('d M Y') ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-1.5">
                                    @if ($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.pengaturan.user.destroy', $user) }}"
                                              onsubmit="return confirm('Hapus user {{ $user->nama ?? '' }}?')">
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
                                    @else
                                        <span class="text-[0.68rem] text-neutral-300 px-2">Anda</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
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
@endsection