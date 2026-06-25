<div id="modalHapusBuku"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-xl border border-neutral-200 w-full max-w-sm mx-4">

        <div class="flex items-center gap-3 px-5 pt-5 pb-4 border-b border-neutral-100">
            <div class="w-9 h-9 rounded-lg bg-danger-50 text-danger-600 flex items-center justify-center shrink-0">
                <?php if (isset($component)) { $__componentOriginalab518ebc45c56ecd96af42eff2f09240 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab518ebc45c56ecd96af42eff2f09240 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.delete','data' => ['class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalab518ebc45c56ecd96af42eff2f09240)): ?>
<?php $attributes = $__attributesOriginalab518ebc45c56ecd96af42eff2f09240; ?>
<?php unset($__attributesOriginalab518ebc45c56ecd96af42eff2f09240); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalab518ebc45c56ecd96af42eff2f09240)): ?>
<?php $component = $__componentOriginalab518ebc45c56ecd96af42eff2f09240; ?>
<?php unset($__componentOriginalab518ebc45c56ecd96af42eff2f09240); ?>
<?php endif; ?>
            </div>
            <div>
                <p class="text-sm font-semibold text-neutral-800">Hapus Buku</p>
                <p class="text-xs text-neutral-400">Tindakan ini tidak bisa dibatalkan</p>
            </div>
        </div>

        <div class="px-5 py-4">
            <p class="text-sm text-neutral-600">
                Yakin ingin menghapus buku
                <span id="hapusBukuJudul" class="font-semibold text-neutral-800"></span>?
            </p>
            <p class="text-xs text-neutral-400 mt-1">
                Semua eksemplar buku ini juga akan dihapus.
            </p>
        </div>

        <div class="flex items-center justify-end gap-2 px-5 pb-5">
            <button type="button"
                    onclick="tutupModalHapusBuku()"
                    class="px-4 py-2 rounded-lg text-xs font-medium text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">
                Batal
            </button>
            <form id="formHapusBuku" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit"
                        class="px-4 py-2 rounded-lg text-xs font-semibold text-white bg-danger-600 hover:bg-danger-700 transition-colors">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function bukaModalHapusBuku(action, judul) {
    document.getElementById('formHapusBuku').action    = action;
    document.getElementById('hapusBukuJudul').textContent = judul;
    const modal = document.getElementById('modalHapusBuku');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function tutupModalHapusBuku() {
    const modal = document.getElementById('modalHapusBuku');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') tutupModalHapusBuku();
});
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/admin/buku/destroy.blade.php ENDPATH**/ ?>