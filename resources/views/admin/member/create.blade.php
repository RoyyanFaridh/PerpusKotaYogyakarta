<div id="modalTambahMember"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm px-4">

    <div class="absolute inset-0" onclick="tutupModalMember()"></div>

    <div class="relative z-10 w-full max-w-md rounded-2xl bg-white overflow-hidden shadow-xl">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="flex items-center justify-between px-6 sm:px-8 pt-6 pb-5 border-b border-neutral-100 shrink-0">
            <div>
                <h2 class="text-base font-semibold text-neutral-800">Tambah Member Baru</h2>
                <p class="text-sm text-neutral-400 mt-0.5">Lengkapi data member baru</p>
            </div>
            <button type="button" onclick="tutupModalMember()" aria-label="Tutup modal"
                    class="p-2 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form id="formTambahMember" method="POST" action="{{ route('admin.member.store') }}"
              class="px-6 sm:px-8 py-6 flex flex-col gap-4">
            @csrf

            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">
                        Nomor Telepon <span class="text-danger-500">*</span>
                    </label>
                    <input type="text" name="no_telp" id="tambah_no_telp"
                           maxlength="15" placeholder="08123456789"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                    <p id="err_no_telp" class="hidden text-[0.68rem] text-danger-500">Nomor telepon wajib diisi.</p>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Email</label>
                    <input type="email" name="email" id="tambah_email"
                           placeholder="contoh@email.com"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                    <p id="err_email" class="hidden text-[0.68rem] text-danger-500">Format email tidak valid.</p>
                </div>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">
                    Nama Lengkap <span class="text-danger-500">*</span>
                </label>
                <input type="text" name="nama" id="tambah_nama" placeholder="Masukkan nama lengkap"
                       class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                <p id="err_nama" class="hidden text-[0.68rem] text-danger-500">Nama lengkap wajib diisi.</p>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">
                    Alamat <span class="text-danger-500">*</span>
                </label>
                <textarea name="alamat" id="tambah_alamat" rows="3"
                          placeholder="Masukkan alamat lengkap"
                          class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition resize-none"></textarea>
                <p id="err_alamat" class="hidden text-[0.68rem] text-danger-500">Alamat wajib diisi.</p>
            </div>
        </form>

        <div class="flex items-center justify-between px-6 sm:px-8 py-4 border-t border-neutral-100 bg-neutral-50">
            <div></div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="tutupModalMember()"
                        class="text-sm font-medium px-4 py-2 rounded-lg text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 transition-colors">
                    Batal
                </button>
                <button type="button" onclick="submitTambahMember()"
                        class="text-sm font-medium px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700 transition-colors">
                    Simpan Member
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function bukaModalMember() {
        const el = document.getElementById('modalTambahMember');
        el.classList.remove('hidden');
        el.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function tutupModalMember() {
        const el = document.getElementById('modalTambahMember');
        el.classList.add('hidden');
        el.classList.remove('flex');
        document.body.style.overflow = '';
        ['no_telp', 'nama', 'alamat', 'email'].forEach(f => {
            document.getElementById('err_' + f)?.classList.add('hidden');
            document.getElementById('tambah_' + f)?.classList.remove('border-danger-400');
        });
    }

    function submitTambahMember() {
        const noTelp = document.getElementById('tambah_no_telp').value.trim();
        const nama   = document.getElementById('tambah_nama').value.trim();
        const alamat = document.getElementById('tambah_alamat').value.trim();
        const email  = document.getElementById('tambah_email').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const errEmail = email !== '' && !emailRegex.test(email);

        const setErr = (id, errId, show) => {
            const input = document.getElementById(id);
            const err   = document.getElementById(errId);
            if (!input || !err) return;
            err.classList.toggle('hidden', !show);
            input.classList.toggle('border-danger-400', show);
            input.classList.toggle('border-neutral-200', !show);
        };

        setErr('tambah_no_telp', 'err_no_telp', !noTelp);
        setErr('tambah_nama',    'err_nama',    !nama);
        setErr('tambah_alamat',  'err_alamat',  !alamat);
        setErr('tambah_email',   'err_email',   errEmail);

        if (!noTelp || !nama || !alamat || errEmail) return;
        document.getElementById('formTambahMember').submit();
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') tutupModalMember();
    });
</script>