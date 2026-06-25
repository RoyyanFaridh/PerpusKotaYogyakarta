
<section id="katalog-section"
         class="relative z-10 pt-4 pb-14 px-8 max-w-6xl mx-auto">

    
    <div class="flex items-center justify-between mb-4 sm:mb-6 px-1">
        <div class="text-left">
            <p class="text-xs font-semibold tracking-widest uppercase text-primary-400 mb-1">Hasil Pencarian</p>
            <h2 id="katalog-title"
                class="font-bold text-primary-900 text-sm sm:text-lg leading-tight">
            </h2>
        </div>
        <button id="katalog-close"
                class="flex items-center gap-1.5 text-xs font-medium text-neutral-400 hover:text-primary-600 transition-colors px-2 py-1 rounded-lg hover:bg-primary-50">
            <svg class="w-3.5 h-3.5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round">
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
            Tutup
        </button>
    </div>

    
    <div id="katalog-loading"
         class="hidden items-center justify-center py-16">
        <div class="spinner"></div>
    </div>

    
    <div id="katalog-empty"
         class="hidden flex-col items-center justify-center py-14 gap-3 w-full">
        <svg class="w-14 h-14 text-primary-200 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.3">
            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
            <rect x="9" y="3" width="6" height="4" rx="1"/>
            <path d="M9 12h6M9 16h4" stroke-linecap="round"/>
        </svg>
        <p class="font-semibold text-primary-800 text-sm">Buku tidak ditemukan</p>
        <p class="text-xs text-neutral-400">Coba kata kunci atau filter yang berbeda</p>
    </div>

    
    <div id="katalog-grid"
         class="flex gap-4 overflow-x-auto pb-3 -mx-4 px-4 snap-x snap-mandatory scrollbar-hide">
    </div>

</section><?php /**PATH D:\Perkuliahan Duniawi\MAGANG GES\PerpusKotaYogyakarta\resources\views/components/home/katalog-pencarian.blade.php ENDPATH**/ ?>