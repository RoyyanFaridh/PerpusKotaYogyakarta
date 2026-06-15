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
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

            <input type="hidden" id="edit_eksemplar_id" name="eksemplar_id"/>

            {{-- Cover — drag & drop --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Cover Buku</label>
                <div id="edit-cover-dropzone"
                     class="relative flex flex-col items-center justify-center gap-3 rounded-xl border-2 border-dashed border-neutral-200 bg-neutral-50 transition-colors cursor-pointer hover:border-primary-300 hover:bg-primary-50"
                     style="min-height: 140px;"
                     onclick="document.getElementById('cover-input-edit').click()">

                    {{-- Preview --}}
                    <div id="preview-cover-edit"
                         class="hidden absolute inset-0 rounded-xl overflow-hidden">
                        <img id="preview-cover-edit-img" src="" class="w-full h-full object-cover"/>
                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <span class="text-white text-xs font-medium">Ganti Cover</span>
                        </div>
                    </div>

                    {{-- Placeholder --}}
                    <div id="edit-cover-placeholder" class="flex flex-col items-center gap-2 py-6 px-4 text-center">
                        <div class="w-10 h-10 rounded-lg bg-neutral-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-neutral-400" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.5">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="17 8 12 3 7 8"/>
                                <line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-neutral-600">Tarik file ke sini</p>
                            <p class="text-xs text-neutral-400 mt-0.5">atau klik untuk pilih file · JPG, PNG, WebP</p>
                        </div>
                    </div>

                    <input type="file" name="cover" id="cover-input-edit" accept="image/*"
                           class="hidden"/>
                </div>
                <p class="text-[0.7rem] text-neutral-400">Kosongkan jika tidak ingin mengubah cover.</p>
            </div>

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
                    <input type="number" id="edit_tahun_terbit" name="tahun_terbit" placeholder="2024"
                           min="1900" max="{{ date('Y') }}"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                </div>
            </div>

            {{-- ISBN & Tempat Terbit --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label for="edit_isbn" class="text-xs font-medium text-neutral-700">ISBN</label>
                    <input type="text" id="edit_isbn" name="isbn" placeholder="978-xxx"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 font-mono focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="edit_tempat_terbit" class="text-xs font-medium text-neutral-700">Tempat Terbit</label>
                    <input type="text" id="edit_tempat_terbit" name="tempat_terbit" placeholder="Jakarta"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                </div>
            </div>

            {{-- Stok & Kategori --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label for="edit_stok" class="text-xs font-medium text-neutral-700">Stok <span class="text-danger-500">*</span></label>
                    <input type="number" id="edit_stok" name="stok" placeholder="0" min="0"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                    <p class="text-[0.68rem] text-neutral-400">Stok untuk eksemplar ini di paket terkait.</p>
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

        document.getElementById('edit_eksemplar_id').value  = data.eksemplar_id  ?? '';
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

        // Reset cover input
        document.getElementById('cover-input-edit').value = '';

        const preview    = document.getElementById('preview-cover-edit');
        const previewImg = document.getElementById('preview-cover-edit-img');
        const placeholder = document.getElementById('edit-cover-placeholder');

        if (data.cover) {
            previewImg.src = `/storage/${data.cover}`;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        } else {
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }

        const el = document.getElementById('modalEditBuku');
        el.classList.remove('hidden');
        el.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function tutupModalEditBuku() {
        const el = document.getElementById('modalEditBuku');
        el.classList.add('hidden');
        el.classList.remove('flex');
        document.body.style.overflow = '';
    }

    function handleEditCoverFile(file) {
        if (!file || !file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = e => {
            const preview    = document.getElementById('preview-cover-edit');
            const previewImg = document.getElementById('preview-cover-edit-img');
            const placeholder = document.getElementById('edit-cover-placeholder');

            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }

    // File input change
    document.getElementById('cover-input-edit')?.addEventListener('change', function () {
        if (this.files[0]) handleEditCoverFile(this.files[0]);
    });

    // Drag & drop
    const dropzone = document.getElementById('edit-cover-dropzone');

    dropzone?.addEventListener('dragover', e => {
        e.preventDefault();
        dropzone.classList.add('border-primary-400', 'bg-primary-50');
    });

    dropzone?.addEventListener('dragleave', () => {
        dropzone.classList.remove('border-primary-400', 'bg-primary-50');
    });

    dropzone?.addEventListener('drop', e => {
        e.preventDefault();
        dropzone.classList.remove('border-primary-400', 'bg-primary-50');

        const file = e.dataTransfer.files[0];
        if (file) {
            // Inject ke input supaya ikut tersubmit
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('cover-input-edit').files = dt.files;
            handleEditCoverFile(file);
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') tutupModalEditBuku();
    });
</script>