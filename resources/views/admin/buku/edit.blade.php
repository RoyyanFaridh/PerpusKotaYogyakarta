<div id="modalEditBuku" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeEdit()"></div>

    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden max-h-[90vh] flex flex-col">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-warning-400"></div>

        <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-neutral-100 shrink-0">
            <div>
                <h2 class="text-sm font-semibold text-neutral-800">Edit Buku</h2>
                <p class="text-xs text-neutral-400 mt-0.5" id="editBukuSubtitle">-</p>
            </div>
            <button onclick="closeEdit()" class="p-1.5 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form id="formEditBuku" method="POST" class="overflow-y-auto">
            @csrf
            @method('PUT')
            <div class="px-6 py-5 space-y-4">

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">Judul <span class="text-danger-500">*</span></label>
                        <input type="text" name="judul" id="edit_judul" required
                            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">Pengarang <span class="text-danger-500">*</span></label>
                        <input type="text" name="pengarang" id="edit_pengarang" required
                            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">Penerbit</label>
                        <input type="text" name="penerbit" id="edit_penerbit"
                            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">ISBN</label>
                        <input type="text" name="isbn" id="edit_isbn"
                            class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" id="edit_tahun_terbit" min="1900" max="{{ date('Y') }}"
                            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">Tempat Terbit</label>
                        <input type="text" name="tempat_terbit" id="edit_tempat_terbit"
                            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">Kategori</label>
                        <select name="kategori" id="edit_kategori"
                            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition bg-white">
                            <option value="">Pilih kategori</option>
                            @foreach (['Novel','Sains','Sejarah','Teknologi','Anak-anak','Lainnya'] as $kat)
                                <option value="{{ $kat }}">{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">Stok <span class="text-danger-500">*</span></label>
                        <input type="number" name="stok" id="edit_stok" required min="0"
                            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">Sumber <span class="text-danger-500">*</span></label>
                        <select name="sumber" id="edit_sumber" required
                            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition bg-white">
                            <option value="perpus">Perpustakaan</option>
                            <option value="tukar">Tukar</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">Kondisi</label>
                        <select name="kondisi" id="edit_kondisi"
                            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition bg-white">
                            <option value="">-</option>
                            <option value="baik">Baik</option>
                            <option value="cukup">Cukup</option>
                            <option value="rusak">Rusak</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-neutral-600 mb-1">Lokasi</label>
                    <select name="lokasi_id" id="edit_lokasi_id"
                        class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition bg-white">
                        <option value="">Pilih lokasi</option>
                        @foreach ($lokasis as $lokasi)
                            <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-neutral-600 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" id="edit_deskripsi" rows="2"
                        class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-medium text-neutral-600 mb-1">Resume</label>
                    <textarea name="resume" id="edit_resume" rows="3"
                        class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition resize-none"></textarea>
                </div>

            </div>

            <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-neutral-100 bg-neutral-50 shrink-0">
                <button type="button" onclick="closeEdit()"
                    class="text-xs font-medium px-4 py-2 rounded-lg border border-neutral-200 text-neutral-500 hover:bg-white transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="text-xs font-medium px-4 py-2 rounded-lg bg-warning-500 text-white hover:bg-warning-600 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEdit(id) {
    fetch(`/admin/buku/${id}/edit`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('formEditBuku').action = `/admin/buku/${id}`;
        document.getElementById('editBukuSubtitle').textContent = data.judul;
        document.getElementById('edit_judul').value         = data.judul;
        document.getElementById('edit_pengarang').value     = data.pengarang;
        document.getElementById('edit_penerbit').value      = data.penerbit      ?? '';
        document.getElementById('edit_isbn').value          = data.isbn          ?? '';
        document.getElementById('edit_tahun_terbit').value  = data.tahun_terbit  ?? '';
        document.getElementById('edit_tempat_terbit').value = data.tempat_terbit ?? '';
        document.getElementById('edit_kategori').value      = data.kategori      ?? '';
        document.getElementById('edit_stok').value          = data.stok;
        document.getElementById('edit_sumber').value        = data.sumber;
        document.getElementById('edit_kondisi').value       = data.kondisi       ?? '';
        document.getElementById('edit_lokasi_id').value     = data.lokasi_id     ?? '';
        document.getElementById('edit_deskripsi').value     = data.deskripsi     ?? '';
        document.getElementById('edit_resume').value        = data.resume        ?? '';

        document.getElementById('modalEditBuku').classList.remove('hidden');
        document.getElementById('modalEditBuku').classList.add('flex');
    });
}

function closeEdit() {
    document.getElementById('modalEditBuku').classList.add('hidden');
    document.getElementById('modalEditBuku').classList.remove('flex');
}
</script>