@extends('layouts.admin')
@section('title', 'Tambah User')
@section('page-title', 'Tambah User')
@section('page-subtitle', 'Buat akun petugas baru')

@section('content')
<div class="max-w-lg">
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>
        <div class="px-6 py-4 border-b border-neutral-100">
            <h2 class="text-sm font-semibold text-neutral-800">Informasi Akun</h2>
            <p class="text-xs text-neutral-400 mt-0.5">Isi data akun petugas baru</p>
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
                <input type="password" name="new_password" placeholder="Min. 8 karakter"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('new_password') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                @error('new_password') <p class="text-xs text-danger-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Role <span class="text-danger-500">*</span></label>
                <select name="new_role"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('new_role') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white">
                    <option value="admin"      {{ old('new_role', 'admin') === 'admin'      ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ old('new_role') === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                </select>
                <p class="text-xs text-neutral-400">Superadmin memiliki semua akses tanpa perlu diatur permission-nya.</p>
                @error('new_role') <p class="text-xs text-danger-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-between pt-2 border-t border-neutral-100">
                <a href="{{ route('admin.pengaturan.index') }}" class="text-xs text-neutral-400 hover:text-neutral-600 transition">
                    ← Kembali
                </a>
                <button type="submit" class="px-4 py-2 text-xs font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition">
                    Buat Akun
                </button>
            </div>
        </form>
    </div>
</div>
@endsection