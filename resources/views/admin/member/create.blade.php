<div id="modalTambahMember"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm px-4">

    <div class="absolute inset-0" onclick="tutupModalMember()"></div>

    <div class="relative z-10 w-full max-w-lg rounded-xl bg-white border border-neutral-200 overflow-hidden shadow-lg">

        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-neutral-100">
            <div>
                <h2 class="text-sm font-semibold text-neutral-800">Tambah Member Baru</h2>
                <p class="text-xs text-neutral-400 mt-0.5">Lengkapi data member baru</p>
            </div>
            <button type="button" onclick="tutupModalMember()"
                    class="p-1 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form id="formTambahMember" method="POST" action="{{ route('admin.member.store') }}"
              class="px-6 py-5 flex flex-col gap-4">
            @csrf

            {{-- No. Telepon & Email --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">
                        Nomor Telepon <span class="text-danger-500">*</span>
                    </label>
                    <input type="text" name="no_telp" id="tambah_no_telp"
                           maxlength="15" placeholder="08123456789"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                    <p id="err_no_telp" class="hidden text-[0.68rem] text-danger-500">Nomor telepon wajib diisi.</p>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Email</label>
                    <input type="email" name="email" id="tambah_email"
                           placeholder="contoh@email.com"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                    <p id="err_email" class="hidden text-[0.68rem] text-danger-500">Format email tidak valid.</p>
                </div>
            </div>

            {{-- Nama --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">
                    Nama Lengkap <span class="text-danger-500">*</span>
                </label>
                <input type="text" name="nama" id="tambah_nama"
                       placeholder="Masukkan nama lengkap"
                       class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                <p id="err_nama" class="hidden text-[0.68rem] text-danger-500">Nama lengkap wajib diisi.</p>
            </div>

            {{-- Alamat --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">
                    Alamat <span class="text-danger-500">*</span>
                </label>
                <textarea name="alamat" id="tambah_alamat" rows="3" placeholder="Masukkan alamat lengkap"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition resize-none"></textarea>
                    <p id="err_alamat" class="hidden text-[0.68rem] text-danger-500">Alamat wajib diisi.</p>
            </div>

            {{-- User --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">
                    User <span class="text-danger-500">*</span>
                </label>
                <select name="user_id" id="tambah_user_id"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                    <option value="">-- Pilih User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"
                            {{ auth()->id() == $user->id ? 'selected' : '' }}>
                            {{ $user->nama }}
                        </option>
                    @endforeach
                </select>
                <p id="err_user_id" class="hidden text-[0.68rem] text-danger-500">User wajib dipilih.</p>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-2 pt-2 border-t border-neutral-100">
                <button type="button" onclick="tutupModalMember()"
                        class="px-4 py-2 text-xs font-medium rounded-lg border border-neutral-200 text-neutral-600 hover:bg-neutral-50 transition">
                    Batal
                </button>
                <button type="button" onclick="submitTambahMember()"
                        class="px-4 py-2 text-xs font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition">
                    Simpan Member
                </button>
            </div>
        </form>
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
        resetErrorTambahMember();
    }

    function resetErrorTambahMember() {
        ['no_telp', 'nama', 'alamat', 'user_id'].forEach(field => {
            const err   = document.getElementById('err_' + field);
            const input = document.getElementById('tambah_' + field);
            if (err)   err.classList.add('hidden');
            if (input) input.classList.remove('border-danger-400');
        });
        const errEmail = document.getElementById('err_email');
        if (errEmail) errEmail.classList.add('hidden');
    }

    function setErrorMember(fieldId, errId, show) {
        const input = document.getElementById(fieldId);
        const err   = document.getElementById(errId);
        if (!input || !err) return;
        if (show) {
            err.classList.remove('hidden');
            input.classList.add('border-danger-400');
            input.classList.remove('border-neutral-200');
        } else {
            err.classList.add('hidden');
            input.classList.remove('border-danger-400');
            input.classList.add('border-neutral-200');
        }
    }

    function submitTambahMember() {
        const noTelp = document.getElementById('tambah_no_telp').value.trim();
        const nama   = document.getElementById('tambah_nama').value.trim();
        const alamat = document.getElementById('tambah_alamat').value.trim();
        const email  = document.getElementById('tambah_email').value.trim();
        const userId = document.getElementById('tambah_user_id').value;

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const errEmail = email !== '' && !emailRegex.test(email);

        setErrorMember('tambah_no_telp', 'err_no_telp', !noTelp);
        setErrorMember('tambah_nama',    'err_nama',    !nama);
        setErrorMember('tambah_alamat',  'err_alamat',  !alamat);
        setErrorMember('tambah_user_id', 'err_user_id', !userId);
        setErrorMember('tambah_email',   'err_email',   errEmail);

        if (!noTelp || !nama || !alamat || !userId || errEmail) return;

        document.getElementById('formTambahMember').submit();
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') tutupModalMember();
    });
</script>