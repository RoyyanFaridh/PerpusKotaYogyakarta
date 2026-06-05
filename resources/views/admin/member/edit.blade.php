<div id="modalEditMember"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm px-4">

    <div class="absolute inset-0" onclick="tutupModalEdit()"></div>

    <div class="relative z-10 w-full max-w-md rounded-2xl bg-white overflow-hidden shadow-xl">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-warning-400"></div>

        <div class="flex items-center justify-between px-6 sm:px-8 pt-6 pb-5 border-b border-neutral-100 shrink-0">
            <div>
                <h2 class="text-base font-semibold text-neutral-800">Edit Member</h2>
                <p class="text-sm text-neutral-400 mt-0.5">Perbarui data member</p>
            </div>
            <button type="button" onclick="tutupModalEdit()" aria-label="Tutup modal"
                    class="p-2 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form id="formEditMember" method="POST" action=""
              class="px-6 sm:px-8 py-6 flex flex-col gap-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label for="edit_no_telp" class="text-xs font-medium text-neutral-700">
                        Nomor Telepon <span class="text-danger-500">*</span>
                    </label>
                    <input type="text" id="edit_no_telp" name="no_telp"
                           maxlength="15" placeholder="08123456789"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="edit_email" class="text-xs font-medium text-neutral-700">Email</label>
                    <input type="email" id="edit_email" name="email"
                           placeholder="contoh@email.com"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                </div>
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="edit_nama" class="text-xs font-medium text-neutral-700">
                    Nama Lengkap <span class="text-danger-500">*</span>
                </label>
                <input type="text" id="edit_nama" name="nama" placeholder="Masukkan nama lengkap"
                       class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="edit_alamat" class="text-xs font-medium text-neutral-700">
                    Alamat <span class="text-danger-500">*</span>
                </label>
                <textarea id="edit_alamat" name="alamat" rows="3"
                          placeholder="Masukkan alamat lengkap"
                          class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition resize-none"></textarea>
            </div>
        </form>

        <div class="flex items-center justify-between px-6 sm:px-8 py-4 border-t border-neutral-100 bg-neutral-50">
            <div></div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="tutupModalEdit()"
                        class="text-sm font-medium px-4 py-2 rounded-lg text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 transition-colors">
                    Batal
                </button>
                <button type="button" onclick="document.getElementById('formEditMember').submit()"
                        class="text-sm font-medium px-4 py-2 rounded-lg bg-warning-500 text-white hover:bg-warning-600 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function bukaModalEdit(member) {
        document.getElementById('edit_no_telp').value = member.no_telp ?? '';
        document.getElementById('edit_nama').value    = member.nama    ?? '';
        document.getElementById('edit_email').value   = member.email   ?? '';
        document.getElementById('edit_alamat').value  = member.alamat  ?? '';

        document.getElementById('formEditMember').action =
            "{{ url('admin/member') }}/" + member.id;

        const modal = document.getElementById('modalEditMember');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function tutupModalEdit() {
        const modal = document.getElementById('modalEditMember');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') tutupModalEdit();
    });
</script>