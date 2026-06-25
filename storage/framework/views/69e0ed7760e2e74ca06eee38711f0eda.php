<div id="modal-penugasan"
     class="fixed inset-0 z-[500] flex items-center justify-center p-4 hidden"
     role="dialog" aria-modal="true" aria-labelledby="modal-penugasan-title">

    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="tutupModalPenugasan()"></div>

    <div class="relative w-full max-w-sm bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        
        <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-neutral-100">
            <div>
                <h3 id="modal-penugasan-title" class="text-sm font-semibold text-neutral-800">Penugasan Lokasi</h3>
                <p id="modal-penugasan-subtitle" class="text-xs text-neutral-400 mt-0.5"></p>
            </div>
            <button type="button" onclick="tutupModalPenugasan()" aria-label="Tutup"
                    class="p-1.5 rounded-lg text-neutral-300 hover:text-neutral-500 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        
        <form id="form-penugasan" method="POST" action="" class="flex flex-col">
            <?php echo csrf_field(); ?>

            <div class="px-6 py-5 flex flex-col gap-2 max-h-72 overflow-y-auto custom-scroll">
                <?php $__empty_1 = true; $__currentLoopData = $lokasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <label id="label-lokasi-<?php echo e($lokasi->id); ?>"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg border border-neutral-100 bg-neutral-50 cursor-pointer hover:border-primary-200 hover:bg-primary-50 transition-colors">
                        <input type="checkbox"
                               name="lokasi_ids[]"
                               value="<?php echo e($lokasi->id); ?>"
                               class="checkbox-lokasi w-3.5 h-3.5 rounded accent-primary-500 shrink-0">
                        <span class="text-xs font-medium text-neutral-700"><?php echo e($lokasi->nama_lokasi); ?></span>
                    </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-xs text-neutral-400 text-center py-4">Belum ada lokasi aktif.</p>
                <?php endif; ?>
            </div>

            <div class="flex items-center justify-between gap-2 px-6 py-4 border-t border-neutral-100 bg-neutral-50">
                <button type="button" onclick="tutupModalPenugasan()"
                        class="px-4 py-2 text-sm font-medium rounded-lg text-neutral-600 border border-neutral-200 hover:bg-neutral-100 transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium rounded-lg bg-primary-600 text-white hover:bg-primary-700 transition-colors">
                    Simpan Penugasan
                </button>
            </div>
        </form>
    </div>
</div><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/admin/pengaturan/partials/modal-assign.blade.php ENDPATH**/ ?>