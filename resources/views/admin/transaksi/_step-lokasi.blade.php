@php
    $user = auth()->user();
    $lokasiStep = $user->isSuperAdmin() || $user->penugasanAktif()->count() >= 2;
@endphp

@if ($lokasiStep)
<div class="step-content-{{ $prefix }} hidden" data-step="1">
    <p class="text-sm font-medium text-neutral-700 mb-1">Pilih Lokasi</p>
    <p class="text-xs text-neutral-400 mb-4">Transaksi ini akan dicatat di lokasi yang dipilih.</p>

    <div id="{{ $prefix }}_lokasiList" class="flex flex-col gap-2">
        @foreach ($lokasiPilihan as $lokasi)
            <button
                type="button"
                data-id="{{ $lokasi->id }}"
                onclick="pilihLokasi({{ $lokasi->id }}, this)"
                class="w-full text-left px-4 py-3 rounded-lg border text-sm transition-all
                       border-neutral-200 hover:border-primary hover:bg-primary-50
                       focus:outline-none focus:ring-2 focus:ring-primary-300
                       {{ $activeLokasiId === $lokasi->id ? 'border-primary bg-primary-50 font-semibold' : '' }}">
                {{ $lokasi->nama_lokasi }}
            </button>
        @endforeach
    </div>
</div>
@endif