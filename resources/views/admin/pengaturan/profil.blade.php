@extends('layouts.admin')
@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')
@section('page-subtitle', 'Kelola akun Anda')

@section('content')
<div class="flex flex-col gap-5">

    @if (session('success'))
        <div class="flex items-center gap-2.5 px-4 py-3 rounded-lg bg-success-50 border border-success-100 text-success-700 text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" aria-hidden="true">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="flex items-center gap-2.5 px-4 py-3 rounded-lg bg-danger-50 border border-danger-100 text-danger-700 text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Profil Saya --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="px-6 pt-5 pb-4 border-b border-neutral-100">
            <h2 class="text-sm font-semibold text-neutral-800">Profil Saya</h2>
            <p class="text-xs text-neutral-400 mt-0.5">Perbarui informasi akun Anda</p>
        </div>

        <form method="POST" action="{{ route('admin.pengaturan.profil') }}"
              class="px-6 py-5 flex flex-col gap-4">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-neutral-600">
                    Nama <span class="text-danger-500">*</span>
                </label>
                <input type="text" name="nama"
                       value="{{ old('nama', auth()->user()->nama) }}"
                       placeholder="Nama lengkap"
                       class="w-full text-sm px-3.5 py-2 rounded-lg border {{ $errors->has('nama') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition">
                @error('nama')
                    <p class="text-xs text-danger-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-neutral-600">
                    Email
                    <span class="text-xs font-normal text-neutral-400 ml-1">opsional</span>
                </label>
                <input type="email" name="email"
                       value="{{ old('email', auth()->user()->email) }}"
                       placeholder="contoh@email.com"
                       class="w-full text-sm px-3.5 py-2 rounded-lg border {{ $errors->has('email') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition">
                @error('email')
                    <p class="text-xs text-danger-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-neutral-600">
                    Nomor HP
                    <span class="text-xs font-normal text-neutral-400 ml-1">opsional</span>
                </label>
                <input type="text" name="no_hp"
                       value="{{ old('no_hp', auth()->user()->no_hp) }}"
                       placeholder="08xxxxxxxxxx" maxlength="15"
                       class="w-full text-sm px-3.5 py-2 rounded-lg border {{ $errors->has('no_hp') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition">
                @error('no_hp')
                    <p class="text-xs text-danger-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end pt-2 border-t border-neutral-100">
                <button type="submit"
                        class="text-sm font-medium px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700 transition-colors">
                    Simpan Profil
                </button>
            </div>
        </form>
    </div>

    {{-- Ganti Password --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="px-6 pt-5 pb-4 border-b border-neutral-100">
            <h2 class="text-sm font-semibold text-neutral-800">Ganti Password</h2>
            <p class="text-xs text-neutral-400 mt-0.5">Pastikan password baru minimal 8 karakter</p>
        </div>

        <form method="POST" action="{{ route('admin.pengaturan.password') }}"
              class="px-6 py-5 flex flex-col gap-4">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-neutral-600">
                    Password Saat Ini <span class="text-danger-500">*</span>
                </label>
                <input type="password" name="current_password"
                       placeholder="Password saat ini"
                       class="w-full text-sm px-3.5 py-2 rounded-lg border {{ $errors->has('current_password') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition">
                @error('current_password')
                    <p class="text-xs text-danger-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-neutral-600">
                    Password Baru <span class="text-danger-500">*</span>
                </label>
                <input type="password" name="password"
                       placeholder="Min. 8 karakter"
                       class="w-full text-sm px-3.5 py-2 rounded-lg border {{ $errors->has('password') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition">
                @error('password')
                    <p class="text-xs text-danger-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-neutral-600">
                    Konfirmasi Password Baru <span class="text-danger-500">*</span>
                </label>
                <input type="password" name="password_confirmation"
                       placeholder="Ulangi password baru"
                       class="w-full text-sm px-3.5 py-2 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition">
            </div>

            <div class="flex justify-end pt-2 border-t border-neutral-100">
                <button type="submit"
                        class="text-sm font-medium px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700 transition-colors">
                    Ganti Password
                </button>
            </div>
        </form>
    </div>

</div>
@endsection