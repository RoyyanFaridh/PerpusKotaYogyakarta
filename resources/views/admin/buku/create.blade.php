<div id="modalTambahBuku"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">

    <div class="absolute inset-0" onclick="tutupModalBuku()"></div>

    <div class="relative z-10 w-full max-w-2xl rounded-xl bg-white border border-neutral-200 overflow-hidden shadow-lg">

        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-neutral-100 shrink-0">
            <div>
                <h2 class="text-sm font-semibold text-neutral-800">Tambah Buku</h2>
                <p class="text-xs text-neutral-400 mt-0.5">Isi data buku baru</p>
            </div>
            <button type="button" onclick="tutupModalBuku()"
                    class="p-1 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('admin.buku.store') }}"
              class="px-6 py-5 flex flex-col gap-4 max-h-[75vh] overflow-y-auto custom-scroll">
            @csrf

            {{-- Judul & Pengarang --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Judul <span class="text-danger-500">*</span></label>
                    <input type="text" name="judul" required placeholder="Judul buku"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Pengarang <span class="text-danger-500">*</span></label>
                    <input type="text" name="pengarang" required placeholder="Nama pengarang"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
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
                        @foreach (['Novel','Sains','Sejarah','Teknologi','Anak-anak','Lainnya'] as $kat)
                            <option value="{{ $kat }}">{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Stok <span class="text-danger-500">*</span></label>
                    <input type="number" name="stok" required min="0" value="0"
                           class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                </div>
            </div>

            {{-- Sumber & Kondisi --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Sumber <span class="text-danger-500">*</span></label>
                    <select name="sumber" required
                            class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white">
                        <option value="perpus">Perpustakaan</option>
                        <option value="tukar">Tukar</option>
                    </select>
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

            {{-- Lokasi & Member --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Lokasi</label>
                    <select name="lokasi_id"
                            class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white">
                        <option value="">Pilih lokasi</option>
                        @foreach ($lokasis as $lokasi)
                            <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Member</label>
                    <select name="member_id"
                            class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white">
                        <option value="">Pilih member</option>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}">{{ $member->nama }}</option>
                        @endforeach
                    </select>
                </div>
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

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-2 pt-2 border-t border-neutral-100">
                <button type="button" onclick="tutupModalBuku()"
                        class="px-4 py-2 text-xs font-medium rounded-lg border border-neutral-200 text-neutral-600 hover:bg-neutral-50 transition">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 text-xs font-medium rounded-lg bg-primary-500 text-white hover:bg-primary-600 transition">
                    Simpan Buku
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function bukaModalBuku() {
        document.getElementById('modalTambahBuku').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function tutupModalBuku() {
        document.getElementById('modalTambahBuku').classList.add('hidden');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') tutupModalBuku();
    });
</script>