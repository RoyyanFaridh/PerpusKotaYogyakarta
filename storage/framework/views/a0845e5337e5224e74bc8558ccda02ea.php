<?php $__env->startSection('title', 'Transaksi'); ?>
<?php $__env->startSection('page-title', 'Transaksi'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola data transaksi tukar buku'); ?>

<?php $__env->startPush('scripts'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

    <script>
        window.Routes = {
            transaksiStore: "<?php echo e(route('admin.transaksi.store')); ?>",
            setLokasi:      "<?php echo e(route('admin.transaksi.set-lokasi')); ?>",
        };
        window.LokasiData = {
            lokasiPilihan:   <?php echo json_encode($lokasiPilihan, 15, 512) ?>,
            activeLokasiId:  <?php echo json_encode($activeLokasiId, 15, 512) ?>,
            jumlahPenugasan: <?php echo e($lokasiPilihan->count()); ?>,
            isSuperAdmin:    <?php echo json_encode(auth()->user()->isSuperAdmin(), 15, 512) ?>,
        };
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '<?php echo e(csrf_token()); ?>';
    </script>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/transaksi-wizard.js'); ?>
    
    <script>
        (function initFilters() {
            const searchInput   = document.getElementById('searchInput');
            const filterTanggal = document.getElementById('filterTanggalRange');
            const resetFilter   = document.getElementById('resetFilter');
            const filterLokasi  = document.getElementById('filterLokasi');

            if (!searchInput && !filterTanggal && !filterLokasi) return;

            function applyFilters() {
                const params = new URLSearchParams(window.location.search);
                const search = searchInput?.value.trim();
                search ? params.set('search', search) : params.delete('search');
                const lokasi = filterLokasi?.value;
                lokasi ? params.set('lokasi', lokasi) : params.delete('lokasi');
                params.delete('page');
                window.location.href = '?' + params.toString();
            }

            const picker = flatpickr("#filterTanggalRange", {
                mode: "range",
                dateFormat: "d M Y",
                locale: "id",
                maxDate: "today",
                showMonths: 1,
                // INI yang fix tahun bisa diubah
                plugins: [],
                onReady: function(selectedDates, dateStr, instance) {
                    // Enable year input to be editable
                    const yearEl = instance.currentYearElement;
                    if (yearEl) {
                        yearEl.removeAttribute('readonly');
                        yearEl.style.pointerEvents = 'auto';
                    }
                },
                onChange: function(selectedDates) {
                    if (selectedDates.length === 2) {
                        const mulai = flatpickr.formatDate(selectedDates[0], "Y-m-d");
                        const akhir = flatpickr.formatDate(selectedDates[1], "Y-m-d");
                        const params = new URLSearchParams(window.location.search);
                        params.set('tanggal_mulai', mulai);
                        params.set('tanggal_akhir', akhir);
                        params.delete('page');
                        window.location.href = '?' + params.toString();
                    }
                }
            });

            const params = new URLSearchParams(window.location.search);
            const tanggalMulai = params.get('tanggal_mulai');
            const tanggalAkhir = params.get('tanggal_akhir');
            if (tanggalMulai && tanggalAkhir) {
                picker.setDate([new Date(tanggalMulai), new Date(tanggalAkhir)], false);
            }

            if (searchInput && params.get('search')) searchInput.value = params.get('search');
            if (filterLokasi && params.get('lokasi')) filterLokasi.value = params.get('lokasi');

            let searchTimer;
            searchInput?.addEventListener('input', () => {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(applyFilters, 400);
            });

            filterLokasi?.addEventListener('change', applyFilters);
            resetFilter?.addEventListener('click', () => {
                searchInput.value = '';
                picker.clear();
                filterLokasi.value = '';
                window.location.href = window.location.pathname;
            });
        })();
    </script>

    <style>
    .flatpickr-calendar {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.10);
        font-family: 'Poppins', sans-serif;
        padding: 0;
        overflow: hidden;
        width: 300px !important;
    }

    /* === HEADER === */
    .flatpickr-months {
        background: white;
        padding: 12px 8px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .flatpickr-month {
        height: auto;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: visible;
    }

    .flatpickr-current-month {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
        padding: 0;
        position: static;
        width: auto;
        left: unset;
        transform: none;
        display: flex;
        align-items: center;
        gap: 2px;
    }

    .flatpickr-current-month .flatpickr-monthDropdown-months {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
        background: transparent;
        border: none;
        padding: 2px 6px;
        cursor: pointer;
        border-radius: 4px;
        -webkit-appearance: none;
        appearance: none;
    }

    .flatpickr-current-month .flatpickr-monthDropdown-months:hover {
        background: #f3f4f6;
    }

    .flatpickr-current-month input.cur-year {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
        background: transparent;
        border: none;
        padding: 2px 4px;
        border-radius: 4px;
        width: 52px;
        pointer-events: auto !important;
        cursor: text;
    }

    .flatpickr-current-month input.cur-year:hover,
    .flatpickr-current-month input.cur-year:focus {
        background: #f3f4f6;
        outline: none;
    }

    .flatpickr-current-month .numInputWrapper {
        display: flex;
        align-items: center;
    }

    .flatpickr-current-month .arrowUp,
    .flatpickr-current-month .arrowDown {
        display: block !important;
        opacity: 0.4;
        padding: 0 2px;
    }

    .flatpickr-current-month .arrowUp:hover,
    .flatpickr-current-month .arrowDown:hover {
        opacity: 1;
    }

    /* Nav arrows prev/next */
    .flatpickr-prev-month,
    .flatpickr-next-month {
        position: static !important;
        width: 30px;
        height: 30px;
        display: flex !important;
        align-items: center;
        justify-content: center;
        padding: 0;
        margin: 0;
        border-radius: 6px;
        color: #6b7280;
        fill: #6b7280;
        transition: background 120ms;
        flex-shrink: 0;
    }

    .flatpickr-prev-month:hover,
    .flatpickr-next-month:hover {
        background: #f3f4f6;
        color: #111827;
        fill: #111827;
    }

    .flatpickr-prev-month svg,
    .flatpickr-next-month svg {
        width: 14px;
        height: 14px;
    }

    /* === WEEKDAYS === */
    .flatpickr-weekdays {
        background: white;
        padding: 8px 12px 4px;
    }

    span.flatpickr-weekday {
        font-size: 11px;
        font-weight: 500;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    /* === DAYS === */
    .flatpickr-days {
        padding: 4px 12px 14px;
        border: none;
    }

    .dayContainer {
        padding: 0;
        min-width: unset;
        max-width: unset;
        width: 100%;
    }

    .flatpickr-day {
        font-size: 13px;
        font-weight: 400;
        color: #374151;
        height: 38px;
        line-height: 38px;
        max-width: 38px;
        border-radius: 8px;
        border: 1.5px solid transparent;
        margin: 2px;
        transition: background 120ms, color 120ms, border-color 120ms;
        flex-basis: calc(14.28% - 4px) !important;
    }

    .flatpickr-day:not(.disabled):not(.flatpickr-disabled):not(.prevMonthDay):not(.nextMonthDay):hover {
        background: #f3f4f6;
        border-color: #e5e7eb;
        color: #111827;
    }

    .flatpickr-day.prevMonthDay,
    .flatpickr-day.nextMonthDay {
        color: #d1d5db;
    }

    .flatpickr-day.today {
        border-color: #04448D;
        color: #04448D;
        font-weight: 600;
    }

    .flatpickr-day.selected,
    .flatpickr-day.startRange,
    .flatpickr-day.endRange {
        background: #04448D;
        border-color: #04448D;
        color: white;
        font-weight: 500;
    }

    .flatpickr-day.startRange {
        border-radius: 8px 0 0 8px;
    }

    .flatpickr-day.endRange {
        border-radius: 0 8px 8px 0;
    }

    .flatpickr-day.startRange.endRange {
        border-radius: 8px;
    }

    .flatpickr-day.today.selected,
    .flatpickr-day.today.startRange,
    .flatpickr-day.today.endRange {
        background: #04448D;
        border-color: #04448D;
        color: white;
    }

    .flatpickr-day.inRange {
        background: rgba(4, 68, 141, 0.08);
        border-color: transparent;
        color: #1e3a5f;
        border-radius: 0;
    }

    .flatpickr-day.flatpickr-disabled,
    .flatpickr-day.disabled {
        color: #e5e7eb;
        cursor: not-allowed;
    }

    .flatpickr-day.flatpickr-disabled:hover {
        background: transparent;
        border-color: transparent;
    }

    .flatpickr-day:focus {
        outline: 2px solid rgba(4, 68, 141, 0.4);
        outline-offset: 1px;
    }

    @media (prefers-reduced-motion: reduce) {
        .flatpickr-day,
        .flatpickr-prev-month,
        .flatpickr-next-month {
            transition: none;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col gap-5">

    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="flex items-center justify-between gap-4 px-5 pt-5 pb-4 border-b border-neutral-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-700 flex items-center justify-center shrink-0">
                    <?php if (isset($component)) { $__componentOriginale36e5352d74b36d28beebc0751e682d3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale36e5352d74b36d28beebc0751e682d3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.transaksi','data' => ['class' => 'w-5 h-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.transaksi'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale36e5352d74b36d28beebc0751e682d3)): ?>
<?php $attributes = $__attributesOriginale36e5352d74b36d28beebc0751e682d3; ?>
<?php unset($__attributesOriginale36e5352d74b36d28beebc0751e682d3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale36e5352d74b36d28beebc0751e682d3)): ?>
<?php $component = $__componentOriginale36e5352d74b36d28beebc0751e682d3; ?>
<?php unset($__componentOriginale36e5352d74b36d28beebc0751e682d3); ?>
<?php endif; ?>
                </div>
                <div>
                    <p class="text-sm font-semibold text-neutral-800 leading-tight">Semua Transaksi</p>
                    <p class="text-xs text-neutral-400 leading-tight"><?php echo e($transaksi->total()); ?> transaksi terdaftar</p>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <?php
                    $lokasiParams = $paketUser ? '?lokasi=' . urlencode($paketUser->lokasi?->nama_lokasi ?? '') : '';
                ?>
                <a href="<?php echo e(route('admin.transaksi.export')); ?><?php echo e($lokasiParams); ?>"
                    title="Export Excel"
                    class="flex items-center gap-1.5 px-2.5 py-2 sm:px-3.5 rounded-lg text-xs font-medium text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">
                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    <span class="hidden sm:inline">Export Excel</span>
                </a>
                <button type="button"
                        onclick="openModal()"
                        title="Tambah Transaksi"
                        class="flex items-center gap-1.5 px-2.5 py-2 sm:px-3.5 rounded-lg text-xs font-semibold text-white bg-primary-600 hover:bg-primary-700 transition-colors">
                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    <span class="hidden sm:inline">Tambah Transaksi</span>
                </button>
            </div>
        </div>

        
        <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-neutral-100 border-b border-neutral-100">
            <?php $__currentLoopData = [
                ['label' => 'Total',      'value' => $transaksi->total(), 'color' => 'text-neutral-800'],
                ['label' => 'Hari Ini',   'value' => $transaksiHariIni,  'color' => 'text-primary-700'],
                ['label' => 'Minggu Ini', 'value' => $transaksiMingguIni,'color' => 'text-success-700'],
                ['label' => 'Bulan Ini',  'value' => $transaksiBulanIni, 'color' => 'text-primary-700'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="px-5 py-3.5 flex flex-col gap-0.5">
                <span class="text-xs text-neutral-400 font-medium"><?php echo e($stat['label']); ?></span>
                <span class="text-2xl font-semibold tabular-nums <?php echo e($stat['color']); ?>"><?php echo e($stat['value']); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="flex items-center gap-3 px-5 py-3.5">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input
                    id="searchInput"
                    type="text"
                    placeholder="Cari member, buku..."
                    class="w-full pl-9 pr-4 py-2 text-sm text-neutral-700 bg-neutral-50 border border-neutral-200 rounded-lg placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"
                />
            </div>
            <input type="text" 
                   id="filterTanggalRange"
                   class="px-3 py-2 text-sm text-neutral-600 bg-neutral-50 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition whitespace-nowrap"
                   placeholder="Pilih rentang waktu">
            <select id="filterLokasi"
                    class="px-3 py-2 text-sm text-neutral-600 bg-neutral-50 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition shrink-0">
                <option value="">Semua Lokasi</option>
                <?php $__currentLoopData = $lokasiList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($lokasi); ?>"><?php echo e($lokasi); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button id="resetFilter" 
                    class="px-3 py-2 text-xs text-neutral-500 hover:text-neutral-700 transition shrink-0">
                Reset
            </button>
        </div>
    </div>

    
    <div class="relative overflow-hidden rounded-xl bg-white border border-neutral-200">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <?php if(session('success')): ?>
            <div class="flex items-center gap-2.5 px-5 py-3 bg-success-50 border-b border-success-100 text-success-700 text-sm font-medium">
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-100 bg-neutral-50">
                        <th class="text-center text-xs font-semibold text-neutral-500 px-2 py-3 w-12">No.</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-2 py-3">ID</th>
                        <th class="text-left   text-xs font-semibold text-neutral-500 px-4 py-3">Member</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Buku Masuk</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Buku Keluar</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Tanggal & Lokasi</th>
                        <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50" id="tableBody">
                    <?php $__empty_1 = true; $__currentLoopData = $transaksi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $txnId = '#TXN-' . str_pad($item->id, 4, '0', STR_PAD_LEFT);
                            $nomor = ($transaksi->perPage() * ($transaksi->currentPage() - 1)) + $loop->iteration;
                        ?>
                        <tr class="hover:bg-neutral-50 transition-colors table-row-data"
                            data-search="<?php echo e(strtolower($item->member?->nama ?? '')); ?> <?php echo e(strtolower($item->bukuMasuk?->buku?->judul ?? '')); ?> <?php echo e(strtolower($item->bukuKeluar?->buku?->judul ?? '')); ?>">

                            <td class="px-2 py-3.5 text-center">
                                <span class="text-xs font-mono font-medium text-neutral-500"><?php echo e($nomor); ?></span>
                            </td>

                            <td class="px-2 py-3.5 text-center">
                                <span class="text-xs font-mono font-medium text-neutral-500"><?php echo e($txnId); ?></span>
                            </td>

                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white text-xs font-bold shrink-0">
                                        <?php echo e(strtoupper(substr($item->member->nama ?? 'U', 0, 1))); ?>

                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-neutral-800 leading-tight"><?php echo e($item->member->nama ?? '-'); ?></p>
                                        <p class="text-xs text-neutral-400"><?php echo e($item->member->no_telp ?? ''); ?></p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3.5 max-w-40 text-center">
                                <p class="text-sm font-medium text-neutral-700 truncate"><?php echo e($item->bukuMasuk?->buku?->judul ?? '-'); ?></p>
                                <p class="text-xs text-neutral-400 mt-0.5"><?php echo e($item->bukuMasuk?->buku?->pengarang ?? ''); ?></p>
                            </td>

                            <td class="px-4 py-3.5 max-w-40 text-center">
                                <p class="text-sm font-medium text-neutral-700 truncate"><?php echo e($item->bukuKeluar?->buku?->judul ?? '-'); ?></p>
                                <p class="text-xs text-neutral-400 mt-0.5"><?php echo e($item->bukuKeluar?->buku?->pengarang ?? ''); ?></p>
                            </td>

                            <td class="px-4 py-3.5 text-center">
                                <p class="text-sm font-medium text-neutral-700"><?php echo e($item->lokasi_snapshot ?? '-'); ?></p>
                                <p class="text-xs text-neutral-400 mt-0.5"><?php echo e($item->tanggal_tukar?->format('d M Y') ?? '-'); ?></p>
                            </td>

                            <td class="px-4 py-3.5">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="button"
                                            onclick="openEditTransaksi(<?php echo e($item->id); ?>)"
                                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-warning-300 hover:text-warning-600 hover:bg-warning-50 transition-colors">
                                        <?php if (isset($component)) { $__componentOriginal32022bdceaa704d305484041fc21cb4a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal32022bdceaa704d305484041fc21cb4a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.edit','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.edit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal32022bdceaa704d305484041fc21cb4a)): ?>
<?php $attributes = $__attributesOriginal32022bdceaa704d305484041fc21cb4a; ?>
<?php unset($__attributesOriginal32022bdceaa704d305484041fc21cb4a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal32022bdceaa704d305484041fc21cb4a)): ?>
<?php $component = $__componentOriginal32022bdceaa704d305484041fc21cb4a; ?>
<?php unset($__componentOriginal32022bdceaa704d305484041fc21cb4a); ?>
<?php endif; ?>
                                        <span>Edit</span>
                                    </button>
                                    <button type="button"
                                            onclick="bukaModalHapusTransaksi(
                                                '<?php echo e(route('admin.transaksi.destroy', $item)); ?>',
                                                '<?php echo e($txnId); ?>'
                                            )"
                                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-neutral-500 border border-neutral-200 hover:border-danger-300 hover:text-danger-600 hover:bg-danger-50 transition-colors">
                                        <?php if (isset($component)) { $__componentOriginalab518ebc45c56ecd96af42eff2f09240 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab518ebc45c56ecd96af42eff2f09240 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.delete','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-5 py-14 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-11 h-11 rounded-xl bg-neutral-100 flex items-center justify-center">
                                        <?php if (isset($component)) { $__componentOriginale36e5352d74b36d28beebc0751e682d3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale36e5352d74b36d28beebc0751e682d3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.transaksi','data' => ['class' => 'w-5 h-5 text-neutral-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.transaksi'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-neutral-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale36e5352d74b36d28beebc0751e682d3)): ?>
<?php $attributes = $__attributesOriginale36e5352d74b36d28beebc0751e682d3; ?>
<?php unset($__attributesOriginale36e5352d74b36d28beebc0751e682d3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale36e5352d74b36d28beebc0751e682d3)): ?>
<?php $component = $__componentOriginale36e5352d74b36d28beebc0751e682d3; ?>
<?php unset($__componentOriginale36e5352d74b36d28beebc0751e682d3); ?>
<?php endif; ?>
                                    </div>
                                    <p class="text-sm font-medium text-neutral-500">Belum ada transaksi</p>
                                    <p class="text-xs text-neutral-400">Klik "Tambah Transaksi" untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <tr id="noResultRow" class="hidden">
                        <td colspan="6" class="px-5 py-10 text-center text-sm text-neutral-400">
                            Tidak ada hasil yang cocok.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <?php if($transaksi->hasPages()): ?>
            <div class="px-5 py-3.5 bg-neutral-50 border-t border-neutral-100 flex items-center justify-between gap-4 flex-wrap">
                <p class="text-xs text-neutral-400">
                    Menampilkan
                    <span class="font-semibold text-neutral-600"><?php echo e($transaksi->firstItem()); ?></span>–<span class="font-semibold text-neutral-600"><?php echo e($transaksi->lastItem()); ?></span>
                    dari <span class="font-semibold text-neutral-600"><?php echo e($transaksi->total()); ?></span> transaksi
                </p>
                <div class="flex items-center gap-1">
                    <?php if($transaksi->onFirstPage()): ?>
                        <span class="px-3 py-1.5 rounded-lg text-xs text-neutral-300 border border-neutral-100 cursor-not-allowed">← Prev</span>
                    <?php else: ?>
                        <a href="<?php echo e($transaksi->previousPageUrl()); ?>" class="px-3 py-1.5 rounded-lg text-xs text-primary-600 border border-neutral-200 hover:bg-primary-50 transition-colors">← Prev</a>
                    <?php endif; ?>

                    <?php $__currentLoopData = $transaksi->getUrlRange(1, $transaksi->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $transaksi->currentPage()): ?>
                            <span class="px-3 py-1.5 rounded-lg text-xs bg-primary-600 text-white font-semibold"><?php echo e($page); ?></span>
                        <?php else: ?>
                            <a href="<?php echo e($url); ?>" class="px-3 py-1.5 rounded-lg text-xs text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors"><?php echo e($page); ?></a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if($transaksi->hasMorePages()): ?>
                        <a href="<?php echo e($transaksi->nextPageUrl()); ?>" class="px-3 py-1.5 rounded-lg text-xs text-primary-600 border border-neutral-200 hover:bg-primary-50 transition-colors">Next →</a>
                    <?php else: ?>
                        <span class="px-3 py-1.5 rounded-lg text-xs text-neutral-300 border border-neutral-100 cursor-not-allowed">Next →</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php echo $__env->make('admin.transaksi.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('admin.transaksi.edit', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('admin.transaksi.destroy', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Perkuliahan Duniawi\MAGANG GES\PerpusKotaYogyakarta\resources\views/admin/transaksi/index.blade.php ENDPATH**/ ?>