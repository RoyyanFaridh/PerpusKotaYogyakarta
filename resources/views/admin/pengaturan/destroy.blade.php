@extends('layouts.admin')
@section('title', 'Hapus User')
@section('page-title', 'Hapus User')
@section('page-subtitle', 'Konfirmasi penghapusan akun')

@section('content')
<div class="max-w-md">
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-danger-400"></div>

        <div class="px-6 py-4 border-b border-neutral-100">
            <h2 class="text-sm font-semibold text-neutral-800">Konfirmasi Hapus</h2>
            <p class="text-xs text-neutral-400 mt-0.5">Tindakan ini tidak dapat dibatalkan</p>
        </div>

        <div class="px-6 py-5 flex flex-col gap-4">

            <div class="flex items-start gap-3 p-3.5 rounded-lg bg-danger-50 border border-danger-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-danger-500 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <p class="text-xs text-danger-700">Akun yang dihapus tidak dapat dikembalikan. Semua permission user ini juga akan ikut terhapus.</p>
            </div>

            <div class="flex items-center gap-3 p-3.5 rounded-lg border border-neutral-100 bg-neutral-50">
                <div class="w-9 h-9 rounded-full bg-neutral-200 text-neutral-600 flex items-center justify-center text-sm font-bold uppercase shrink-0">
                    {{ substr($user->nama, 0, 1) }}
                </div>
                <div>
                    <p class="text-xs font-semibold text-neutral-800">{{ $user->nama }}</p>
                    <p class="text-xs text-neutral-400 mt-0.5">{{ $user->email ?? 'Tidak ada email' }}</p>
                    <p class="text-xs text-neutral-400">
                        {{ $user->isSuperAdmin() ? 'Superadmin' : 'Admin' }}
                        · Dibuat {{ $user->created_at?->format('d M Y') }}
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.pengaturan.user.destroy', $user) }}">
                @csrf
                @method('DELETE')
                <div class="flex items-center justify-between pt-2 border-t border-neutral-100">
                    <a href="{{ route('admin.pengaturan.index') }}"
                       class="text-xs text-neutral-400 hover:text-neutral-600 transition">
                        ← Batal
                    </a>
                    <button type="submit"
                            class="px-4 py-2 text-xs font-medium rounded-lg bg-danger-500 text-white hover:bg-danger-600 transition">
                        Ya, Hapus User
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection