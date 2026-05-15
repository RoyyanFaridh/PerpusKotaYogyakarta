<div id="modalCreate" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeCreate()"></div>

    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-neutral-100">
            <div>
                <h2 class="text-sm font-semibold text-neutral-800">Transaksi Baru</h2>
                <p class="text-xs text-neutral-400 mt-0.5" id="createSubtitle">Langkah 1 dari 4</p>
            </div>
            <button onclick="closeCreate()" class="p-1.5 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        @include('admin.transaksi._step-indicator', ['prefix' => 'create'])

        <div class="px-6 py-5 min-h-70">
            {{-- Global hidden inputs --}}
            <input type="hidden" id="{{ 'create' }}_lokasiId"   value="{{ $lokasiUser?->id ?? '' }}"/>
            <input type="hidden" id="{{ 'create' }}_lokasiNama" value="{{ $lokasiUser?->nama_lokasi ?? '' }}"/>
            <input type="hidden" id="{{ 'create' }}_memberId"/>

            @include('admin.transaksi._step-member',     ['prefix' => 'create'])
            @include('admin.transaksi._step-diserahkan', ['prefix' => 'create'])
            @include('admin.transaksi._step-diterima',   ['prefix' => 'create'])
            @include('admin.transaksi._step-konfirmasi', ['prefix' => 'create'])
        </div>

        <div class="flex items-center justify-between px-6 py-4 border-t border-neutral-100 bg-neutral-50">
            <button id="createBtnPrev" onclick="prevStep('create')"
                    class="hidden text-xs font-medium px-4 py-2 rounded-lg border border-neutral-200 text-neutral-600 hover:bg-white transition-colors">
                ← Sebelumnya
            </button>
            <div class="ml-auto flex gap-2">
                <button onclick="closeCreate()"
                        class="text-xs font-medium px-4 py-2 rounded-lg border border-neutral-200 text-neutral-500 hover:bg-white transition-colors">
                    Batal
                </button>
                <button id="createBtnNext" onclick="nextStep('create')"
                        class="text-xs font-medium px-4 py-2 rounded-lg bg-primary text-white hover:bg-primary-600 transition-colors">
                    Selanjutnya →
                </button>
                <button id="createBtnSimpan" onclick="simpanTransaksi()"
                        class="hidden text-xs font-medium px-4 py-2 rounded-lg bg-primary text-white hover:bg-primary-600 transition-colors">
                    Simpan Transaksi
                </button>
            </div>
        </div>
    </div>
</div>