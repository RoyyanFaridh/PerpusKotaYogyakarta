<div class="flex items-center px-6 sm:px-8 py-4 gap-1.5 border-b border-neutral-100">
    @foreach (['Member', 'Buku Diserahkan', 'Buku Diterima', 'Konfirmasi'] as $i => $label)
        <div class="flex items-center gap-1.5 {{ $i < 3 ? 'flex-1' : '' }}">
            <div class="w-5 h-5 rounded-full flex items-center justify-center text-[0.6rem] font-bold shrink-0 transition-all
                    {{ $i === 0 ? 'bg-primary text-white' : 'bg-neutral-100 text-neutral-400' }}"
                 id="{{ $prefix }}_dot_{{ $i + 1 }}">{{ $i + 1 }}</div>

            <span class="text-[0.65rem] font-medium transition-colors hidden sm:block
                    {{ $i === 0 ? 'text-primary-700' : 'text-neutral-400' }}"
                  id="{{ $prefix }}_label_{{ $i + 1 }}">
                {{ $label }}
            </span>

            @if ($i < 3)
                <div class="flex-1 h-px bg-neutral-100 mx-1"></div>
            @endif
        </div>
    @endforeach
</div>