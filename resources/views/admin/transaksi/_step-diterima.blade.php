<div class="step-content-{{ $prefix }} hidden" data-step="3">

    {{-- Cari by ISBN atau Judul --}}
    <div class="mb-4">
        <label class="block text-xs font-medium text-neutral-600 mb-1.5">Cari Buku</label>
        <div class="flex gap-2">
            <input type="text" id="{{ $prefix }}_cariBukuDiterima" placeholder="ISBN, judul, atau pengarang..."
                class="flex-1 px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition font-mono"/>
            <button onclick="cariBukuDiterima('{{ $prefix }}')"
                class="px-3 py-2 text-xs rounded-lg bg-primary-50 text-primary-700 hover:bg-primary-100 transition-colors font-medium">
                Cari
            </button>
        </div>
        <p class="text-[0.68rem] text-neutral-400 mt-1">Masukkan ISBN untuk pencarian tepat, atau ketik judul/pengarang</p>

        {{-- Hasil pencarian --}}
        <div id="{{ $prefix }}_cariBukuDiterimaResults"
            class="hidden mt-1.5 rounded-lg border border-neutral-200 bg-white overflow-hidden shadow-sm max-h-40 overflow-y-auto">
        </div>
        <p id="{{ $prefix }}_cariBukuDiterimaInfo" class="text-[0.68rem] mt-1"></p>
    </div>

    {{-- Hasil buku terpilih --}}
    <div id="{{ $prefix }}_bukuDiterimaResult" class="hidden">
        <div class="p-3.5 rounded-xl border border-success-200 bg-success-50 flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-success-100 text-success-700 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-success-800" id="{{ $prefix }}_bukuDiterimaJudul"></p>
                <p class="text-[0.68rem] text-success-600 mt-0.5" id="{{ $prefix }}_bukuDiterimaPengarang"></p>
                <p class="text-[0.68rem] text-success-600 mt-0.5">
                    Stok: <span id="{{ $prefix }}_bukuDiterimaStok" class="font-semibold"></span>
                    &nbsp;·&nbsp;
                    Lokasi: <span id="{{ $prefix }}_bukuDiterimaLokasi" class="font-semibold"></span>
                </p>
            </div>
            <button onclick="resetBukuDiterima('{{ $prefix }}')" class="text-[0.68rem] text-success-600 hover:text-success-800 underline shrink-0">Ganti</button>
        </div>
        <input type="hidden" id="{{ $prefix }}_bukuDiterimaId"/>
    </div>

    {{-- Empty state --}}
    <div id="{{ $prefix }}_bukuDiterimaEmpty" class="flex flex-col items-center justify-center py-8 text-center">
        <div class="w-10 h-10 rounded-xl bg-neutral-100 flex items-center justify-center mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-neutral-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
        </div>
        <p class="text-xs font-medium text-neutral-500">Cari buku menggunakan ISBN atau judul</p>
        <p class="text-[0.68rem] text-neutral-400 mt-0.5">Hanya buku dengan stok tersedia yang bisa dipilih</p>
    </div>
</div>