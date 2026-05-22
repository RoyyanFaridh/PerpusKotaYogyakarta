<input type="hidden" id="{{ $prefix }}_lokasiId" value="{{ $lokasiUser?->id ?? '' }}"/>
<input type="hidden" id="{{ $prefix }}_memberId"/>

<div class="step-content-{{ $prefix }} hidden" data-step="2">
    <div class="mb-5">
        <label class="block text-sm font-medium text-neutral-600 mb-2">Scan / Cari ISBN</label>
        <div class="flex gap-2">
            <input type="text" id="{{ $prefix }}_isbnDiserahkan" placeholder="Scan atau ketik ISBN..."
                class="flex-1 px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition font-mono"/>
            <button onclick="cariIsbnDiserahkan('{{ $prefix }}')" class="px-4 py-2.5 text-sm rounded-lg bg-primary-50 text-primary-700 hover:bg-primary-100 transition-colors font-medium">Cari</button>
        </div>
        <p id="{{ $prefix }}_isbnDiserahkanInfo" class="text-xs text-neutral-400 mt-1.5"></p>
    </div>
    <div class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-neutral-600 mb-1.5">Judul <span class="text-danger-500">*</span></label>
                <input type="text" id="{{ $prefix }}_diserahkanJudul" placeholder="Judul buku"
                    class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-600 mb-1.5">Pengarang <span class="text-danger-500">*</span></label>
                <input type="text" id="{{ $prefix }}_diserahkanPengarang" placeholder="Nama pengarang"
                    class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-neutral-600 mb-1.5">Penerbit</label>
                <input type="text" id="{{ $prefix }}_diserahkanPenerbit" placeholder="Nama penerbit"
                    class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-600 mb-1.5">Kategori</label>
                <select id="{{ $prefix }}_diserahkanKategori"
                    class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition bg-white">
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
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-neutral-600 mb-1.5">Tahun Terbit</label>
                <input type="number" id="{{ $prefix }}_diserahkanTahunTerbit" placeholder="cth. 2021"
                    min="1900" max="{{ date('Y') }}"
                    class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-600 mb-1.5">Tempat Terbit</label>
                <input type="text" id="{{ $prefix }}_diserahkanTempatTerbit" placeholder="cth. Jakarta"
                    class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-neutral-600 mb-1.5">Kondisi <span class="text-danger-500">*</span></label>
            <div class="flex gap-2">
                @foreach (['baik' => 'Baik', 'cukup' => 'Cukup', 'rusak' => 'Rusak'] as $val => $lbl)
                    <label class="kondisi-option-{{ $prefix }} flex-1 flex items-center justify-center gap-2 px-3.5 py-2.5 rounded-lg border border-neutral-200 cursor-pointer hover:bg-neutral-50 transition-colors text-sm font-medium text-neutral-600"
                        data-value="{{ $val }}" data-prefix="{{ $prefix }}">
                        <input type="radio" name="{{ $prefix }}_diserahkanKondisi" value="{{ $val }}" class="hidden"/>
                        {{ $lbl }}
                    </label>
                @endforeach
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-neutral-600 mb-1.5">Deskripsi</label>
            <textarea id="{{ $prefix }}_diserahkanDeskripsi" rows="2" placeholder="Catatan kondisi buku..."
                class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition resize-none"></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-neutral-600 mb-1.5">Lokasi Perpustakaan</label>
            <div class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-lg border border-neutral-200 bg-neutral-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-neutral-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                </svg>
                <span class="text-sm text-neutral-700 font-medium">
                    {{ $lokasiUser?->nama_lokasi ?? 'Lokasi tidak ditemukan' }}
                </span>
            </div>
        </div>
    </div>
</div>