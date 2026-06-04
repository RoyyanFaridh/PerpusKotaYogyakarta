@props([
    'message' => 'Belum ada buku',
    'sub'     => 'Tambah buku terlebih dahulu',
])

<div class="flex flex-col items-center gap-2 py-12">
    <div class="w-10 h-10 rounded-xl bg-neutral-100 flex items-center justify-center">
        <x-icons.book class="w-5 h-5 text-neutral-400"/>
    </div>
    <p class="text-sm font-medium text-neutral-500">{{ $message }}</p>
    <p class="text-xs text-neutral-400">{{ $sub }}</p>
</div>