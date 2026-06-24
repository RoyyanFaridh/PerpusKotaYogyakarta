
<?php $__env->startSection('title', 'Statistik Transaksi'); ?>
<?php $__env->startSection('page-title', 'Statistik Transaksi'); ?>
<?php $__env->startSection('page-subtitle', 'Jumlah transaksi tukar buku'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex flex-col gap-5">

    
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>
        <div class="p-4 flex flex-wrap items-end justify-between gap-3">
            <?php echo $__env->make('admin.statistik._filter-statistik', ['routeName' => 'admin.statistik.transaksi'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <a href="<?php echo e(route('admin.statistik.transaksi.export', request()->only(['tahun', 'bulan']))); ?>"
                title="Export Excel"
                class="flex items-center gap-1.5 px-2.5 py-2 sm:px-3.5 rounded-lg text-xs font-medium text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">
                <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                <span class="hidden sm:inline">Export Excel</span>
            </a>
        </div>
    </div>

    
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>
        <div class="grid grid-cols-1 sm:grid-cols-3">
            <div class="px-5 py-3.5 flex flex-col gap-0.5">
                <span class="text-xs text-neutral-400 font-medium">Total Transaksi</span>
                <span class="text-2xl font-semibold tabular-nums text-neutral-800"><?php echo e(number_format($totalPeriode, 0, ',', '.')); ?></span>
            </div>
            <div class="px-5 py-3.5 flex flex-col gap-0.5 sm:border-l border-neutral-100 border-t sm:border-t-0">
                <span class="text-xs text-neutral-400 font-medium">Periode</span>
                <span class="text-2xl font-semibold tabular-nums text-neutral-800">
                    <?php echo e($mode === 'harian' ? \Carbon\Carbon::create($tahun, $bulan, 1)->translatedFormat('F Y') : $tahun); ?>

                </span>
            </div>
            <div class="px-5 py-3.5 flex flex-col gap-0.5 sm:border-l border-neutral-100 border-t sm:border-t-0">
                <span class="text-xs text-neutral-400 font-medium">Rata-rata per <?php echo e($mode === 'harian' ? 'hari' : 'bulan'); ?></span>
                <span class="text-2xl font-semibold tabular-nums text-primary-700">
                    <?php echo e(count($values) > 0 ? number_format($totalPeriode / count($values), 1, ',', '.') : 0); ?>

                </span>
            </div>
        </div>
    </div>

    
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>
        <div class="p-5">
            <div class="relative" style="height: 360px;">
                <canvas id="chartTransaksi"></canvas>
            </div>
        </div>
    </div>

</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.0/chart.umd.min.js"></script>
<script>
    (function () {
        const ctx = document.getElementById('chartTransaksi');
        const labels = <?php echo json_encode($labels, 15, 512) ?>;
        const values = <?php echo json_encode($values, 15, 512) ?>;
        const mode = <?php echo json_encode($mode, 15, 512) ?>;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: mode === 'harian' ? 'Transaksi per hari' : 'Transaksi per bulan',
                    data: values,
                    fill: true,
                    backgroundColor: 'rgba(37, 99, 235, 0.15)',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    pointRadius: 3,
                    pointBackgroundColor: 'rgba(37, 99, 235, 1)',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            title: (items) => mode === 'harian' ? `Tanggal ${items[0].label}` : items[0].label,
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        title: {
                            display: true,
                            text: mode === 'harian' ? 'Tanggal' : 'Bulan',
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 },
                        title: { display: true, text: 'Jumlah Transaksi' }
                    }
                }
            }
        });
    })();
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Perkuliahan Duniawi\MAGANG GES\PerpusKotaYogyakarta\resources\views/admin/statistik/transaksi.blade.php ENDPATH**/ ?>