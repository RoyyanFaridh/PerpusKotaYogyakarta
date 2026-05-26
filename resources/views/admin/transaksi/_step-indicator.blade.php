<div class="flex items-center px-6 sm:px-8 py-4 gap-1.5 border-b border-neutral-100">
    @foreach (['Member', 'Buku Diserahkan', 'Buku Diterima', 'Konfirmasi'] as $i => $label)
        <div class="flex items-center gap-1.5 {{ $i < 3 ? 'flex-1' : '' }}">

            {{-- Dot --}}
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0 transition-all ring-2
                    {{ $i === 0
                        ? 'bg-primary-600 text-white ring-primary-200'
                        : 'bg-neutral-100 text-neutral-400 ring-transparent' }}"
                 id="{{ $prefix }}_dot_{{ $i + 1 }}">
                <span id="{{ $prefix }}_dot_inner_{{ $i + 1 }}">{{ $i + 1 }}</span>
            </div>

            {{-- Label: aktif selalu tampil, inactive hidden di mobile --}}
            <span class="text-xs font-medium transition-colors
                    {{ $i === 0 ? 'text-primary-700 block' : 'text-neutral-400 hidden sm:block' }}"
                  id="{{ $prefix }}_label_{{ $i + 1 }}">
                {{ $label }}
            </span>

            {{-- Connector --}}
            @if ($i < 3)
                <div class="flex-1 h-px bg-neutral-150 mx-1.5" id="{{ $prefix }}_line_{{ $i + 1 }}"></div>
            @endif

        </div>
    @endforeach
</div>