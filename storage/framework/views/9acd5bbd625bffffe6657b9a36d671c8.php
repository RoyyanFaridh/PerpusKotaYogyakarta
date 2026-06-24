<div class="step-content-<?php echo e($prefix); ?> hidden" data-step="<?php echo e(3 + ($offset ?? 0)); ?>">

    <div class="mb-4">
        <label class="block text-sm font-medium text-neutral-600 mb-1.5">Cari Buku</label>
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="<?php echo e($prefix); ?>_cariBukuKeluar"
                   placeholder="ISBN, judul, atau pengarang..."
                   autocomplete="off"
                   class="w-full pl-9 pr-4 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            <div id="<?php echo e($prefix); ?>_cariBukuKeluarResults"
                 class="hidden absolute z-20 left-0 right-0 top-full mt-1 bg-white border border-neutral-200 rounded-lg shadow-lg max-h-52 overflow-y-auto">
            </div>
        </div>
        <p id="<?php echo e($prefix); ?>_cariBukuKeluarInfo" class="text-xs mt-1.5"></p>
    </div>

    <div id="<?php echo e($prefix); ?>_bukuKeluarResult" class="hidden mb-4">
        <div class="p-4 rounded-xl border border-success-200 bg-success-50 flex items-start gap-3">
            <div class="w-9 h-9 rounded-lg bg-success-100 text-success-700 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     aria-hidden="true">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-success-800" id="<?php echo e($prefix); ?>_bukuKeluarJudul"></p>
                <p class="text-xs text-success-600 mt-0.5" id="<?php echo e($prefix); ?>_bukuKeluarPengarang"></p>
                <p class="text-xs text-success-600 mt-0.5">
                    Stok: <span id="<?php echo e($prefix); ?>_bukuKeluarStok" class="font-semibold"></span>
                    &nbsp;·&nbsp;
                    Paket: <span id="<?php echo e($prefix); ?>_bukuKeluarPaket" class="font-semibold"></span>
                    &nbsp;·&nbsp;
                    Lokasi: <span id="<?php echo e($prefix); ?>_bukuKeluarLokasi" class="font-semibold"></span>
                </p>
            </div>
            <button type="button" onclick="resetBukuKeluar('<?php echo e($prefix); ?>')"
                    class="shrink-0 text-xs font-medium px-2.5 py-1.5 rounded-lg border border-success-200 text-success-700 hover:bg-success-100 transition-colors">
                Ganti
            </button>
        </div>
        <input type="hidden" id="<?php echo e($prefix); ?>_bukuKeluarId"/>
    </div>

    <div id="<?php echo e($prefix); ?>_bukuKeluarEmpty">
        <div class="relative flex items-center gap-3 my-5">
            <div class="flex-1 h-px bg-neutral-100"></div>
            <span class="text-xs text-neutral-400 font-medium shrink-0">Buku Tersedia di Paket</span>
            <div class="flex-1 h-px bg-neutral-100"></div>
        </div>

        <div id="<?php echo e($prefix); ?>_listBukuLokasi"
             class="rounded-lg border border-neutral-200 bg-white overflow-hidden max-h-52 overflow-y-auto">
            <div class="px-4 py-5 text-center text-sm text-neutral-400">Memuat daftar buku...</div>
        </div>
    </div>

</div><?php /**PATH D:\Perkuliahan Duniawi\MAGANG GES\PerpusKotaYogyakarta\resources\views/admin/transaksi/_step-keluar.blade.php ENDPATH**/ ?>