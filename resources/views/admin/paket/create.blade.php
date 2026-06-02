<div id="modalTambahPaket"
     class="hidden fixed inset-0 z-[60] items-center justify-center bg-black/40 backdrop-blur-sm px-4">

    <div class="absolute inset-0" onclick="tutupModalTambahPaket()"></div>

    <div class="relative z-10 w-full max-w-md rounded-2xl bg-white border border-neutral-200 overflow-hidden shadow-xl">

        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 pt-6 pb-5 border-b border-neutral-100">
            <div>
                <h2 class="text-base font-semibold text-neutral-800">Buat Paket Baru</h2>
                <p class="text-sm text-neutral-400 mt-0.5">Paket digunakan untuk mengelompokkan buku rotasi</p>
            </div>
            <button type="button" onclick="tutupModalTambahPaket()"
                    class="p-2 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <div class="px-6 py-5 flex flex-col gap-4">
            <div class="flex flex-col gap-1.5">
                <label for="tambah_paket_nama" class="text-xs font-medium text-neutral-700">
                    Nama Paket <span class="text-danger-500">*</span>
                </label>
                <input type="text" id="tambah_paket_nama" placeholder="Contoh: Paket A"
                       class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                <p id="err_paket_nama" class="hidden text-[0.68rem] text-danger-500">Nama paket wajib diisi.</p>
            </div>

            <p id="paket_ajax_error" class="hidden text-[0.68rem] text-danger-500"></p>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-neutral-100 bg-neutral-50">
            <button type="button" onclick="tutupModalTambahPaket()"
                    class="text-sm font-medium px-4 py-2 rounded-lg text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 transition-colors">
                Batal
            </button>
            <button type="button" onclick="submitTambahPaket()"
                    id="btn_simpan_paket"
                    class="text-sm font-medium px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700 transition-colors">
                Simpan Paket
            </button>
        </div>

    </div>
</div>

<script>
    // 'caller' menyimpan modal mana yang membuka modal paket ini
    // supaya setelah paket dibuat, bisa kembali ke modal yang benar
    let _paketCaller = null;

    function bukaModalTambahPaket(caller = null) {
        _paketCaller = caller;
        document.getElementById('tambah_paket_nama').value = '';
        document.getElementById('err_paket_nama').classList.add('hidden');
        document.getElementById('paket_ajax_error').classList.add('hidden');

        const el = document.getElementById('modalTambahPaket');
        el.classList.remove('hidden');
        el.classList.add('flex');
        document.body.style.overflow = 'hidden';
        document.getElementById('tambah_paket_nama').focus();
    }

    function tutupModalTambahPaket() {
        const el = document.getElementById('modalTambahPaket');
        el.classList.add('hidden');
        el.classList.remove('flex');
        document.body.style.overflow = 'hidden'; // tetap hidden karena modal sebelumnya masih ada

        // Kembalikan ke modal pemanggil
        if (_paketCaller === 'tambah_buku') bukaModalBuku();
        if (_paketCaller === 'edit_buku')   {
            const el = document.getElementById('modalEditBuku');
            el.classList.remove('hidden');
            el.classList.add('flex');
        }
        _paketCaller = null;
    }

    async function submitTambahPaket() {
        const nama    = document.getElementById('tambah_paket_nama').value.trim();
        const errNama = document.getElementById('err_paket_nama');
        const errAjax = document.getElementById('paket_ajax_error');
        const btn     = document.getElementById('btn_simpan_paket');

        errNama.classList.add('hidden');
        errAjax.classList.add('hidden');

        if (!nama) {
            errNama.classList.remove('hidden');
            return;
        }

        btn.disabled    = true;
        btn.textContent = 'Menyimpan...';

        try {
            const res = await fetch('{{ route('admin.paket.store') }}', {
                method:  'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept':       'application/json',
                },
                body: JSON.stringify({ nama }),
            });

            const json = await res.json();

            if (!res.ok) {
                errAjax.textContent = json.errors?.nama?.[0] ?? 'Gagal menyimpan paket.';
                errAjax.classList.remove('hidden');
                return;
            }

            // Tambah opsi baru ke semua dropdown paket di halaman
            ['tambah_paket_id', 'edit_paket_id'].forEach(selectId => {
                const select = document.getElementById(selectId);
                if (!select) return;
                const option   = document.createElement('option');
                option.value   = json.id;
                option.text    = json.nama;
                option.selected = true;
                select.appendChild(option);
                select.dispatchEvent(new Event('change'));
            });

            tutupModalTambahPaket();

        } catch (e) {
            errAjax.textContent = 'Terjadi kesalahan. Coba lagi.';
            errAjax.classList.remove('hidden');
        } finally {
            btn.disabled    = false;
            btn.textContent = 'Simpan Paket';
        }
    }
</script>