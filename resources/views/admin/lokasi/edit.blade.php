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
            </div>

            {{-- Alamat --}}
            <div class="flex flex-col gap-1.5">
                <label for="edit_alamat" class="text-xs font-medium text-neutral-700">
                    Alamat <span class="text-danger-500">*</span>
                </label>
                <textarea id="edit_alamat" name="alamat" rows="3"
                          placeholder="Masukkan alamat lengkap lokasi"
                          class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition resize-none"></textarea>
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
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-2 pt-2 border-t border-neutral-100">
                <button type="button" onclick="tutupModalEditLokasi()"
                        class="px-4 py-2 text-xs font-medium rounded-lg border border-neutral-200 text-neutral-600 hover:bg-neutral-50 transition">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 text-xs font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function bukaModalEditLokasi(data) {
        document.getElementById('formEditLokasi').action = `/admin/lokasi/${data.id}`;
        document.getElementById('edit_nama_lokasi').value  = data.nama_lokasi ?? '';
        document.getElementById('edit_alamat').value       = data.alamat ?? '';
        document.getElementById('edit_no_telp').value      = data.no_telp ?? '';

        const select = document.getElementById('edit_user_id');
        select.value = data.user_id ?? '';

        document.getElementById('modalEditLokasi').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function tutupModalEditLokasi() {
        document.getElementById('modalEditLokasi').classList.add('hidden');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') tutupModalEditLokasi();
    });
</script>