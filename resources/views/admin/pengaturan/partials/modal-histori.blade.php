<div id="modal-histori"
     class="fixed inset-0 z-[500] flex items-center justify-center p-4 hidden"
     role="dialog" aria-modal="true" aria-labelledby="modal-histori-title">

    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="tutupModalHistori()"></div>

    <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-neutral-300"></div>

        <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-neutral-100">
            <div>
                <h3 id="modal-histori-title" class="text-sm font-semibold text-neutral-800">Histori Penugasan</h3>
                <p id="modal-histori-subtitle" class="text-xs text-neutral-400 mt-0.5"></p>
            </div>
            <button type="button" onclick="tutupModalHistori()" aria-label="Tutup"
                    class="p-1.5 rounded-lg text-neutral-300 hover:text-neutral-500 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div id="modal-histori-body" class="px-6 py-5 max-h-96 overflow-y-auto custom-scroll">
            <p class="text-sm text-neutral-400 text-center py-6">Memuat data...</p>
        </div>
    </div>
</div>