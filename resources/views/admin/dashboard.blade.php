@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat Datang, Petugas!')

@section('content')
    <div class="flex flex-col gap-6">

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <x-admin.dashboard.stat-card
                label="Transaksi Bulan Ini"
                :value="$transaksiBulanIni"
                icon="document"
                color="primary"
                :badge="($selisihTransaksi >= 0 ? '+' : '') . $selisihTransaksi . '% dari bulan lalu'"
                caption="Total transaksi tukar buku"
                :href="route('admin.transaksi.index')"
            />
            <x-admin.dashboard.stat-card
                label="Buku Tersedia"
                :value="$bukuTersedia"
                icon="book"
                color="success"
                :badge="'+' . $bukuMingguIni . ' minggu ini'"
                caption="Buku tukar yang sudah diterima"
                :href="route('admin.buku.index')"
            />
            <x-admin.dashboard.stat-card
                label="Member Bulan Ini"
                :value="$memberBulanIni"
                icon="users"
                color="warning"
                :badge="($selisihMember >= 0 ? '+' : '') . $selisihMember . ' dari bulan lalu'"
                caption="Total member yang bergabung"
                :href="route('admin.member.index')"
            />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 items-start">
            @include('components.admin.dashboard.penukaran-per-kategori', ['kategoris' => $kategoris])
            @include('components.admin.dashboard.aktivitas-terkini', ['aktivitas' => $aktivitas])
        </div>

        @if ($transaksiTerbaru->isNotEmpty())
            <x-admin.dashboard.transaksi-terbaru :transaksis="$transaksiTerbaru"/>
        @else
            <div class="rounded-xl border border-neutral-200 bg-white p-8 flex flex-col items-center justify-center min-h-40">
                <span class="text-sm text-neutral-400">Belum ada transaksi terbaru.</span>
            </div>
        @endif

    </div>
@endsection