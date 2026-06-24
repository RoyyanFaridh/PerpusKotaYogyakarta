
<form method="GET" action="<?php echo e(route($routeName)); ?>" class="flex flex-wrap items-end gap-3">

    <div class="flex flex-col gap-1">
        <label for="tahun" class="text-xs font-medium text-neutral-600">Tahun</label>
        <select id="tahun" name="tahun"
                onchange="this.form.submit()"
                class="rounded-lg border border-neutral-200 text-sm px-3 py-2 bg-white text-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-300">
            <?php $__currentLoopData = $tahunOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($opt); ?>" <?php if($opt === $tahun): echo 'selected'; endif; ?>><?php echo e($opt); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div class="flex flex-col gap-1">
        <label for="bulan" class="text-xs font-medium text-neutral-600">Bulan</label>
        <select id="bulan" name="bulan"
                onchange="this.form.submit()"
                class="rounded-lg border border-neutral-200 text-sm px-3 py-2 bg-white text-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-300">
            <option value="semua" <?php if($bulan === null): echo 'selected'; endif; ?>>Semua Bulan</option>
            <?php $__currentLoopData = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($num); ?>" <?php if($bulan === $num): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <noscript>
        <button type="submit" class="rounded-lg bg-primary text-white text-sm font-medium px-4 py-2 hover:bg-primary-600 transition-colors">
            Terapkan
        </button>
    </noscript>
</form><?php /**PATH D:\Perkuliahan Duniawi\MAGANG GES\PerpusKotaYogyakarta\resources\views/admin/statistik/_filter-statistik.blade.php ENDPATH**/ ?>