<div id="modalEditKegiatan"
     class="fixed inset-0 z-50 hidden items-center justify-center p-4">

    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="tutupModalEditKegiatan()"></div>

    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden max-h-[90vh] flex flex-col">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-neutral-100 shrink-0">
            <div>
                <h2 class="text-sm font-semibold text-neutral-800">Edit Kegiatan</h2>
                <p class="text-xs text-neutral-400 mt-0.5">Perbarui data rencana kegiatan perpustakaan</p>
            </div>
            <button onclick="tutupModalEditKegiatan()" class="p-1.5 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form id="formEditKegiatan" method="POST" action="" class="overflow-y-auto">
            @csrf
            @method('PUT')

            {{-- Hidden: simpan nilai lama sebagai fallback --}}
            <input type="hidden" id="edit_old_nama_kegiatan"   name="old_nama_kegiatan">
            <input type="hidden" id="edit_old_tanggal_mulai"   name="old_tanggal_mulai">
            <input type="hidden" id="edit_old_jam_pelaksanaan" name="old_jam_pelaksanaan">
            <input type="hidden" id="edit_old_jam_selesai"     name="old_jam_selesai">
            <input type="hidden" id="edit_old_deskripsi"       name="old_deskripsi">

            <div class="px-6 py-5 space-y-4">

                {{-- Nama Kegiatan --}}
                <div>
                    <label class="block text-xs font-medium text-neutral-600 mb-1">
                        Nama Kegiatan
                    </label>
                    <input type="text" id="edit_nama_kegiatan" name="nama_kegiatan"
                        placeholder="Kosongkan untuk tidak mengubah"
                        class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                </div>

                {{-- Tanggal Mulai, Jam Pelaksanaan, Jam Selesai --}}
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">Tanggal Mulai</label>
                        <input type="date" id="edit_tanggal_mulai" name="tanggal_mulai"
                            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">Jam Mulai</label>
                        <input type="time" id="edit_jam_pelaksanaan" name="jam_pelaksanaan"
                            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">Jam Selesai</label>
                        <input type="time" id="edit_jam_selesai" name="jam_selesai"
                            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-xs font-medium text-neutral-600 mb-1">Deskripsi</label>
                    <textarea id="edit_deskripsi" name="deskripsi" rows="3"
                        placeholder="Kosongkan untuk tidak mengubah"
                        class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition resize-none"></textarea>
                </div>

                <p class="text-[0.68rem] text-neutral-400">Kolom yang dikosongkan tidak akan mengubah data sebelumnya.</p>

            </div>

            <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-neutral-100 bg-neutral-50 shrink-0">
                <button type="button" onclick="tutupModalEditKegiatan()"
                    class="text-xs font-medium px-4 py-2 rounded-lg border border-neutral-200 text-neutral-500 hover:bg-white transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="text-xs font-medium px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const editKegiatanRouteBase = "{{ url('admin/kegiatan') }}";

    function bukaModalEditKegiatan(id) {
        fetch(editKegiatanRouteBase + '/' + id + '/edit', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            // Isi nilai saat ini ke input
            document.getElementById('edit_nama_kegiatan').value   = data.nama_kegiatan   ?? '';
            document.getElementById('edit_tanggal_mulai').value   = data.tanggal_mulai   ?? '';
            document.getElementById('edit_jam_pelaksanaan').value = data.jam_pelaksanaan ?? '';
            document.getElementById('edit_jam_selesai').value     = data.jam_selesai     ?? '';
            document.getElementById('edit_deskripsi').value       = data.deskripsi       ?? '';

            // Simpan nilai lama ke hidden input sebagai fallback
            document.getElementById('edit_old_nama_kegiatan').value   = data.nama_kegiatan   ?? '';
            document.getElementById('edit_old_tanggal_mulai').value   = data.tanggal_mulai   ?? '';
            document.getElementById('edit_old_jam_pelaksanaan').value = data.jam_pelaksanaan ?? '';
            document.getElementById('edit_old_jam_selesai').value     = data.jam_selesai     ?? '';
            document.getElementById('edit_old_deskripsi').value       = data.deskripsi       ?? '';

            document.getElementById('formEditKegiatan').action = editKegiatanRouteBase + '/' + id;

            const modal = document.getElementById('modalEditKegiatan');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        });
    }

    function tutupModalEditKegiatan() {
        const modal = document.getElementById('modalEditKegiatan');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') tutupModalEditKegiatan();
    });
</script>