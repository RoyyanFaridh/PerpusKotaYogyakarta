<div id="modalEditLokasi"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm px-4">

    <div class="absolute inset-0" onclick="tutupModalEditLokasi()"></div>

    <div class="relative z-10 w-full max-w-lg rounded-xl bg-white border border-neutral-200 overflow-hidden shadow-lg">

        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-neutral-100">
            <div>
                <h2 class="text-sm font-semibold text-neutral-800">Edit Lokasi</h2>
                <p class="text-xs text-neutral-400 mt-0.5">Perbarui data lokasi perpustakaan</p>
            </div>
            <button type="button" onclick="tutupModalEditLokasi()"
                    class="p-1 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form id="formEditLokasi" method="POST" action="" class="px-6 py-5 flex flex-col gap-4">
            @csrf
            @method('PUT')

            {{-- Nama Lokasi --}}
            <div class="flex flex-col gap-1.5">
                <label for="edit_nama_lokasi" class="text-xs font-medium text-neutral-700">
                    Nama Lokasi <span class="text-danger-500">*</span>
                </label>
                <input type="text" id="edit_nama_lokasi" name="nama_lokasi"
                       placeholder="Contoh: Perpustakaan Pusat"
                       class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                <p id="edit_err_nama_lokasi" class="hidden text-xs text-danger-500">Nama lokasi wajib diisi.</p>
            </div>

            {{-- Alamat --}}
            <div class="flex flex-col gap-1.5">
                <label for="edit_alamat" class="text-xs font-medium text-neutral-700">
                    Alamat <span class="text-danger-500">*</span>
                </label>
                <textarea id="edit_alamat" name="alamat" rows="3"
                          placeholder="Masukkan alamat lengkap lokasi"
                          class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition resize-none"></textarea>
                <p id="edit_err_alamat" class="hidden text-xs text-danger-500">Alamat wajib diisi.</p>
            </div>

            {{-- No. Telepon --}}
            <div class="flex flex-col gap-1.5">
                <label for="edit_no_telp" class="text-xs font-medium text-neutral-700">Nomor Telepon</label>
                <input type="text" id="edit_no_telp" name="no_telp"
                       maxlength="15" placeholder="Contoh: 0274123456"
                       class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
            </div>

            {{-- Penanggung Jawab --}}
            <div class="flex flex-col gap-1.5">
                <label for="edit_user_id" class="text-xs font-medium text-neutral-700">
                    Penanggung Jawab <span class="text-danger-500">*</span>
                </label>
                <select id="edit_user_id" name="user_id"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                    <option value="">-- Pilih User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->nama }}</option>
                    @endforeach
                </select>
                <p id="edit_err_user_id" class="hidden text-xs text-danger-500">Penanggung jawab wajib dipilih.</p>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-2 pt-2 border-t border-neutral-100">
                <button type="button" onclick="tutupModalEditLokasi()"
                        class="px-4 py-2 text-xs font-medium rounded-lg border border-neutral-200 text-neutral-600 hover:bg-neutral-50 transition">
                    Batal
                </button>
                <button type="button" onclick="submitEditLokasi()"
                        class="px-4 py-2 text-xs font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const editLokasiFields = [
        { fieldId: 'edit_nama_lokasi', errId: 'edit_err_nama_lokasi' },
        { fieldId: 'edit_alamat',      errId: 'edit_err_alamat'      },
        { fieldId: 'edit_user_id',     errId: 'edit_err_user_id'     },
    ];

    function resetErrorsEditLokasi() {
        editLokasiFields.forEach(({ fieldId, errId }) => {
            const input = document.getElementById(fieldId);
            const err   = document.getElementById(errId);
            if (input) {
                input.classList.remove('border-danger-400', 'bg-danger-50');
                input.classList.add('border-neutral-200');
            }
            if (err) err.classList.add('hidden');
        });
    }

    function setErrorEditLokasi(fieldId, errId, show, msg) {
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

    function bukaModalEditLokasi(data) {
        document.getElementById('formEditLokasi').action = `/admin/lokasi/${data.id}`;
        document.getElementById('edit_nama_lokasi').value = data.nama_lokasi ?? '';
        document.getElementById('edit_alamat').value      = data.alamat      ?? '';
        document.getElementById('edit_no_telp').value     = data.no_telp     ?? '';
        document.getElementById('edit_user_id').value     = data.user_id     ?? '';

        resetErrorsEditLokasi();

        const modal = document.getElementById('modalEditLokasi');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function tutupModalEditLokasi() {
        const modal = document.getElementById('modalEditLokasi');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
        resetErrorsEditLokasi();
    }

    function submitEditLokasi() {
        const nama   = document.getElementById('edit_nama_lokasi').value.trim();
        const alamat = document.getElementById('edit_alamat').value.trim();
        const userId = document.getElementById('edit_user_id').value;

        const errNama   = !nama;
        const errAlamat = !alamat;
        const errUser   = !userId;

        setErrorEditLokasi('edit_nama_lokasi', 'edit_err_nama_lokasi', errNama,   'Nama lokasi wajib diisi.');
        setErrorEditLokasi('edit_alamat',      'edit_err_alamat',      errAlamat, 'Alamat wajib diisi.');
        setErrorEditLokasi('edit_user_id',     'edit_err_user_id',     errUser,   'Penanggung jawab wajib dipilih.');

        if (errNama || errAlamat || errUser) return;

        document.getElementById('formEditLokasi').submit();
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') tutupModalEditLokasi();
    });
</script>