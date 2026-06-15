<div id="modalTambahBuku"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 backdrop-blur-sm px-4">

    <div class="absolute inset-0" onclick="tutupModalBuku()"></div>

    <div class="relative z-10 w-full max-w-2xl rounded-2xl bg-white border border-neutral-200 overflow-hidden shadow-xl">

        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 sm:px-8 pt-6 pb-5 border-b border-neutral-100 shrink-0">
            <div>
                <h2 class="text-base font-semibold text-neutral-800">Tambah Buku</h2>
                <p class="text-sm text-neutral-400 mt-0.5">Isi data buku baru</p>
            </div>
            <button type="button" onclick="tutupModalBuku()"
                    aria-label="Tutup modal"
                    class="p-2 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form id="formTambahBuku" method="POST" action="{{ route('admin.buku.store') }}"
              enctype="multipart/form-data"
              class="px-6 sm:px-8 py-6 flex flex-col gap-4 max-h-[75vh] overflow-y-auto custom-scroll">
            @csrf

            {{-- Cover — drag & drop --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Cover Buku</label>
                <div id="tambah-cover-dropzone"
                     class="relative flex flex-col items-center justify-center gap-3 rounded-xl border-2 border-dashed border-neutral-200 bg-neutral-50 transition-colors cursor-pointer hover:border-primary-300 hover:bg-primary-50"
                     style="min-height: 140px;"
                     onclick="document.getElementById('cover-input-tambah').click()">

                    <div id="preview-cover-tambah"
                         class="hidden absolute inset-0 rounded-xl overflow-hidden">
                        <img id="preview-cover-tambah-img" src="" class="w-full h-full object-cover"/>
                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <span class="text-white text-xs font-medium">Ganti Cover</span>
                        </div>
                    </div>

                    <div id="tambah-cover-placeholder" class="flex flex-col items-center gap-2 py-6 px-4 text-center">
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

                    <input type="file" name="cover" id="cover-input-tambah" accept="image/*" class="hidden"/>
                </div>
            </div>

            {{-- Judul & Pengarang --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Judul <span class="text-danger-500">*</span></label>
                    <input type="text" name="judul" id="tambah_judul" placeholder="Judul buku"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                    <p id="err_judul" class="hidden text-[0.68rem] text-danger-500">Judul buku wajib diisi.</p>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Pengarang <span class="text-danger-500">*</span></label>
                    <input type="text" name="pengarang" id="tambah_pengarang" placeholder="Nama pengarang"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                    <p id="err_pengarang" class="hidden text-[0.68rem] text-danger-500">Pengarang wajib diisi.</p>
                </div>
            </div>

            {{-- Penerbit & ISBN --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Penerbit</label>
                    <input type="text" name="penerbit" placeholder="Nama penerbit"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">ISBN</label>
                    <input type="text" name="isbn" placeholder="978-xxx-xxx"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 font-mono focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                </div>
            </div>

            {{-- Tahun & Tempat Terbit --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" placeholder="2024" min="1900" max="{{ date('Y') }}"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Tempat Terbit</label>
                    <input type="text" name="tempat_terbit" placeholder="Jakarta"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                </div>
            </div>

            {{-- Kategori & Stok --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Kategori</label>
                    <select name="kategori"
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
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Stok <span class="text-danger-500">*</span></label>
                    <input type="number" name="stok" id="tambah_stok" min="0" value="0"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                    <p id="err_stok" class="hidden text-[0.68rem] text-danger-500">Stok wajib diisi.</p>
                </div>
            </div>

            {{-- Paket (wajib) --}}
            <div class="flex flex-col gap-1.5">
                <div class="flex items-center justify-between">
                    <label class="text-xs font-medium text-neutral-700">Paket <span class="text-danger-500">*</span></label>
                    <button type="button" onclick="bukaPaketDariTambahBuku()"
                            class="text-[0.68rem] font-medium text-primary-600 hover:text-primary-700 transition-colors">
                        + Buat Paket Baru
                    </button>
                </div>
                <select name="paket_id" id="tambah_paket_id"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white">
                    <option value="">-- Pilih Paket --</option>
                    @foreach ($pakets as $paket)
                        <option value="{{ $paket->id }}">
                            {{ $paket->nama }}
                            @if ($paket->lokasi)
                                — {{ $paket->lokasi->nama_lokasi }}
                            @endif
                        </option>
                    @endforeach
                </select>
                <p id="err_paket" class="hidden text-[0.68rem] text-danger-500">Paket wajib dipilih.</p>
                <p class="text-[0.68rem] text-neutral-400">Lokasi buku mengikuti paket yang dipilih.</p>
            </div>

            {{-- Visibility --}}
            <div class="flex items-center gap-2.5">
                <input type="hidden" name="is_visible" value="0"/>
                <input type="checkbox" name="is_visible" id="tambah_is_visible" value="1"
                       class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-300"/>
                <label for="tambah_is_visible" class="text-xs font-medium text-neutral-700">
                    Tampilkan buku ini ke publik
                </label>
            </div>

            {{-- Resume --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Resume</label>
                <textarea name="resume" rows="3" placeholder="Ringkasan isi buku..."
                          class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition resize-none"></textarea>
            </div>

            {{-- Deskripsi --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Deskripsi</label>
                <textarea name="deskripsi" rows="3" placeholder="Deskripsi lengkap buku..."
                          class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition resize-none"></textarea>
            </div>

        </form>

        {{-- Footer --}}
        <div class="flex items-center justify-between px-6 sm:px-8 py-4 border-t border-neutral-100 bg-neutral-50">
            <div></div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="tutupModalBuku()"
                        class="text-sm font-medium px-4 py-2 rounded-lg text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 transition-colors">
                    Batal
                </button>
                <button type="button" onclick="submitTambahBuku()"
                        class="text-sm font-medium px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700 transition-colors">
                    Simpan Buku
                </button>
            </div>
        </div>

    </div>
</div>

<script>
    function bukaModalBuku() {
        const el = document.getElementById('modalTambahBuku');
        el.classList.remove('hidden');
        el.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function tutupModalBuku() {
        const el = document.getElementById('modalTambahBuku');
        el.classList.add('hidden');
        el.classList.remove('flex');
        document.body.style.overflow = '';
        resetErrorTambahBuku();
    }

    function bukaPaketDariTambahBuku() {
        tutupModalBuku();
        bukaModalTambahPaket('tambah_buku');
    }

    function resetErrorTambahBuku() {
        ['judul', 'pengarang', 'stok', 'paket'].forEach(field => {
            document.getElementById('err_' + field)?.classList.add('hidden');
        });
        ['tambah_judul', 'tambah_pengarang', 'tambah_stok', 'tambah_paket_id'].forEach(id => {
            document.getElementById(id)?.classList.remove(
                'border-danger-400', 'focus:ring-danger-200', 'focus:border-danger-400'
            );
        });
    }

    function setError(fieldId, errId, show) {
        const input = document.getElementById(fieldId);
        const err   = document.getElementById(errId);
        if (!input || !err) return;
        if (show) {
            err.classList.remove('hidden');
            input.classList.add('border-danger-400', 'focus:ring-danger-200', 'focus:border-danger-400');
            input.classList.remove('border-neutral-200');
        } else {
            err.classList.add('hidden');
            input.classList.remove('border-danger-400', 'focus:ring-danger-200', 'focus:border-danger-400');
            input.classList.add('border-neutral-200');
        }
    }

    function submitTambahBuku() {
        const judul     = document.getElementById('tambah_judul').value.trim();
        const pengarang = document.getElementById('tambah_pengarang').value.trim();
        const stok      = document.getElementById('tambah_stok').value;
        const paket     = document.getElementById('tambah_paket_id').value;

        setError('tambah_judul',     'err_judul',     !judul);
        setError('tambah_pengarang', 'err_pengarang', !pengarang);
        setError('tambah_stok',      'err_stok',      stok === '');
        setError('tambah_paket_id',  'err_paket',     !paket);

        if (!judul || !pengarang || stok === '' || !paket) return;

        document.getElementById('formTambahBuku').submit();
    }

    function handleTambahCoverFile(file) {
        if (!file || !file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = e => {
            const preview     = document.getElementById('preview-cover-tambah');
            const previewImg  = document.getElementById('preview-cover-tambah-img');
            const placeholder = document.getElementById('tambah-cover-placeholder');
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }

    document.getElementById('cover-input-tambah')?.addEventListener('change', function () {
        if (this.files[0]) handleTambahCoverFile(this.files[0]);
    });

    const tambahDropzone = document.getElementById('tambah-cover-dropzone');

    tambahDropzone?.addEventListener('dragover', e => {
        e.preventDefault();
        tambahDropzone.classList.add('border-primary-400', 'bg-primary-50');
    });

    tambahDropzone?.addEventListener('dragleave', () => {
        tambahDropzone.classList.remove('border-primary-400', 'bg-primary-50');
    });

    tambahDropzone?.addEventListener('drop', e => {
        e.preventDefault();
        tambahDropzone.classList.remove('border-primary-400', 'bg-primary-50');
        const file = e.dataTransfer.files[0];
        if (file) {
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('cover-input-tambah').files = dt.files;
            handleTambahCoverFile(file);
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') tutupModalBuku();
    });
</script>