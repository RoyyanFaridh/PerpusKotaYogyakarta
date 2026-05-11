@extends('layouts.admin')
@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('page-subtitle', 'Ubah profil dan password ' . $user->nama)

@section('content')
<div class="max-w-2xl flex flex-col gap-4">

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

    {{-- Edit Profil --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>
        <div class="px-6 py-4 border-b border-neutral-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center text-sm font-bold uppercase shrink-0">
                {{ substr($user->nama, 0, 1) }}
            </div>
            <div>
                <h2 class="text-sm font-semibold text-neutral-800">Profil — {{ $user->nama }}</h2>
                <p class="text-xs text-neutral-400">Perbarui nama, email, dan nomor HP</p>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.pengaturan.user.update', $user) }}" class="px-6 py-5 flex flex-col gap-4">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Nama <span class="text-danger-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $user->nama) }}"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('nama') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                @error('nama') <p class="text-xs text-danger-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="contoh@email.com"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('email') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                @error('email') <p class="text-xs text-danger-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Nomor HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" placeholder="08xxxxxxxxxx" maxlength="15"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('no_hp') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                @error('no_hp') <p class="text-xs text-danger-500">{{ $message }}</p> @enderror
            </div>

            @if (!$user->isSuperAdmin())
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Role</label>
                    <select name="role"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('role') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white">
                        <option value="admin"      {{ old('role', $user->role) === 'admin'      ? 'selected' : '' }}>Admin</option>
                        <option value="superadmin" {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                    </select>
                    @error('role') <p class="text-xs text-danger-500">{{ $message }}</p> @enderror
                </div>
            @endif

            <div class="flex items-center justify-between pt-2 border-t border-neutral-100">
                <a href="{{ route('admin.pengaturan.index') }}" class="text-xs text-neutral-400 hover:text-neutral-600 transition">← Kembali</a>
                <button type="submit" class="px-4 py-2 text-xs font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition">
                    Simpan Profil
                </button>
            </div>
        </form>
    </div>

    {{-- Ganti Password --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>
        <div class="px-6 py-4 border-b border-neutral-100">
            <h2 class="text-sm font-semibold text-neutral-800">Ganti Password</h2>
            <p class="text-xs text-neutral-400 mt-0.5">Kosongkan jika tidak ingin mengubah password</p>
        </div>
        <form method="POST" action="{{ route('admin.pengaturan.user.password', $user) }}" class="px-6 py-5 flex flex-col gap-4">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Password Baru</label>
                <input type="password" name="password" placeholder="Min. 8 karakter"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('password') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                @error('password') <p class="text-xs text-danger-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
            </div>

            <div class="flex justify-end pt-2 border-t border-neutral-100">
                <button type="submit" class="px-4 py-2 text-xs font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition">
                    Ganti Password
                </button>
            </div>
        </form>
    </div>

</div>
@endsection