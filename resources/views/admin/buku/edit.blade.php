<div id="modalEditBuku"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 backdrop-blur-sm px-4">

    <div class="absolute inset-0" onclick="tutupModalEditBuku()"></div>

    <div class="relative z-10 w-full max-w-2xl rounded-2xl bg-white overflow-hidden shadow-xl">

        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 sm:px-8 pt-6 pb-5 border-b border-neutral-100 shrink-0">
            <div>
                <h2 class="text-base font-semibold text-neutral-800">Edit Buku</h2>
                <p class="text-sm text-neutral-400 mt-0.5">Perbarui data buku perpustakaan</p>
            </div>
            <button type="button" onclick="tutupModalEditBuku()"
                    aria-label="Tutup modal"
                    class="p-2 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form id="formEditBuku" method="POST" action=""
              enctype="multipart/form-data"
              class="px-6 sm:px-8 py-6 flex flex-col gap-4 max-h-[75vh] overflow-y-auto custom-scroll">
            @csrf
            @method('PUT')

            {{-- Judul --}}
            <div class="flex flex-col gap-1.5">
                <label for="edit_judul" class="text-xs font-medium text-neutral-700">Judul <span class="text-danger-500">*</span></label>
                <input type="text" id="edit_judul" name="judul" placeholder="Masukkan judul buku"
                       class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
            </div>

            {{-- Pengarang --}}
            <div class="flex flex-col gap-1.5">
                <label for="edit_pengarang" class="text-xs font-medium text-neutral-700">Pengarang <span class="text-danger-500">*</span></label>
                <input type="text" id="edit_pengarang" name="pengarang" placeholder="Masukkan nama pengarang"
                       class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
            </div>

            {{-- Penerbit & Tahun Terbit --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label for="edit_penerbit" class="text-xs font-medium text-neutral-700">Penerbit</label>
                    <input type="text" id="edit_penerbit" name="penerbit" placeholder="Nama penerbit"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="edit_tahun_terbit" class="text-xs font-medium text-neutral-700">Tahun Terbit</label>
                    <input type="number" id="edit_tahun_terbit" name="tahun_terbit" placeholder="Contoh: 2020" min="1900" max="2099"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                </div>
            </div>

            {{-- ISBN & Tempat Terbit --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label for="edit_isbn" class="text-xs font-medium text-neutral-700">ISBN</label>
                    <input type="text" id="edit_isbn" name="isbn" placeholder="Contoh: 978-xxx"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 font-mono focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="edit_tempat_terbit" class="text-xs font-medium text-neutral-700">Tempat Terbit</label>
                    <input type="text" id="edit_tempat_terbit" name="tempat_terbit" placeholder="Contoh: Jakarta"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                </div>
            </div>

            {{-- Stok & Kategori --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label for="edit_stok" class="text-xs font-medium text-neutral-700">Stok <span class="text-danger-500">*</span></label>
                    <input type="number" id="edit_stok" name="stok" placeholder="0" min="0"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="edit_kategori" class="text-xs font-medium text-neutral-700">Kategori</label>
                    <select id="edit_kategori" name="kategori"
                            class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white">
                        <option value="">Pilih kategori</option>
                        @foreach ([
                            'Umum/Komputer','Filsafat & Psikologi','Agama','Ilmu Sosial','Bahasa',
                            'Sains & Matematika','Teknologi','Seni & Rekreasi','Literatur & Sastra','Geografi & Sejarah',
                        ] as $kat)
                            <option value="{{ $kat }}">{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Paket & Lokasi --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <div class="flex items-center justify-between">
                        <label for="edit_paket_id" class="text-xs font-medium text-neutral-700">Paket</label>
                        <button type="button" onclick="bukaPaketDariEditBuku()"
                                class="text-[0.68rem] font-medium text-primary-600 hover:text-primary-700 transition-colors">
                            + Buat Paket Baru
                        </button>
                    </div>
                    <select id="edit_paket_id" name="paket_id"
                            class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white">
                        <option value="">Tanpa paket (donasi)</option>
                        @foreach ($pakets as $paket)
                            <option value="{{ $paket->id }}">{{ $paket->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="edit_lokasi_id" class="text-xs font-medium text-neutral-700">Lokasi <span class="text-danger-500">*</span></label>
                    <select id="edit_lokasi_id" name="lokasi_id"
                            class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white">
                        <option value="">Pilih lokasi</option>
                        @foreach ($lokasis as $lokasi)
                            <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Visibility — hanya muncul kalau buku tidak dalam paket --}}
            <div id="edit_visibility_wrapper" class="flex items-center gap-2.5">
                <input type="hidden" name="is_visible" value="0"/>
                <input type="checkbox" name="is_visible" id="edit_is_visible" value="1"
                       class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-300"/>
                <label for="edit_is_visible" class="text-xs font-medium text-neutral-700">
                    Tampilkan buku ini ke publik
                </label>
            </div>

            {{-- Info kalau dalam paket --}}
            <div id="edit_paket_info" class="hidden flex items-center gap-2 px-3 py-2.5 rounded-lg bg-primary-50 border border-primary-100">
                <svg class="w-4 h-4 text-primary-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <p class="text-xs text-primary-700">Visibility dikontrol oleh status paket.</p>
            </div>

            {{-- Resume --}}
            <div class="flex flex-col gap-1.5">
                <label for="edit_resume" class="text-xs font-medium text-neutral-700">Resume</label>
                <textarea id="edit_resume" name="resume" rows="3" placeholder="Ringkasan singkat buku"
                          class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition resize-none"></textarea>
            </div>

            {{-- Deskripsi --}}
            <div class="flex flex-col gap-1.5">
                <label for="edit_deskripsi" class="text-xs font-medium text-neutral-700">Deskripsi</label>
                <textarea id="edit_deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi lengkap buku"
                          class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition resize-none"></textarea>
            </div>

            {{-- Cover --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Cover Buku</label>
                <div class="flex items-start gap-4">
                    <div id="preview-cover-edit"
                         class="w-16 h-24 rounded-lg border border-neutral-200 bg-neutral-50 flex items-center justify-center overflow-hidden shrink-0">
                        <svg class="w-5 h-5 text-neutral-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>
                        </svg>
                    </div>
                    <div class="flex flex-col gap-1.5 flex-1 justify-center">
                        <input type="file" name="cover" id="cover-input-edit" accept="image/*"
                               class="text-xs text-neutral-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 cursor-pointer transition">
                        <p class="text-[0.7rem] text-neutral-400">Kosongkan jika tidak ingin mengubah cover.</p>
                    </div>
                </div>
            </div>

        </form>

        {{-- Footer --}}
        <div class="flex items-center justify-between px-6 sm:px-8 py-4 border-t border-neutral-100 bg-neutral-50">
            <div></div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="tutupModalEditBuku()"
                        class="text-sm font-medium px-4 py-2 rounded-lg text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 transition-colors">
                    Batal
                </button>
                <button type="button" onclick="document.getElementById('formEditBuku').submit()"
                        class="text-sm font-medium px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </div>

    </div>
</div>

<script>
    function bukaModalEditBuku(data) {
        document.getElementById('formEditBuku').action = `/admin/buku/${data.id}`;

        document.getElementById('edit_judul').value         = data.judul         ?? '';
        document.getElementById('edit_pengarang').value     = data.pengarang     ?? '';
        document.getElementById('edit_penerbit').value      = data.penerbit      ?? '';
        document.getElementById('edit_isbn').value          = data.isbn          ?? '';
        document.getElementById('edit_tahun_terbit').value  = data.tahun_terbit  ?? '';
        document.getElementById('edit_tempat_terbit').value = data.tempat_terbit ?? '';
        document.getElementById('edit_resume').value        = data.resume        ?? '';
        document.getElementById('edit_stok').value          = data.stok          ?? 0;
        document.getElementById('edit_kategori').value      = data.kategori      ?? '';
        document.getElementById('edit_deskripsi').value     = data.deskripsi     ?? '';
        document.getElementById('edit_lokasi_id').value     = data.lokasi_id     ?? '';
        document.getElementById('edit_paket_id').value      = data.paket_id      ?? '';
        document.getElementById('edit_is_visible').checked  = !!data.is_visible;

        toggleEditVisibilityUI(data.paket_id);

        // Tampilkan cover existing jika ada
        const preview = document.getElementById('preview-cover-edit');
        if (data.cover) {
            preview.innerHTML = `<img src="/storage/${data.cover}" class="w-full h-full object-cover">`;
        } else {
            preview.innerHTML = `<svg class="w-5 h-5 text-neutral-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>`;
        }

        // Reset input file
        document.getElementById('cover-input-edit').value = '';

        const el = document.getElementById('modalEditBuku');
        el.classList.remove('hidden');
        el.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function toggleEditVisibilityUI(paketId) {
        const wrapper = document.getElementById('edit_visibility_wrapper');
        const info    = document.getElementById('edit_paket_info');
        if (paketId) {
            wrapper.classList.add('hidden');
            info.classList.remove('hidden');
        } else {
            wrapper.classList.remove('hidden');
            info.classList.add('hidden');
        }
    }

    document.getElementById('edit_paket_id')?.addEventListener('change', function () {
        toggleEditVisibilityUI(this.value);
    });

    function bukaPaketDariEditBuku() {
        tutupModalEditBuku();
        bukaModalTambahPaket('edit_buku');
    }

    function tutupModalEditBuku() {
        const el = document.getElementById('modalEditBuku');
        el.classList.add('hidden');
        el.classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') tutupModalEditBuku();
    });

    document.getElementById('cover-input-edit')?.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-cover-edit').innerHTML =
                `<img src="${e.target.result}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(file);
    });
</script>