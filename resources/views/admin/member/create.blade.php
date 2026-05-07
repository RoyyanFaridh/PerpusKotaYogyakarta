@extends('layouts.admin')
@section('title', 'Tambah Member')
@section('page-title', 'Member')
@section('page-subtitle', 'Tambah member baru')

@section('content')
<div class="flex flex-col gap-4 max-w-2xl">

    {{-- Back --}}
    <a href="{{ route('admin.member.index') }}"
       class="flex items-center gap-1.5 text-xs text-neutral-400 hover:text-primary-600 transition-colors w-fit">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"/>
        </svg>
        Kembali ke daftar member
    </a>

    {{-- Form Card --}}
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="px-6 py-4 border-b border-neutral-100">
            <h2 class="text-sm font-semibold text-neutral-800">Informasi Member</h2>
            <p class="text-xs text-neutral-400 mt-0.5">Lengkapi data member baru</p>
        </div>

        <form method="POST" action="{{ route('admin.member.store') }}" class="px-6 py-5 flex flex-col gap-4">
            @csrf

            {{-- No. Telepon --}}
            <div class="flex flex-col gap-1.5">
                <label for="no_telp" class="text-xs font-medium text-neutral-700">
                    Nomor Telepon <span class="text-danger-500">*</span>
                </label>
                <input
                    type="text"
                    id="no_telp"
                    name="no_telp"
                    value="{{ old('no_telp') }}"
                    maxlength="15"
                    placeholder="Contoh: 08123456789"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('no_telp') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"
                >
                @error('no_telp')
                    <p class="text-xs text-danger-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama --}}
            <div class="flex flex-col gap-1.5">
                <label for="nama" class="text-xs font-medium text-neutral-700">
                    Nama Lengkap <span class="text-danger-500">*</span>
                </label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="{{ old('nama') }}"
                    placeholder="Masukkan nama lengkap"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('nama') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"
                >
                @error('nama')
                    <p class="text-xs text-danger-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="flex flex-col gap-1.5">
                <label for="email" class="text-xs font-medium text-neutral-700">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="contoh@email.com"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('email') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"
                >
                @error('email')
                    <p class="text-xs text-danger-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat --}}
            <div class="flex flex-col gap-1.5">
                <label for="alamat" class="text-xs font-medium text-neutral-700">Alamat</label>
                <textarea
                    id="alamat"
                    name="alamat"
                    rows="3"
                    placeholder="Masukkan alamat lengkap"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('alamat') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition resize-none"
                >{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="text-xs text-danger-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- User --}}
            <div class="flex flex-col gap-1.5">
                <label for="user_id" class="text-xs font-medium text-neutral-700">
                    User <span class="text-danger-500">*</span>
                </label>
                <select
                    id="user_id"
                    name="user_id"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('user_id') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"
                >
                    <option value="">-- Pilih User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->nama }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-xs text-danger-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-2 pt-2 border-t border-neutral-100">
                <a href="{{ route('admin.member.index') }}"
                   class="px-4 py-2 text-xs font-medium rounded-lg border border-neutral-200 text-neutral-600 hover:bg-neutral-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-4 py-2 text-xs font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition">
                    Simpan Member
                </button>
            </div>
        </form>
    </div>

</div>
@endsection