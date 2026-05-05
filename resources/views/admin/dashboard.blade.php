@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat Datang, Petugas!')

@section('content')

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <x-admin.stat-card
            label="Transaksi Hari Ini"
            value="24"
            icon="document"
            color="primary"
            badge="+8% dari kemarin"
            caption="Total transaksi tukar buku"
        />

        <x-admin.stat-card
            label="Buku Tersedia"
            value="142"
            icon="book"
            color="success"
            badge="+3 minggu ini"
            caption="Koleksi aktif perpustakaan"
        />

        <x-admin.stat-card
            label="Perlu Verifikasi"
            value="7"
            icon="clock"
            color="warning"
            badge="Perlu tindakan"
            caption="Buku tukar menunggu konfirmasi"
        />
    </div>

@endsection