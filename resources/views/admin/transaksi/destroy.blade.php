<div id="modalHapusTransaksi"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm">

    <div class="absolute inset-0" onclick="tutupModalHapusTransaksi()"></div>

    <div class="relative z-10 w-full max-w-md rounded-xl bg-white border border-neutral-200 overflow-hidden shadow-lg">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-danger-400"></div>

        <div class="px-8 pt-7 pb-6 flex flex-col items-center text-center gap-4">
            <div class="w-13 h-13 rounded-full bg-danger-50 border border-danger-100 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-danger-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    <path d="M10 11v6"/><path d="M14 11v6"/>
                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
            </div>

            <div>
                <h2 class="text-base font-semibold text-neutral-800">Hapus Transaksi?</h2>
                <p class="text-sm text-neutral-400 mt-1.5 leading-relaxed">
                    Transaksi <span id="hapusTransaksiId" class="font-semibold text-neutral-600"></span>
                    akan dihapus permanen dan tidak bisa dikembalikan.
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3 px-8 pb-6">
            <button type="button" onclick="tutupModalHapusTransaksi()"
                    class="flex-1 px-4 py-2.5 text-sm font-medium rounded-lg border border-neutral-200 text-neutral-600 hover:bg-neutral-50 transition">
                Batal
            </button>
            <form id="formHapusTransaksi" method="POST" action="" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full px-4 py-2.5 text-sm font-medium rounded-lg bg-danger-500 text-white hover:bg-danger-600 transition">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>