<div id="modalTambahKegiatan" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="tutupModalKegiatan()"></div>

    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden max-h-[90vh] flex flex-col">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-neutral-100 shrink-0">
            <div>
                <h2 class="text-sm font-semibold text-neutral-800">Tambah Kegiatan</h2>
                <p class="text-xs text-neutral-400 mt-0.5">Isi data rencana kegiatan perpustakaan</p>
            </div>
            <button onclick="tutupModalKegiatan()"
                    class="p-1.5 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form id="formTambahKegiatan" method="POST" action="<?php echo e(route('admin.kegiatan.store')); ?>"
              class="overflow-y-auto custom-scroll">
            <?php echo csrf_field(); ?>
            <div class="px-6 py-5 space-y-4">

                
                <div>
                    <label class="block text-xs font-medium text-neutral-600 mb-1">
                        Nama Kegiatan <span class="text-danger-500">*</span>
                    </label>
                    <input type="text" name="nama_kegiatan" id="tambah_nama_kegiatan"
                           value="<?php echo e(old('nama_kegiatan')); ?>"
                           placeholder="Contoh: Pameran Buku Nasional"
                           class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                    <p id="tambah_err_nama_kegiatan" class="hidden text-[0.68rem] text-danger-500 mt-1">
                        Nama kegiatan wajib diisi.
                    </p>
                </div>

                
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">
                            Tanggal Mulai <span class="text-danger-500">*</span>
                        </label>
                        <input type="date" name="tanggal_mulai" id="tambah_tanggal_mulai"
                               value="<?php echo e(old('tanggal_mulai')); ?>"
                               class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                        <p id="tambah_err_tanggal_mulai" class="hidden text-[0.68rem] text-danger-500 mt-1">
                            Tanggal mulai wajib diisi.
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">
                            Tanggal Selesai
                            <span class="text-[0.65rem] font-normal text-neutral-400 ml-1">opsional</span>
                        </label>
                        <input type="date" name="tanggal_selesai" id="tambah_tanggal_selesai"
                               value="<?php echo e(old('tanggal_selesai')); ?>"
                               class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                    </div>
                </div>

                
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">Jam Mulai</label>
                        <input type="time" name="jam_pelaksanaan" id="tambah_jam_pelaksanaan"
                               value="<?php echo e(old('jam_pelaksanaan')); ?>"
                               class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">Jam Selesai</label>
                        <input type="time" name="jam_selesai" id="tambah_jam_selesai"
                               value="<?php echo e(old('jam_selesai')); ?>"
                               class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                        <p id="tambah_err_jam_selesai" class="hidden text-[0.68rem] text-danger-500 mt-1">
                            Jam selesai harus setelah jam mulai.
                        </p>
                    </div>
                </div>

                
                <div>
                    <label class="block text-xs font-medium text-neutral-600 mb-1">
                        Lokasi Kegiatan
                        <span class="text-[0.65rem] font-normal text-neutral-400 ml-1">opsional</span>
                    </label>
                    <select name="lokasi_id" id="tambah_lokasi_id"
                            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition bg-white">
                        <option value="">— Pilih lokasi —</option>
                        <?php $__currentLoopData = \App\Models\Lokasi::orderBy('nama_lokasi')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($lokasi->id); ?>"
                                <?php echo e(old('lokasi_id') == $lokasi->id ? 'selected' : ''); ?>>
                                <?php echo e($lokasi->nama_lokasi); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div>
                    <label class="block text-xs font-medium text-neutral-600 mb-1">
                        Paket & Lokasi
                        <span class="text-[0.65rem] font-normal text-neutral-400 ml-1">opsional</span>
                    </label>
                    <div class="rounded-lg border border-neutral-200 divide-y divide-neutral-100 max-h-36 overflow-y-auto custom-scroll">
                        <?php $__currentLoopData = \App\Models\Paket::with('lokasi')->orderBy('nama')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center gap-2.5 px-3 py-2 hover:bg-primary-50 cursor-pointer transition-colors">
                                <input type="checkbox" name="paket_ids[]" value="<?php echo e($paket->id); ?>"
                                       <?php echo e(in_array($paket->id, old('paket_ids', [])) ? 'checked' : ''); ?>

                                       class="w-3.5 h-3.5 rounded border-neutral-300 text-primary-600 focus:ring-primary-300"/>
                                <span class="text-xs text-neutral-700"><?php echo e($paket->nama); ?></span>
                                <?php if($paket->lokasi): ?>
                                    <span class="text-[0.65rem] text-neutral-400 ml-auto shrink-0">
                                        <?php echo e($paket->lokasi->nama_lokasi); ?>

                                    </span>
                                <?php endif; ?>
                                <?php if(! $paket->is_aktif): ?>
                                    <span class="text-[0.65rem] text-neutral-300 ml-1">nonaktif</span>
                                <?php endif; ?>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <p class="text-[0.68rem] text-neutral-400 mt-1">
                        Paket yang dipilih akan dipindahkan sementara ke lokasi kegiatan.
                    </p>
                </div>

                
                <div>
                    <label class="block text-xs font-medium text-neutral-600 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                              placeholder="Jelaskan kegiatan secara singkat..."
                              class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition resize-none"><?php echo e(old('deskripsi')); ?></textarea>
                </div>

            </div>

            <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-neutral-100 bg-neutral-50 shrink-0">
                <button type="button" onclick="tutupModalKegiatan()"
                        class="text-xs font-medium px-4 py-2 rounded-lg border border-neutral-200 text-neutral-500 hover:bg-white transition-colors">
                    Batal
                </button>
                <button type="button" onclick="submitTambahKegiatan()"
                        class="text-xs font-medium px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition-colors">
                    Simpan Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function bukaModalKegiatan() {
        const el = document.getElementById('modalTambahKegiatan');
        el.classList.remove('hidden');
        el.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function tutupModalKegiatan() {
        const el = document.getElementById('modalTambahKegiatan');
        el.classList.add('hidden');
        el.classList.remove('flex');
        document.body.style.overflow = '';
        ['nama_kegiatan', 'tanggal_mulai', 'jam_selesai'].forEach(f => {
            document.getElementById('tambah_err_' + f)?.classList.add('hidden');
            document.getElementById('tambah_' + f)?.classList.remove('border-danger-400', 'bg-danger-50');
        });
    }

    function setErrorKegiatan(fieldId, errId, show, msg) {
        const input = document.getElementById(fieldId);
        const err   = document.getElementById(errId);
        if (!input || !err) return;
        if (show) {
            if (msg) err.textContent = msg;
            err.classList.remove('hidden');
            input.classList.add('border-danger-400', 'bg-danger-50');
            input.classList.remove('border-neutral-200');
        } else {
            err.classList.add('hidden');
            input.classList.remove('border-danger-400', 'bg-danger-50');
            input.classList.add('border-neutral-200');
        }
    }

    function submitTambahKegiatan() {
        const nama       = document.getElementById('tambah_nama_kegiatan').value.trim();
        const tanggal    = document.getElementById('tambah_tanggal_mulai').value;
        const jamMulai   = document.getElementById('tambah_jam_pelaksanaan').value;
        const jamSelesai = document.getElementById('tambah_jam_selesai').value;

        const errNama       = !nama;
        const errTanggal    = !tanggal;
        const errJamSelesai = jamMulai && jamSelesai && jamSelesai <= jamMulai;

        setErrorKegiatan('tambah_nama_kegiatan', 'tambah_err_nama_kegiatan', errNama,       'Nama kegiatan wajib diisi.');
        setErrorKegiatan('tambah_tanggal_mulai', 'tambah_err_tanggal_mulai', errTanggal,    'Tanggal mulai wajib diisi.');
        setErrorKegiatan('tambah_jam_selesai',   'tambah_err_jam_selesai',   errJamSelesai, 'Jam selesai harus setelah jam mulai.');

        if (errNama || errTanggal || errJamSelesai) return;
        document.getElementById('formTambahKegiatan').submit();
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') tutupModalKegiatan();
    });

    <?php if($errors->hasAny(['nama_kegiatan', 'tanggal_mulai', 'jam_selesai', 'deskripsi'])): ?>
        document.addEventListener('DOMContentLoaded', () => {
            bukaModalKegiatan();
            <?php if($errors->has('nama_kegiatan')): ?>
                setErrorKegiatan('tambah_nama_kegiatan', 'tambah_err_nama_kegiatan', true, '<?php echo e($errors->first('nama_kegiatan')); ?>');
            <?php endif; ?>
            <?php if($errors->has('tanggal_mulai')): ?>
                setErrorKegiatan('tambah_tanggal_mulai', 'tambah_err_tanggal_mulai', true, '<?php echo e($errors->first('tanggal_mulai')); ?>');
            <?php endif; ?>
            <?php if($errors->has('jam_selesai')): ?>
                setErrorKegiatan('tambah_jam_selesai', 'tambah_err_jam_selesai', true, '<?php echo e($errors->first('jam_selesai')); ?>');
            <?php endif; ?>
        });
    <?php endif; ?>
</script><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/admin/kegiatan/create.blade.php ENDPATH**/ ?>