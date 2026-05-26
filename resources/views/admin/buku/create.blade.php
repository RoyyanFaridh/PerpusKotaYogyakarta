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
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form id="formTambahBuku" method="POST" action="{{ route('admin.buku.store') }}"
              class="px-6 sm:px-8 py-6 flex flex-col gap-4 max-h-[75vh] overflow-y-auto custom-scroll">
            @csrf

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
                            'Umum/Komputer',
                            'Filsafat & Psikologi',
                            'Agama',
                            'Ilmu Sosial',
                            'Bahasa',
                            'Sains & Matematika',
                            'Teknologi',
                            'Seni & Rekreasi',
                            'Literatur & Sastra',
                            'Geografi & Sejarah',
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

            {{-- Sumber & Kondisi --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Sumber <span class="text-danger-500">*</span></label>
                    <select name="sumber" id="tambah_sumber"
                            class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white">
                        <option value="">Pilih sumber</option>
                        <option value="perpus">Perpustakaan</option>
                        <option value="tukar">Tukar</option>
                    </select>
                    <p id="err_sumber" class="hidden text-[0.68rem] text-danger-500">Sumber wajib dipilih.</p>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Kondisi</label>
                    <select name="kondisi"
                            class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white">
                        <option value="">-</option>
                        <option value="baik">Baik</option>
                        <option value="cukup">Cukup</option>
                        <option value="rusak">Rusak</option>
                    </select>
                </div>
            </div>

            {{-- Lokasi --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-medium text-neutral-700">Lokasi <span class="text-danger-500">*</span></label>
                <select name="lokasi_id" id="tambah_lokasi_id"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white">
                    <option value="">Pilih lokasi</option>
                    @foreach ($lokasis as $lokasi)
                        <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>
                    @endforeach
                </select>
                <p id="err_lokasi_id" class="hidden text-[0.68rem] text-danger-500">Lokasi wajib dipilih.</p>
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
                        class="text-sm font-medium px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-success-700 transition-colors">
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

    function resetErrorTambahBuku() {
        ['judul', 'pengarang', 'stok', 'sumber', 'lokasi_id'].forEach(field => {
            const err   = document.getElementById('err_' + field);
            const input = document.getElementById('tambah_' + field);
            if (err)   err.classList.add('hidden');
            if (input) input.classList.remove('border-danger-400', 'focus:ring-danger-200', 'focus:border-danger-400');
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
        const sumber    = document.getElementById('tambah_sumber').value;
        const lokasiId  = document.getElementById('tambah_lokasi_id').value;

        const errJudul     = !judul;
        const errPengarang = !pengarang;
        const errStok      = stok === '';
        const errSumber    = !sumber;
        const errLokasi    = !lokasiId;

        setError('tambah_judul',     'err_judul',     errJudul);
        setError('tambah_pengarang', 'err_pengarang', errPengarang);
        setError('tambah_stok',      'err_stok',      errStok);
        setError('tambah_sumber',    'err_sumber',    errSumber);
        setError('tambah_lokasi_id', 'err_lokasi_id', errLokasi);

        if (errJudul || errPengarang || errStok || errSumber || errLokasi) return;

        document.getElementById('formTambahBuku').submit();
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') tutupModalBuku();
    });
</script>