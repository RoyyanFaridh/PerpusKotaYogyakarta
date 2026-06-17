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

    @include('admin.pengaturan.partials.tabel-user')

    {{-- Modals CRUD --}}
    @include('admin.pengaturan.modals.create')
    @foreach ($users as $userItem)
        @include('admin.pengaturan.modals.edit', ['user' => $userItem])
        @include('admin.pengaturan.modals.destroy', ['user' => $userItem])
    @endforeach

    {{-- Modals Penugasan --}}
    @include('admin.pengaturan.partials.modal-assign')
    @include('admin.pengaturan.partials.modal-histori')

</div>

@include('admin.pengaturan.scripts.pengaturan')
@endsection