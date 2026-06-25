<div id="modalRelokasi"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 backdrop-blur-sm px-4">

    <div class="absolute inset-0" onclick="tutupModalRelokasi()"></div>

    <div class="relative z-10 w-full max-w-md rounded-2xl bg-white overflow-hidden shadow-xl">

        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        
        <div class="flex items-center justify-between px-6 pt-6 pb-5 border-b border-neutral-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-primary-50 flex items-center justify-center shrink-0">
                    <svg class="w-4.5 h-4.5 text-primary-600" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-neutral-800">Pindah Eksemplar</h2>
                    <p id="relokasi-subtitle" class="text-xs text-neutral-400 mt-0.5 truncate max-w-55"></p>
                </div>
            </div>
            <button type="button" onclick="tutupModalRelokasi()"
                    aria-label="Tutup modal"
                    class="p-2 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        
        <div class="px-6 py-6 flex flex-col gap-5">

            
            <div class="flex items-center gap-2">
                
                <div class="flex-1 rounded-xl border border-neutral-200 bg-neutral-50 px-4 py-3">
                    <p class="text-[0.65rem] font-medium text-neutral-400 uppercase tracking-wide mb-1">Dari</p>
                    <p id="relokasi-sumber-nama" class="text-sm font-semibold text-neutral-800 truncate"></p>
                    <div class="flex items-center gap-1.5 mt-1.5">
                        <span class="inline-flex items-center gap-1 text-[0.68rem] font-medium text-neutral-500 bg-white border border-neutral-200 rounded-md px-1.5 py-0.5">
                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                            </svg>
                            <span id="relokasi-sumber-stok"></span> eks
                        </span>
                    </div>
                </div>

                
                <div class="flex flex-col items-center gap-1 shrink-0">
                    <div class="w-7 h-7 rounded-full bg-primary-100 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-primary-600" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                        </svg>
                    </div>
                </div>

                
                <div class="flex-1 rounded-xl border border-primary-200 bg-primary-50 px-4 py-3">
                    <p class="text-[0.65rem] font-medium text-primary-400 uppercase tracking-wide mb-1">Ke</p>
                    <p id="relokasi-tujuan-preview" class="text-sm font-semibold text-primary-700 truncate">—</p>
                    <div class="mt-1.5 h-5"></div>
                </div>
            </div>

            
            <div class="flex flex-col gap-1.5">
                <div class="flex items-center justify-between">
                    <label for="relokasi_jumlah" class="text-xs font-medium text-neutral-700">
                        Jumlah dipindah <span class="text-danger-500">*</span>
                    </label>
                    <span id="relokasi-jumlah-hint" class="text-[0.68rem] text-neutral-400"></span>
                </div>
                <input type="number" id="relokasi_jumlah" min="1" placeholder="0"
                       class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
            </div>

            
            <div class="flex flex-col gap-1.5">
                <label for="relokasi_paket_tujuan" class="text-xs font-medium text-neutral-700">
                    Paket tujuan <span class="text-danger-500">*</span>
                </label>
                <select id="relokasi_paket_tujuan"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white">
                    <option value="">Pilih paket tujuan</option>
                    <?php $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($paket->id); ?>">
                            <?php echo e($paket->nama); ?>

                            <?php if($paket->lokasi): ?>
                                — <?php echo e($paket->lokasi->nama_lokasi); ?>

                            <?php endif; ?>
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <p id="relokasi-error"
               class="hidden text-xs text-danger-600 bg-danger-50 border border-danger-100 rounded-lg px-3 py-2.5"></p>

        </div>

        
        <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-neutral-100 bg-neutral-50">
            <button type="button" onclick="tutupModalRelokasi()"
                    class="text-sm font-medium px-4 py-2 rounded-lg text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 transition-colors">
                Batal
            </button>
            <button type="button" onclick="submitRelokasi()"
                    id="relokasi-submit-btn"
                    class="inline-flex items-center gap-2 text-sm font-medium px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                </svg>
                Pindahkan
            </button>
        </div>

    </div>
</div>

<script>
    let _relokasiData = {};

    function bukaModalRelokasi(data) {
        _relokasiData = data;

        document.getElementById('relokasi-subtitle').textContent    = data.judul;
        document.getElementById('relokasi-sumber-nama').textContent = data.paket_nama;
        document.getElementById('relokasi-sumber-stok').textContent = data.stok;
        document.getElementById('relokasi-jumlah-hint').textContent = 'Maks. ' + data.stok + ' eks';
        document.getElementById('relokasi_jumlah').max              = data.stok;
        document.getElementById('relokasi_jumlah').value            = '';
        document.getElementById('relokasi_paket_tujuan').value      = '';
        document.getElementById('relokasi-tujuan-preview').textContent = '—';

        const errorEl = document.getElementById('relokasi-error');
        errorEl.classList.add('hidden');
        errorEl.textContent = '';

        const el = document.getElementById('modalRelokasi');
        el.classList.remove('hidden');
        el.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function tutupModalRelokasi() {
        const el = document.getElementById('modalRelokasi');
        el.classList.add('hidden');
        el.classList.remove('flex');
        document.body.style.overflow = '';
    }

    // Update preview tujuan saat dropdown berubah
    document.getElementById('relokasi_paket_tujuan')?.addEventListener('change', function () {
        const label = this.options[this.selectedIndex]?.text ?? '—';
        document.getElementById('relokasi-tujuan-preview').textContent = this.value ? label : '—';
    });

    async function submitRelokasi() {
        const jumlah      = parseInt(document.getElementById('relokasi_jumlah').value);
        const paketTujuan = document.getElementById('relokasi_paket_tujuan').value;
        const errorEl     = document.getElementById('relokasi-error');
        const btn         = document.getElementById('relokasi-submit-btn');

        errorEl.classList.add('hidden');
        errorEl.textContent = '';

        if (!jumlah || jumlah < 1) {
            errorEl.textContent = 'Jumlah harus diisi minimal 1.';
            errorEl.classList.remove('hidden');
            return;
        }
        if (jumlah > _relokasiData.stok) {
            errorEl.textContent = `Jumlah melebihi stok tersedia (${_relokasiData.stok}).`;
            errorEl.classList.remove('hidden');
            return;
        }
        if (!paketTujuan) {
            errorEl.textContent = 'Paket tujuan harus dipilih.';
            errorEl.classList.remove('hidden');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = `<svg class="w-3.5 h-3.5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Memindahkan...`;

        try {
            const res = await fetch(`/admin/buku/${_relokasiData.buku_id}/relokasi`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    eksemplar_id: _relokasiData.eksemplar_id,
                    paket_tujuan: paketTujuan,
                    jumlah,
                }),
            });

            const json = await res.json();

            if (!res.ok || !json.success) {
                errorEl.textContent = json.message ?? 'Terjadi kesalahan.';
                errorEl.classList.remove('hidden');
                return;
            }

            tutupModalRelokasi();
            window.location.reload();

        } catch (e) {
            errorEl.textContent = 'Gagal terhubung ke server.';
            errorEl.classList.remove('hidden');
        } finally {
            btn.disabled = false;
            btn.innerHTML = `<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg> Pindahkan`;
        }
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') tutupModalRelokasi();
    });
</script><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/admin/buku/relokasi.blade.php ENDPATH**/ ?>