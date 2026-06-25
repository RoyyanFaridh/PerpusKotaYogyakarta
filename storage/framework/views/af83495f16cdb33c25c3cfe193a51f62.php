<div class="step-content-<?php echo e($prefix); ?> hidden" data-step="<?php echo e(4 + ($offset ?? 0)); ?>">
    <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 rounded-xl border border-neutral-200 bg-neutral-50">
                <p class="text-xs font-medium text-neutral-400 mb-2">Member</p>
                <p class="text-sm font-semibold text-neutral-800" id="<?php echo e($prefix); ?>_konfirmasiMemberNama"></p>
                <p class="text-xs text-neutral-500 mt-0.5"   id="<?php echo e($prefix); ?>_konfirmasiMemberTelp"></p>
            </div>
            <div class="p-4 rounded-xl border border-neutral-200 bg-neutral-50">
                <p class="text-xs font-medium text-neutral-400 mb-2">Lokasi Penukaran</p>
                <div class="flex items-center gap-2 mt-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-neutral-400 shrink-0"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <p class="text-sm font-semibold text-neutral-800" id="<?php echo e($prefix); ?>_konfirmasiLokasi"></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 rounded-xl border border-neutral-200 bg-neutral-50">
                <div class="flex items-center gap-1.5 mb-2">
                    <svg class="w-3.5 h-3.5 text-warning-500 shrink-0" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14"/><path d="M12 5l7 7-7 7"/>
                    </svg>
                    <p class="text-xs font-medium text-neutral-400">Buku Masuk</p>
                </div>
                <p class="text-sm font-semibold text-neutral-800 leading-snug"
                   id="<?php echo e($prefix); ?>_konfirmasiBukuMasuk"></p>
            </div>
            <div class="p-4 rounded-xl border border-success-200 bg-success-50">
                <div class="flex items-center gap-1.5 mb-2">
                    <svg class="w-3.5 h-3.5 text-success-500 shrink-0" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" aria-hidden="true">
                        <path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/>
                    </svg>
                    <p class="text-xs font-medium text-success-600">Buku Keluar</p>
                </div>
                <p class="text-sm font-semibold text-success-800 leading-snug"
                   id="<?php echo e($prefix); ?>_konfirmasiBukuKeluar"></p>
                <p class="text-xs text-warning-600 mt-1.5">Stok akan berkurang 1</p>
            </div>
        </div>

        <div class="relative flex items-center gap-3">
            <div class="flex-1 h-px bg-neutral-100"></div>
            <span class="text-xs text-neutral-400 font-medium shrink-0">Catatan</span>
            <div class="flex-1 h-px bg-neutral-100"></div>
        </div>

        <div>
            <label class="block text-sm font-medium text-neutral-600 mb-1.5">
                Catatan Petugas
                <span class="text-xs font-normal text-neutral-400 ml-1">opsional</span>
            </label>
            <textarea id="<?php echo e($prefix); ?>_catatanPetugas" rows="2"
                      placeholder="Tambahkan catatan jika diperlukan..."
                      class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition resize-none"></textarea>
        </div>

    </div>
</div><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/admin/transaksi/_step-konfirmasi.blade.php ENDPATH**/ ?>