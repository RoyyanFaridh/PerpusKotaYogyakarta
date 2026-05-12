{{-- Modal Tambah User --}}
<div id="modalTambahUser"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm px-4">

    <div class="absolute inset-0" onclick="tutupModalUser()"></div>

    <div class="relative z-10 w-full max-w-lg rounded-xl bg-white border border-neutral-200 overflow-hidden shadow-lg">

        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-neutral-100">
            <div>
                <h2 class="text-sm font-semibold text-neutral-800">Tambah User</h2>
                <p class="text-xs text-neutral-400 mt-0.5">Buat akun petugas baru</p>
            </div>
            <button type="button" onclick="tutupModalUser()"
                    class="p-1 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form id="formTambahUser" method="POST" action="{{ route('admin.pengaturan.user') }}" class="px-6 py-5 flex flex-col gap-4">
            @csrf

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Nama <span class="text-danger-500">*</span></label>
                <input type="text" name="new_name" id="tambah_new_name" value="{{ old('new_name') }}" placeholder="Nama lengkap"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('new_name') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                <p id="tambah_err_new_name" class="hidden text-[0.68rem] text-danger-500">
                    {{ $errors->first('new_name') ?: 'Nama wajib diisi.' }}
                </p>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Email <span class="text-danger-500">*</span></label>
                <input type="email" name="new_email" id="tambah_new_email" value="{{ old('new_email') }}" placeholder="contoh@email.com"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('new_email') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                <p id="tambah_err_new_email" class="hidden text-[0.68rem] text-danger-500">
                    {{ $errors->first('new_email') ?: 'Email wajib diisi.' }}
                </p>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Password <span class="text-danger-500">*</span></label>
                <input type="password" name="new_password" id="tambah_new_password" placeholder="Min. 8 karakter"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('new_password') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                <p id="tambah_err_new_password" class="hidden text-[0.68rem] text-danger-500">
                    {{ $errors->first('new_password') ?: 'Password wajib diisi.' }}
                </p>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Role <span class="text-danger-500">*</span></label>
                <select name="new_role" id="tambah_new_role"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('new_role') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white">
                    <option value="admin"      {{ old('new_role', 'admin') === 'admin'      ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ old('new_role') === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                </select>
                <p class="text-xs text-neutral-400">Superadmin memiliki semua akses tanpa perlu diatur permission-nya.</p>
                @error('new_role') <p class="text-[0.68rem] text-danger-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-neutral-100">
                <button type="button" onclick="tutupModalUser()"
                        class="px-4 py-2 text-xs font-medium rounded-lg border border-neutral-200 text-neutral-600 hover:bg-neutral-50 transition">
                    Batal
                </button>
                <button type="button" onclick="submitTambahUser()"
                        class="px-4 py-2 text-xs font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition">
                    Buat Akun
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function bukaModalUser() {
        const el = document.getElementById('modalTambahUser');
        el.classList.remove('hidden');
        el.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function tutupModalUser() {
        const el = document.getElementById('modalTambahUser');
        el.classList.add('hidden');
        el.classList.remove('flex');
        document.body.style.overflow = '';
    }

    function setErrorTambahUser(fieldId, errId, show, msg) {
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

    function submitTambahUser() {
        const nama     = document.getElementById('tambah_new_name').value.trim();
        const email    = document.getElementById('tambah_new_email').value.trim();
        const password = document.getElementById('tambah_new_password').value;

        const errNama     = !nama;
        const errEmail    = !email;
        const errPassword = !password || password.length < 8;

        setErrorTambahUser('tambah_new_name',     'tambah_err_new_name',     errNama,     'Nama wajib diisi.');
        setErrorTambahUser('tambah_new_email',    'tambah_err_new_email',    errEmail,    'Email wajib diisi.');
        setErrorTambahUser('tambah_new_password', 'tambah_err_new_password', errPassword, password && password.length < 8 ? 'Password minimal 8 karakter.' : 'Password wajib diisi.');

        if (errNama || errEmail || errPassword) return;

        document.getElementById('formTambahUser').submit();
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') tutupModalUser();
    });

    @if ($errors->hasAny(['new_name', 'new_email', 'new_password', 'new_role']))
        document.addEventListener('DOMContentLoaded', () => {
            bukaModalUser();

            // Tampilkan error dari server setelah modal terbuka
            @if ($errors->has('new_name'))
                setErrorTambahUser('tambah_new_name', 'tambah_err_new_name', true, '{{ $errors->first('new_name') }}');
            @endif
            @if ($errors->has('new_email'))
                setErrorTambahUser('tambah_new_email', 'tambah_err_new_email', true, '{{ $errors->first('new_email') }}');
            @endif
            @if ($errors->has('new_password'))
                setErrorTambahUser('tambah_new_password', 'tambah_err_new_password', true, '{{ $errors->first('new_password') }}');
            @endif
        });
    @endif
</script>