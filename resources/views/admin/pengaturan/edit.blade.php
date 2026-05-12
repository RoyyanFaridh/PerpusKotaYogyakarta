{{-- Modal Edit User --}}
<div id="modalEditUser-{{ $user->id }}"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm px-4">

    <div class="absolute inset-0" onclick="tutupModalEditUser({{ $user->id }})"></div>

    <div class="relative z-10 w-full max-w-lg rounded-xl bg-white border border-neutral-200 overflow-hidden shadow-lg max-h-[90vh] overflow-y-auto custom-scroll">

        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-neutral-100 sticky top-0 bg-white z-10">
            <div class="flex items-center gap-3">
                <div class="w-7 h-7 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center text-xs font-bold uppercase shrink-0">
                    {{ substr($user->nama, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-neutral-800">Edit User — {{ $user->nama }}</h2>
                    <p class="text-xs text-neutral-400 mt-0.5">Ubah profil dan password</p>
                </div>
            </div>
            <button type="button" onclick="tutupModalEditUser({{ $user->id }})"
                    class="p-1 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form id="formEditUser-{{ $user->id }}" method="POST" action="{{ route('admin.pengaturan.user.update', $user) }}" class="px-6 py-5 flex flex-col gap-4">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Nama <span class="text-danger-500">*</span></label>
                <input type="text" name="nama" id="edit_nama_{{ $user->id }}" value="{{ old('nama', $user->nama) }}"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('nama') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                <p id="edit_err_nama_{{ $user->id }}" class="{{ $errors->has('nama') ? '' : 'hidden' }} text-[0.68rem] text-danger-500">
                    {{ $errors->first('nama') ?: 'Nama wajib diisi.' }}
                </p>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Email <span class="text-danger-500">*</span></label>
                <input type="email" name="email" id="edit_email_{{ $user->id }}" value="{{ old('email', $user->email) }}" placeholder="contoh@email.com"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('email') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                <p id="edit_err_email_{{ $user->id }}" class="{{ $errors->has('email') ? '' : 'hidden' }} text-[0.68rem] text-danger-500">
                    {{ $errors->first('email') ?: 'Email wajib diisi.' }}
                </p>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Nomor HP <span class="text-danger-500">*</span></label>
                <input type="text" name="no_hp" id="edit_no_hp_{{ $user->id }}" value="{{ old('no_hp', $user->no_hp) }}" placeholder="08xxxxxxxxxx" maxlength="15"
                    class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('no_hp') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                <p id="edit_err_no_hp_{{ $user->id }}" class="{{ $errors->has('no_hp') ? '' : 'hidden' }} text-[0.68rem] text-danger-500">
                    {{ $errors->first('no_hp') ?: 'Nomor HP wajib diisi.' }}
                </p>
            </div>

            @if (!$user->isSuperAdmin())
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Role</label>
                    <select name="role"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('role') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white">
                        <option value="admin"      {{ old('role', $user->role) === 'admin'      ? 'selected' : '' }}>Admin</option>
                        <option value="superadmin" {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                    </select>
                    @error('role') <p class="text-[0.68rem] text-danger-500">{{ $message }}</p> @enderror
                </div>
            @endif

            <div class="border-t border-neutral-100 pt-4 flex flex-col gap-3">
                <p class="text-xs font-medium text-neutral-500">Password <span class="font-normal text-neutral-400">(kosongkan jika tidak ingin mengubah)</span></p>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Password Baru</label>
                    <input type="password" name="password" id="edit_password_{{ $user->id }}" placeholder="Min. 8 karakter"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('password') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                    <p id="edit_err_password_{{ $user->id }}" class="{{ $errors->has('password') ? '' : 'hidden' }} text-[0.68rem] text-danger-500">
                        {{ $errors->first('password') ?: 'Password minimal 8 karakter.' }}
                    </p>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="edit_password_confirmation_{{ $user->id }}" placeholder="Ulangi password baru"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                    <p id="edit_err_password_confirmation_{{ $user->id }}" class="hidden text-[0.68rem] text-danger-500">
                        Konfirmasi password tidak cocok.
                    </p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-2 pt-2 border-t border-neutral-100">
                <button type="button" onclick="tutupModalEditUser({{ $user->id }})"
                        class="px-4 py-2 text-xs font-medium rounded-lg border border-neutral-200 text-neutral-600 hover:bg-neutral-50 transition">
                    Batal
                </button>
                <button type="button" onclick="submitEditUser({{ $user->id }})"
                        class="px-4 py-2 text-xs font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function bukaModalEditUser(id) {
        const el = document.getElementById('modalEditUser-' + id);
        if (!el) return;
        el.classList.remove('hidden');
        el.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function tutupModalEditUser(id) {
        const el = document.getElementById('modalEditUser-' + id);
        if (!el) return;
        el.classList.add('hidden');
        el.classList.remove('flex');
        document.body.style.overflow = '';
    }

    function setErrorEdit(id, fieldId, errId, show, msg) {
        const input = document.getElementById(fieldId + '_' + id);
        const err   = document.getElementById(errId + '_' + id);
        if (!input || !err) return;
        if (show) {
            if (msg) err.textContent = msg;
            err.classList.remove('hidden');
            input.classList.add('border-danger-400');
            input.classList.remove('border-neutral-200');
        } else {
            err.classList.add('hidden');
            input.classList.remove('border-danger-400');
            input.classList.add('border-neutral-200');
        }
    }

    function submitEditUser(id) {
        const nama     = document.getElementById('edit_nama_' + id)?.value.trim();
        const email    = document.getElementById('edit_email_' + id)?.value.trim();
        const no_hp    = document.getElementById('edit_no_hp_' + id)?.value.trim();
        const password = document.getElementById('edit_password_' + id)?.value;
        const confirm  = document.getElementById('edit_password_confirmation_' + id)?.value;

        const errNama     = !nama;
        const errEmail    = !email;
        const errNoHp     = !no_hp;
        const errPassword = password !== '' && password.length < 8;
        const errConfirm  = password !== '' && password !== confirm;

        setErrorEdit(id, 'edit_nama',                    'edit_err_nama',                    errNama,     'Nama wajib diisi.');
        setErrorEdit(id, 'edit_email',                   'edit_err_email',                   errEmail,    'Email wajib diisi.');
        setErrorEdit(id, 'edit_no_hp',                   'edit_err_no_hp',                   errNoHp,     'Nomor HP wajib diisi.');
        setErrorEdit(id, 'edit_password',                'edit_err_password',                errPassword, 'Password minimal 8 karakter.');
        setErrorEdit(id, 'edit_password_confirmation',   'edit_err_password_confirmation',   errConfirm,  'Konfirmasi password tidak cocok.');

        if (errNama || errEmail || errNoHp || errPassword || errConfirm) return;

        document.getElementById('formEditUser-' + id).submit();
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="modalEditUser-"]').forEach(el => {
                el.classList.add('hidden');
                el.classList.remove('flex');
            });
            document.body.style.overflow = '';
        }
    });

    @if ($errors->hasAny(['nama', 'email', 'no_hp', 'role', 'password']))
        document.addEventListener('DOMContentLoaded', () => bukaModalEditUser({{ $user->id }}));
    @endif
</script>