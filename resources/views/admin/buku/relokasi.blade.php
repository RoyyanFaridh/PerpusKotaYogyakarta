{{-- resources/views/admin/buku/relokasi.blade.php --}}
{{-- @include('admin.buku.relokasi') di index.blade.php --}}

<div id="modalRelokasi"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 backdrop-blur-sm px-4">

    <div class="absolute inset-0" onclick="tutupModalRelokasi()"></div>

    <div class="relative z-10 w-full max-w-2xl rounded-2xl bg-white overflow-hidden shadow-xl flex flex-col max-h-[90vh]">

        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 pt-6 pb-5 border-b border-neutral-100 shrink-0">
            <div>
                <h2 class="text-base font-semibold text-neutral-800">Relokasi Buku</h2>
                <p class="text-sm text-neutral-400 mt-0.5">Pindahkan buku antar lokasi untuk keperluan event</p>
            </div>
            <button type="button" onclick="tutupModalRelokasi()"
                    class="p-2 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Step 1: Pilih Lokasi Asal + Tujuan --}}
        <div id="relokasiStep1" class="px-6 py-5 border-b border-neutral-100 shrink-0">
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Lokasi Asal <span class="text-danger-500">*</span></label>
                    <select id="relokasi_lokasi_asal"
                            class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white"
                            onchange="relokasiMuatBuku()">
                        <option value="">Pilih lokasi asal</option>
                        @foreach ($lokasis as $lokasi)
                            <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-neutral-700">Lokasi Tujuan <span class="text-danger-500">*</span></label>
                    <select id="relokasi_lokasi_tujuan"
                            class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white">
                        <option value="">Pilih lokasi tujuan</option>
                        @foreach ($lokasis as $lokasi)
                            <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Daftar Buku --}}
        <div class="flex-1 overflow-y-auto custom-scroll">

            {{-- Loading state --}}
            <div id="relokasiLoading" class="hidden px-6 py-10 flex-col items-center gap-2 text-neutral-400">
                <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                </svg>
                <p class="text-xs">Memuat buku...</p>
            </div>

            {{-- Empty state --}}
            <div id="relokasiEmpty" class="hidden px-6 py-10 flex-col items-center gap-2">
                <div class="w-10 h-10 rounded-xl bg-neutral-100 flex items-center justify-center">
                    <x-icons.book class="w-5 h-5 text-neutral-400"/>
                </div>
                <p class="text-sm font-medium text-neutral-500">Tidak ada buku tersedia</p>
                <p class="text-xs text-neutral-400">Lokasi ini tidak memiliki stok buku</p>
            </div>

            {{-- Tabel buku --}}
            <div id="relokasiTableWrap" class="hidden">

                {{-- Toolbar select all --}}
                <div class="flex items-center justify-between px-6 py-3 bg-neutral-50 border-b border-neutral-100 sticky top-0 z-10">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" id="relokasiSelectAll" onchange="relokasiToggleAll(this)"
                               class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-300"/>
                        <span class="text-xs font-medium text-neutral-600">Pilih semua</span>
                    </label>
                    <span id="relokasiSelectedCount" class="text-xs text-neutral-400">0 dipilih</span>
                </div>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-neutral-100">
                            <th class="w-10 px-6 py-2.5"></th>
                            <th class="text-left text-xs font-semibold text-neutral-500 px-4 py-2.5">Judul</th>
                            <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-2.5">Stok</th>
                            <th class="text-center text-xs font-semibold text-neutral-500 px-4 py-2.5 w-28">Jumlah Pindah</th>
                        </tr>
                    </thead>
                    <tbody id="relokasiTableBody" class="divide-y divide-neutral-50">
                        {{-- diisi oleh JS --}}
                    </tbody>
                </table>
            </div>

        </div>

        {{-- Error banner --}}
        <div id="relokasiError"
             class="hidden mx-6 my-3 items-start gap-2.5 px-4 py-3 bg-danger-50 border border-danger-100 rounded-lg text-danger-700 text-xs shrink-0">
            <svg class="w-4 h-4 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span id="relokasiErrorMsg"></span>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-between px-6 py-4 border-t border-neutral-100 bg-neutral-50 shrink-0">
            <div></div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="tutupModalRelokasi()"
                        class="text-sm font-medium px-4 py-2 rounded-lg text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 transition-colors">
                    Batal
                </button>
                <button type="button" id="relokasiSubmitBtn" onclick="relokasiSubmit()"
                        disabled
                        class="text-sm font-medium px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700 transition-colors disabled:opacity-40 disabled:cursor-not-allowed flex items-center gap-1.5">
                    <span id="relokasiSubmitLabel">Pindahkan Buku</span>
                    <svg id="relokasiSubmitSpinner" class="hidden w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
