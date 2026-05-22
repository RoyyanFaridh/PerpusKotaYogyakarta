@php
    $aktivitas ??= [];

    $tipeConfig = [
        'transaksi_disetujui' => ['bg' => 'bg-success-50', 'text' => 'text-success-600', 'icon' => 'check-circle'],
        'transaksi_ditolak'   => ['bg' => 'bg-danger-50',  'text' => 'text-danger-600',  'icon' => 'x-circle'],
        'transaksi_pending'   => ['bg' => 'bg-warning-50', 'text' => 'text-warning-600', 'icon' => 'refresh'],
        'buku_masuk'          => ['bg' => 'bg-primary-50', 'text' => 'text-primary-600', 'icon' => 'book-open'],
        'member_baru'         => ['bg' => 'bg-neutral-100','text' => 'text-neutral-500', 'icon' => 'user-plus'],
        'sisa_buku'           => ['bg' => 'bg-warning-50', 'text' => 'text-warning-600', 'icon' => 'package'],
    ];

    $defaultConfig = $tipeConfig['transaksi_pending'];
@endphp

<div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200 flex flex-col h-full">

    <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

    <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-neutral-100 shrink-0">
        <div class="flex items-center gap-3">
            <div class="shrink-0 w-9 h-9 rounded-lg bg-primary-50 text-primary-700 flex items-center justify-center">
                <x-icon name="bell" size="sm" class="text-primary-600" />
            </div>
            <div>
                <h2 class="text-sm font-medium text-neutral-500 leading-tight">Aktivitas Terkini</h2>
                <p class="text-xs text-neutral-400 mt-0.5">Update real-time sistem</p>
            </div>
        </div>
        <button class="p-1.5 rounded-md text-neutral-300 hover:text-neutral-500 hover:bg-neutral-100 transition-colors">
            <x-icons.ellipsis/>
        </button>
    </div>

    <ul class="divide-y divide-neutral-50 overflow-y-auto max-h-[300px] custom-scroll">

        @forelse ($aktivitas as $item)
            @php
                $cfg = $tipeConfig[$item['tipe'] ?? ''] ?? $defaultConfig;
            @endphp
            <li class="flex items-start gap-3 px-5 py-3 hover:bg-neutral-50 transition-colors">
                <div class="w-9 h-9 rounded-lg {{ $cfg['bg'] }} flex items-center justify-center shrink-0">
                    <x-icon :name="$cfg['icon']" class="w-4.5 h-4.5 {{ $cfg['text'] }}" />
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-neutral-700 leading-snug">
                        {{ $item['pesan'] ?? '-' }}
                    </p>
                    @if (!empty($item['sub']))
                        <p class="text-xs text-neutral-400 mt-0.5 truncate">
                            {{ $item['sub'] }}
                        </p>
                    @endif
                </div>
                <span class="text-xs text-neutral-400 shrink-0 mt-0.5 whitespace-nowrap">
                    {{ $item['waktu'] ?? '-' }}
                </span>
            </li>

        @empty
            <li class="flex flex-col items-center justify-center py-12 text-center px-4">
                <div class="w-10 h-10 rounded-lg bg-neutral-100 flex items-center justify-center mb-3">
                    <x-icon name="document" size="lg" class="text-neutral-400" />
                </div>
                <p class="text-sm font-medium text-neutral-500">Belum ada aktivitas</p>
                <p class="text-xs text-neutral-400 mt-1">Aktivitas terbaru akan muncul di sini</p>
            </li>
        @endforelse

    </ul>

    @if (!empty($aktivitas))
        <div class="px-5 py-3 bg-neutral-50 border-t border-neutral-100 shrink-0">
            <p class="text-xs text-neutral-400">
                Menampilkan {{ count($aktivitas) }} aktivitas terbaru.
            </p>
        </div>
    @endif

</div>