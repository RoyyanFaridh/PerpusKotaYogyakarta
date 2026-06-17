<div class="step-content-{{ $prefix }} hidden" data-step="{{ 2 + ($offset ?? 0) }}">

    {{-- Paket Tujuan --}}
    <div class="mb-5">
        <label class="block text-sm font-medium text-neutral-600 mb-1.5">
            Paket Tujuan <span class="text-danger-500">*</span>
        </label>
        <select id="{{ $prefix }}_paketMasukId"
                class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition bg-white">
            <option value="">Memuat paket...</option>
        </select>
        <p class="text-xs text-neutral-400 mt-1.5">Paket tempat buku yang masuk dari member akan disimpan.</p>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-neutral-600 mb-1.5">Scan / Cari Buku</label>
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="{{ $prefix }}_cariMasuk"
                placeholder="Ketik judul, pengarang, atau scan ISBN..."
                autocomplete="off"
                class="w-full pl-9 pr-4 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            <div id="{{ $prefix }}_cariMasukResults"
                class="hidden absolute z-20 left-0 right-0 top-full mt-1 bg-white border border-neutral-200 rounded-lg shadow-lg max-h-52 overflow-y-auto">
            </div>
        </div>
        <p id="{{ $prefix }}_cariMasukInfo" class="text-xs text-neutral-400 mt-1.5"></p>
    </div>

    <div class="relative flex items-center gap-3 my-5">
        <div class="flex-1 h-px bg-neutral-100"></div>
        <span class="text-xs text-neutral-400 font-medium shrink-0">Detail Buku</span>
        <div class="flex-1 h-px bg-neutral-100"></div>
    </div>

    <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-neutral-600 mb-1.5">
                    Judul <span class="text-danger-500">*</span>
                </label>
                <input type="text" id="{{ $prefix }}_masukJudul" placeholder="Judul buku"
                       class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-600 mb-1.5">
                    Pengarang <span class="text-danger-500">*</span>
                </label>
                <input type="text" id="{{ $prefix }}_masukPengarang" placeholder="Nama pengarang"
                       class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
        </div>

        {{-- ISBN --}}
        <div>
            <label class="block text-sm font-medium text-neutral-600 mb-1.5">
                ISBN
                <span class="text-xs font-normal text-neutral-400 ml-1">opsional</span>
            </label>
            <input type="text" id="{{ $prefix }}_isbnMasuk"
                placeholder="cth. 9786020651040"
                class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition font-mono"/>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-neutral-600 mb-1.5">
                    Penerbit
                    <span class="text-xs font-normal text-neutral-400 ml-1">opsional</span>
                </label>
                <input type="text" id="{{ $prefix }}_masukPenerbit" placeholder="Nama penerbit"
                       class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-600 mb-1.5">
                    Kategori
                    <span class="text-xs font-normal text-neutral-400 ml-1">opsional</span>
                </label>
                <select id="{{ $prefix }}_masukKategori"
                        class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition bg-white">
                    <option value="">Pilih kategori</option>
                    @foreach ([
                        'Umum/Komputer','Filsafat & Psikologi','Agama','Ilmu Sosial',
                        'Bahasa','Sains & Matematika','Teknologi','Seni & Rekreasi',
                        'Literatur & Sastra','Geografi & Sejarah',
                    ] as $kat)
                        <option value="{{ $kat }}">{{ $kat }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-neutral-600 mb-1.5">
                    Tahun Terbit
                    <span class="text-xs font-normal text-neutral-400 ml-1">opsional</span>
                </label>
                <input type="number" id="{{ $prefix }}_masukTahunTerbit"
                       placeholder="cth. 2021" min="1900" max="{{ date('Y') }}"
                       class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-600 mb-1.5">
                    Tempat Terbit
                    <span class="text-xs font-normal text-neutral-400 ml-1">opsional</span>
                </label>
                <input type="text" id="{{ $prefix }}_masukTempatTerbit" placeholder="cth. Jakarta"
                       class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-neutral-600 mb-1.5">
                Deskripsi
                <span class="text-xs font-normal text-neutral-400 ml-1">opsional</span>
            </label>
            <textarea id="{{ $prefix }}_masukDeskripsi" rows="2"
                      placeholder="Catatan kondisi buku..."
                      class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition resize-none"></textarea>
        </div>
    </div>

</div>