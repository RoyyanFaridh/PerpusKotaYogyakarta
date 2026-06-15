<div id="modalEdit" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeEdit()"></div>

    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-warning-400"></div>

        <div class="flex items-center justify-between px-6 sm:px-8 pt-6 pb-5 border-b border-neutral-100">
            <div>
                <h2 class="text-base font-semibold text-neutral-800">Edit Transaksi</h2>
                <p class="text-sm text-neutral-400 mt-0.5" id="editSubtitle">Langkah 1 dari 4</p>
            </div>
            <button onclick="closeEdit()"
                    aria-label="Tutup modal"
                    class="p-2 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     aria-hidden="true">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        @include('admin.transaksi._step-indicator', ['prefix' => 'edit'])

        <div class="px-6 sm:px-8 py-6 min-h-96">
            @include('admin.transaksi._step-member',     ['prefix' => 'edit'])
            @include('admin.transaksi._step-masuk', ['prefix' => 'edit'])
            @include('admin.transaksi._step-keluar',   ['prefix' => 'edit'])
            @include('admin.transaksi._step-konfirmasi', ['prefix' => 'edit'])
        </div>

        <div class="flex items-center justify-between px-6 sm:px-8 py-4 border-t border-neutral-100 bg-neutral-50">
            <button id="editBtnPrev" onclick="prevStep('edit')"
                    class="hidden text-sm font-medium px-4 py-2 rounded-lg border border-neutral-200 text-neutral-600 hover:bg-white transition-colors">
                Sebelumnya
            </button>
            <div class="ml-auto flex items-center gap-2">
                <button onclick="closeEdit()"
                        class="text-sm font-medium px-4 py-2 rounded-lg text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 transition-colors">
                    Batal
                </button>
                <button id="editBtnNext" onclick="nextStep('edit')"
                        class="text-sm font-medium px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700 transition-colors">
                    Selanjutnya
                </button>
                <button id="editBtnSimpan" onclick="updateTransaksi()"
                        class="hidden text-sm font-medium px-4 py-2 rounded-lg bg-warning-500 text-white hover:bg-warning-600 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </div>

    </div>
</div>