<div id="modalEditBuku"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">

    <div class="absolute inset-0" onclick="tutupModalEditBuku()"></div>

    <div class="relative z-10 w-full max-w-lg rounded-xl bg-white border border-neutral-200 overflow-hidden shadow-lg">

        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-neutral-100">
            <div>
                <h2 class="text-sm font-semibold text-neutral-800">Edit Buku</h2>
                <p class="text-xs text-neutral-400 mt-0.5">Perbarui data buku perpustakaan</p>
            </div>
            <button type="button" onclick="tutupModalEditBuku()"
                    class="p-1 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form id="formEditBuku" method="POST" action="" class="px-6 py-5 flex flex-col gap-4 max-h-[75vh] overflow-y-auto custom-scroll">
            @csrf
            @method('PUT')

            {{-- Judul --}}
            <div class="flex flex-col gap-1.5">
                <label for="edit_judul" class="text-xs font-medium text-neutral-700">
                    Judul <span class="text-danger-500">*</span>
                </label>
                <input type="text" id="edit_judul" name="judul"
                       placeholder="Masukkan judul buku"
                       class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
            </div>

            {{-- Pengarang --}}
            <div class="flex flex-col gap-1.5">
                <label for="edit_pengarang" class="text-xs font-medium text-neutral-700">
                    Pengarang <span class="text-danger-500">*</span>
                </label>
                <input type="text" id="edit_pengarang" name="pengarang"
                       placeholder="Masukkan nama pengarang"
                       class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
            </div>

            {{-- Penerbit & Tahun Terbit --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label for="edit_penerbit" class="text-xs font-medium text-neutral-700">Penerbit</label>
                    <input type="text" id="edit_penerbit" name="penerbit"
                           placeholder="Nama penerbit"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="edit_tahun_terbit" class="text-xs font-medium text-neutral-700">Tahun Terbit</label>
                    <input type="number" id="edit_tahun_terbit" name="tahun_terbit"
                           placeholder="Contoh: 2020" min="1900" max="2099"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                </div>
            </div>

            {{-- ISBN & Tempat Terbit --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label for="edit_isbn" class="text-xs font-medium text-neutral-700">ISBN</label>
                    <input type="text" id="edit_isbn" name="isbn"
                           placeholder="Contoh: 978-xxx"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="edit_tempat_terbit" class="text-xs font-medium text-neutral-700">Tempat Terbit</label>
                    <input type="text" id="edit_tempat_terbit" name="tempat_terbit"
                           placeholder="Contoh: Jakarta"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                </div>
            </div>

            {{-- Stok & Kategori --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label for="edit_stok" class="text-xs font-medium text-neutral-700">Stok</label>
                    <input type="number" id="edit_stok" name="stok"
                           placeholder="0" min="0"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="edit_kategori" class="text-xs font-medium text-neutral-700">Kategori</label>
                    <input type="text" id="edit_kategori" name="kategori"
                           placeholder="Contoh: Fiksi"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                </div>
            </div>

            {{-- Sumber & Kondisi --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label for="edit_sumber" class="text-xs font-medium text-neutral-700">Sumber</label>
                    <select id="edit_sumber" name="sumber"
                            class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                        <option value="perpus">Perpustakaan</option>
                        <option value="tukar">Tukar</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="edit_kondisi" class="text-xs font-medium text-neutral-700">Kondisi</label>
                    <select id="edit_kondisi" name="kondisi"
                            class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                        <option value="">-- Pilih Kondisi --</option>
                        <option value="baik">Baik</option>
                        <option value="cukup">Cukup</option>
                        <option value="rusak">Rusak</option>
                    </select>
                </div>
            </div>

            {{-- Lokasi & Member --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label for="edit_lokasi_id" class="text-xs font-medium text-neutral-700">Lokasi</label>
                    <select id="edit_lokasi_id" name="lokasi_id"
                            class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                        <option value="">-- Pilih Lokasi --</option>
                        @foreach ($lokasis as $lokasi)
                            <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="edit_member_id" class="text-xs font-medium text-neutral-700">Member</label>
                    <select id="edit_member_id" name="member_id"
                            class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition">
                        <option value="">-- Pilih Member --</option>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}">{{ $member->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Resume --}}
            <div class="flex flex-col gap-1.5">
                <label for="edit_resume" class="text-xs font-medium text-neutral-700">Resume</label>
                <textarea id="edit_resume" name="resume" rows="3"
                          placeholder="Ringkasan singkat buku"
                          class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition resize-none"></textarea>
            </div>

            {{-- Deskripsi --}}
            <div class="flex flex-col gap-1.5">
                <label for="edit_deskripsi" class="text-xs font-medium text-neutral-700">Deskripsi</label>
                <textarea id="edit_deskripsi" name="deskripsi" rows="3"
                          placeholder="Deskripsi lengkap buku"
                          class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition resize-none"></textarea>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-2 pt-2 border-t border-neutral-100">
                <button type="button" onclick="tutupModalEditBuku()"
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
    function bukaModalEditBuku(data) {
        document.getElementById('formEditBuku').action = `/admin/buku/${data.id}`;

        document.getElementById('edit_judul').value         = data.judul ?? '';
        document.getElementById('edit_pengarang').value     = data.pengarang ?? '';
        document.getElementById('edit_penerbit').value      = data.penerbit ?? '';
        document.getElementById('edit_isbn').value          = data.isbn ?? '';
        document.getElementById('edit_tahun_terbit').value  = data.tahun_terbit ?? '';
        document.getElementById('edit_tempat_terbit').value = data.tempat_terbit ?? '';
        document.getElementById('edit_resume').value        = data.resume ?? '';
        document.getElementById('edit_stok').value          = data.stok ?? 0;
        document.getElementById('edit_kategori').value      = data.kategori ?? '';
        document.getElementById('edit_sumber').value        = data.sumber ?? 'perpus';
        document.getElementById('edit_kondisi').value       = data.kondisi ?? '';
        document.getElementById('edit_deskripsi').value     = data.deskripsi ?? '';
        document.getElementById('edit_lokasi_id').value     = data.lokasi_id ?? '';
        document.getElementById('edit_member_id').value     = data.member_id ?? '';

        document.getElementById('modalEditBuku').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function tutupModalEditBuku() {
        document.getElementById('modalEditBuku').classList.add('hidden');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') tutupModalEditBuku();
    });
</script>