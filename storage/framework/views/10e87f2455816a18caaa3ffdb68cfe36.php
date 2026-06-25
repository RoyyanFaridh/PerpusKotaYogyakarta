<div id="modalHapusTransaksi"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 backdrop-blur-sm p-4">

    <div class="absolute inset-0" onclick="tutupModalHapusTransaksi()"></div>

    <div class="relative z-10 w-full max-w-md rounded-2xl bg-white overflow-hidden shadow-xl">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-danger-400"></div>

        <div class="px-6 sm:px-8 pt-7 pb-6 flex flex-col items-center text-center gap-3">
            <div class="w-12 h-12 rounded-full bg-danger-50 border border-danger-100 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-danger-500"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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

        <div class="flex items-center gap-2 px-6 sm:px-8 pb-6">
            <button type="button" onclick="tutupModalHapusTransaksi()"
                    class="flex-1 px-4 py-2 text-sm font-medium rounded-lg text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 transition-colors">
                Batal
            </button>
            <form id="formHapusTransaksi" method="POST" action="" class="flex-1">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit"
                        class="w-full px-4 py-2 text-sm font-medium rounded-lg bg-danger-500 text-white hover:bg-danger-600 transition-colors">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/admin/transaksi/destroy.blade.php ENDPATH**/ ?>