(function () {

    // ─── State ───────────────────────────────────────────────────────────────
    let bukuList   = [];   // [{id, judul, pengarang, stok, ...}]
    let selections = {};   // { buku_id: jumlah } — hanya yang dipilih

    // ─── Elemen ──────────────────────────────────────────────────────────────
    const modal        = () => document.getElementById('modalRelokasi');
    const elLoading    = () => document.getElementById('relokasiLoading');
    const elEmpty      = () => document.getElementById('relokasiEmpty');
    const elTableWrap  = () => document.getElementById('relokasiTableWrap');
    const elTbody      = () => document.getElementById('relokasiTableBody');
    const elSelectAll  = () => document.getElementById('relokasiSelectAll');
    const elCount      = () => document.getElementById('relokasiSelectedCount');
    const elSubmitBtn  = () => document.getElementById('relokasiSubmitBtn');
    const elError      = () => document.getElementById('relokasiError');
    const elErrorMsg   = () => document.getElementById('relokasiErrorMsg');
    const elSpinner    = () => document.getElementById('relokasiSubmitSpinner');

    // ─── Buka / Tutup ────────────────────────────────────────────────────────
    window.bukaModalRelokasi = function () {
        reset();
        modal().classList.remove('hidden');
        modal().classList.add('flex');
        document.body.style.overflow = 'hidden';
    };

    window.tutupModalRelokasi = function () {
        modal().classList.add('hidden');
        modal().classList.remove('flex');
        document.body.style.overflow = '';
    };

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') window.tutupModalRelokasi();
    });

    // ─── Reset state ----------------------------------------------------------
    function reset() {
        bukuList   = [];
        selections = {};
        document.getElementById('relokasi_lokasi_asal').value   = '';
        document.getElementById('relokasi_lokasi_tujuan').value = '';
        tampilState('idle');
        updateSubmitBtn();
        sembunyiError();
    }

    // ─── State display ────────────────────────────────────────────────────────
    function tampilState(state) {
        elLoading().classList.add('hidden');
        elEmpty().classList.add('hidden');
        elTableWrap().classList.add('hidden');

        if (state === 'loading') elLoading().classList.remove('hidden');
        if (state === 'empty')   elEmpty().classList.remove('hidden');
        if (state === 'table')   elTableWrap().classList.remove('hidden');
    }

    // ─── Muat buku dari lokasi asal ──────────────────────────────────────────
    window.relokasiMuatBuku = async function () {
        const lokasiId = document.getElementById('relokasi_lokasi_asal').value;
        selections = {};
        sembunyiError();

        if (! lokasiId) {
            tampilState('idle');
            updateSubmitBtn();
            return;
        }

        tampilState('loading');

        try {
            const res  = await fetch(`{{ route('admin.buku.relokasi.index') }}?lokasi_id=${lokasiId}`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();

            bukuList = data;

            if (bukuList.length === 0) {
                tampilState('empty');
            } else {
                renderTabel();
                tampilState('table');
            }
        } catch (err) {
            tampilState('empty');
            tampilError('Gagal memuat buku. Coba lagi.');
        }

        updateSubmitBtn();
    };

    // ─── Render tabel ────────────────────────────────────────────────────────
    function renderTabel() {
        elTbody().innerHTML = bukuList.map(buku => `
            <tr class="hover:bg-neutral-50 transition-colors" id="row-${buku.id}">
                <td class="px-6 py-3">
                    <input type="checkbox"
                           id="chk-${buku.id}"
                           data-id="${buku.id}"
                           data-stok="${buku.stok}"
                           onchange="relokasiToggleRow(this)"
                           class="w-4 h-4 rounded border-neutral-300 text-primary-600 focus:ring-primary-300"/>
                </td>
                <td class="px-4 py-3">
                    <p class="text-xs font-semibold text-neutral-800 max-w-xs truncate">${esc(buku.judul)}</p>
                    <p class="text-xs text-neutral-400 mt-0.5">${esc(buku.pengarang)}</p>
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-success-50 text-success-700">${buku.stok} tersedia</span>
                </td>
                <td class="px-4 py-3 text-center">
                    <input type="number"
                           id="qty-${buku.id}"
                           data-id="${buku.id}"
                           min="1" max="${buku.stok}"
                           value="${buku.stok}"
                           disabled
                           onchange="relokasiUpdateQty(this)"
                           class="w-20 text-center text-sm px-2 py-1.5 rounded-lg border border-neutral-200 text-neutral-800
                                  focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400
                                  disabled:bg-neutral-50 disabled:text-neutral-300 disabled:cursor-not-allowed transition"/>
                </td>
            </tr>
        `).join('');

        elSelectAll().checked       = false;
        elSelectAll().indeterminate = false;
        updateCount();
    }

    // ─── Toggle satu row ─────────────────────────────────────────────────────
    window.relokasiToggleRow = function (chk) {
        const id  = parseInt(chk.dataset.id);
        const qty = document.getElementById(`qty-${id}`);

        if (chk.checked) {
            qty.disabled     = false;
            selections[id]   = parseInt(qty.value) || 1;
        } else {
            qty.disabled     = true;
            delete selections[id];
        }

        syncSelectAll();
        updateCount();
        updateSubmitBtn();
    };

    // ─── Toggle semua ────────────────────────────────────────────────────────
    window.relokasiToggleAll = function (masterChk) {
        bukuList.forEach(buku => {
            const chk = document.getElementById(`chk-${buku.id}`);
            const qty = document.getElementById(`qty-${buku.id}`);
            chk.checked  = masterChk.checked;
            qty.disabled = ! masterChk.checked;
            if (masterChk.checked) {
                selections[buku.id] = parseInt(qty.value) || buku.stok;
            } else {
                delete selections[buku.id];
            }
        });

        updateCount();
        updateSubmitBtn();
    };

    // ─── Update qty dari input ────────────────────────────────────────────────
    window.relokasiUpdateQty = function (input) {
        const id   = parseInt(input.dataset.id);
        const buku = bukuList.find(b => b.id === id);
        let val    = parseInt(input.value) || 1;

        if (val < 1)         val = 1;
        if (val > buku.stok) val = buku.stok;
        input.value = val;

        if (selections[id] !== undefined) {
            selections[id] = val;
        }
    };

    // ─── Sync checkbox "pilih semua" ─────────────────────────────────────────
    function syncSelectAll() {
        const total    = bukuList.length;
        const checked  = Object.keys(selections).length;
        elSelectAll().checked       = checked === total && total > 0;
        elSelectAll().indeterminate = checked > 0 && checked < total;
    }

    // ─── Update counter teks ─────────────────────────────────────────────────
    function updateCount() {
        const n = Object.keys(selections).length;
        elCount().textContent = n === 0 ? '0 dipilih' : `${n} buku dipilih`;
    }

    // ─── Enable/disable tombol submit ────────────────────────────────────────
    function updateSubmitBtn() {
        const ok = Object.keys(selections).length > 0;
        elSubmitBtn().disabled = ! ok;
    }

    // ─── Error banner ────────────────────────────────────────────────────────
    function tampilError(msg) {
        elErrorMsg().textContent = msg;
        elError().classList.remove('hidden');
        elError().classList.add('flex');
    }

    function sembunyiError() {
        elError().classList.add('hidden');
        elError().classList.remove('flex');
    }

    // ─── Submit relokasi ─────────────────────────────────────────────────────
    window.relokasiSubmit = async function () {
        sembunyiError();

        const lokasiTujuanId = document.getElementById('relokasi_lokasi_tujuan').value;

        if (! lokasiTujuanId) {
            tampilError('Pilih lokasi tujuan terlebih dahulu.');
            return;
        }

        const lokasiAsalId = document.getElementById('relokasi_lokasi_asal').value;
        if (lokasiTujuanId === lokasiAsalId) {
            tampilError('Lokasi tujuan tidak boleh sama dengan lokasi asal.');
            return;
        }

        const items = Object.entries(selections).map(([buku_id, jumlah]) => ({
            buku_id: parseInt(buku_id),
            jumlah,
        }));

        if (items.length === 0) {
            tampilError('Pilih minimal satu buku untuk direlokasi.');
            return;
        }

        // Loading state
        elSubmitBtn().disabled = true;
        elSpinner().classList.remove('hidden');

        try {
            const res = await fetch('{{ route('admin.buku.relokasi.store') }}', {
                method:  'POST',
                headers: {
                    'Content-Type':     'application/json',
                    'Accept':           'application/json',
                    'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ lokasi_tujuan_id: parseInt(lokasiTujuanId), items }),
            });

            const data = await res.json();

            if (! res.ok) {
                // Validasi error dari Laravel
                const pesan = data.message
                    ?? Object.values(data.errors ?? {})?.[0]?.[0]
                    ?? 'Terjadi kesalahan.';
                tampilError(pesan);
                return;
            }

            // Sukses — reload halaman dengan flash message
            window.location.reload();

        } catch (err) {
            tampilError('Gagal terhubung ke server. Coba lagi.');
        } finally {
            elSubmitBtn().disabled = false;
            elSpinner().classList.add('hidden');
        }
    };

    // ─── Escape helper ───────────────────────────────────────────────────────
    function esc(str) {
        return String(str ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

})();
</script>
@endpush