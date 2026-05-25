<div class="step-content-{{ $prefix }} hidden" data-step="3">

    {{-- Search --}}
    <div class="mb-4">
        <label class="block text-sm font-medium text-neutral-600 mb-1.5">Cari Buku</label>
        <div class="flex gap-2">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text"
                       id="{{ $prefix }}_cariBukuDiterima"
                       placeholder="ISBN, judul, atau pengarang..."
                       class="w-full pl-9 pr-4 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
            <button onclick="cariBukuDiterima('{{ $prefix }}')"
                    class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium rounded-lg bg-primary-600 text-white hover:bg-primary-700 transition-colors shrink-0">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Cari
            </button>
        </div>
        <p class="text-xs text-neutral-400 mt-1.5">
            Masukkan ISBN untuk pencarian tepat, atau ketik judul/pengarang.
        </p>
        <div id="{{ $prefix }}_cariBukuDiterimaResults"
             class="hidden mt-2 rounded-lg border border-neutral-200 bg-white overflow-hidden shadow-sm max-h-44 overflow-y-auto">
        </div>
        <p id="{{ $prefix }}_cariBukuDiterimaInfo" class="text-xs mt-1.5"></p>
    </div>

    {{-- Selected book result --}}
    <div id="{{ $prefix }}_bukuDiterimaResult" class="hidden mb-4">
        <div class="p-4 rounded-xl border border-success-200 bg-success-50 flex items-start gap-3">
            <div class="w-9 h-9 rounded-lg bg-success-100 text-success-700 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     aria-hidden="true">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-success-800" id="{{ $prefix }}_bukuDiterimaJudul"></p>
                <p class="text-xs text-success-600 mt-0.5" id="{{ $prefix }}_bukuDiterimaPengarang"></p>
                <p class="text-xs text-success-600 mt-0.5">
                    Stok: <span id="{{ $prefix }}_bukuDiterimaStok" class="font-semibold"></span>
                    &nbsp;·&nbsp;
                    Lokasi: <span id="{{ $prefix }}_bukuDiterimaLokasi" class="font-semibold"></span>
                </p>
            </div>
            <button onclick="resetBukuDiterima('{{ $prefix }}')"
                    class="shrink-0 text-xs font-medium px-2.5 py-1.5 rounded-lg border border-success-200 text-success-700 hover:bg-success-100 transition-colors">
                Ganti
            </button>
        </div>
        <input type="hidden" id="{{ $prefix }}_bukuDiterimaId"/>
    </div>

    {{-- Divider --}}
    <div class="relative flex items-center gap-3 my-5">
        <div class="flex-1 h-px bg-neutral-100"></div>
        <span class="text-xs text-neutral-400 font-medium shrink-0">Buku Tersedia</span>
        <div class="flex-1 h-px bg-neutral-100"></div>
    </div>

    {{-- Book list --}}
    <div id="{{ $prefix }}_listBukuLokasi"
         class="rounded-lg border border-neutral-200 bg-white overflow-hidden max-h-52 overflow-y-auto">
        <div class="px-4 py-5 text-center text-sm text-neutral-400">Memuat daftar buku...</div>
    </div>

</div>