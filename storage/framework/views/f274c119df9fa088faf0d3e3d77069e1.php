<div id="modal-buku"
     class="fixed inset-0 z-999 flex items-center justify-center p-4 sm:p-6"
     style="display: none !important;">

    
    <div id="modal-backdrop"
         class="absolute inset-0 bg-primary-950/30 backdrop-blur-sm transition-opacity duration-300 opacity-0"
         onclick="tutupDetailBuku()">
    </div>

    
    <div id="modal-panel"
         class="relative z-10 bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto transition-all duration-300 opacity-0 scale-95 scrollbar-hide">

        
        <button onclick="tutupDetailBuku()"
                class="absolute top-4 right-4 z-20 w-8 h-8 flex items-center justify-center rounded-full bg-neutral-100 hover:bg-neutral-200 transition-colors">
            <svg class="w-4 h-4 stroke-current fill-none text-neutral-500" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round">
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
        </button>

        
        <div id="modal-loading" class="flex flex-col items-center justify-center py-20 gap-4">
            <div class="w-8 h-8 border-2 border-primary-200 border-t-primary-500 rounded-full animate-spin"></div>
            <p class="text-sm text-neutral-400">Memuat detail buku…</p>
        </div>

        
        <div id="modal-konten" class="hidden">

            
            <div class="flex gap-5 p-6 pb-4">
                <div id="modal-cover-wrap"
                     class="shrink-0 w-28 sm:w-36 rounded-xl overflow-hidden bg-primary-50 flex items-center justify-center"
                     style="min-height: 160px;">
                    <img id="modal-cover" src="" alt="" class="w-full h-auto object-contain hidden">
                    <svg id="modal-cover-placeholder"
                         class="w-10 h-10 text-primary-200 stroke-current fill-none"
                         viewBox="0 0 24 24" stroke-width="1.3">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <path d="M3 9h18M9 21V9"/>
                    </svg>
                </div>

                <div class="flex-1 min-w-0 pt-1">
                    <span id="modal-kategori"
                          class="inline-block text-[0.55rem] font-semibold tracking-wide uppercase px-2 py-0.5 rounded-full bg-primary-50 text-primary-500 mb-2">
                    </span>
                    <h2 id="modal-judul"
                        class="font-extrabold text-primary-900 leading-snug mb-1"
                        style="font-size: clamp(1rem, 3vw, 1.3rem);">
                    </h2>
                    <p id="modal-pengarang" class="text-sm font-medium text-neutral-500 mb-3"></p>

                    
                    <div class="flex flex-wrap gap-x-4 gap-y-1.5">
                        <div id="modal-penerbit-wrap" class="hidden items-center gap-1.5 text-xs text-neutral-400">
                            <svg class="w-3.5 h-3.5 shrink-0 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round">
                                <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>
                            </svg>
                            <span id="modal-penerbit"></span>
                        </div>
                        <div id="modal-tahun-wrap" class="hidden items-center gap-1.5 text-xs text-neutral-400">
                            <svg class="w-3.5 h-3.5 shrink-0 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round">
                                <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                            </svg>
                            <span id="modal-tahun"></span>
                        </div>
                        <div id="modal-tempat-wrap" class="hidden items-center gap-1.5 text-xs text-neutral-400">
                            <svg class="w-3.5 h-3.5 shrink-0 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                <circle cx="12" cy="9" r="2.5"/>
                            </svg>
                            <span id="modal-tempat"></span>
                        </div>
                        <div id="modal-isbn-wrap" class="hidden items-center gap-1.5 text-xs text-neutral-400">
                            <svg class="w-3.5 h-3.5 shrink-0 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round">
                                <path d="M4 7V4h16v3M9 20h6M12 4v16"/>
                            </svg>
                            <span id="modal-isbn"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 pb-6 flex flex-col gap-5">

                
                <div>
                    <p class="text-[0.65rem] font-semibold tracking-[0.15em] uppercase text-primary-400 mb-2">Ketersediaan</p>
                    <div id="modal-stok-list" class="flex flex-col gap-2"></div>
                </div>

                
                <div id="modal-deskripsi-wrap" class="hidden">
                    <p class="text-[0.65rem] font-semibold tracking-[0.15em] uppercase text-primary-400 mb-2">Deskripsi</p>
                    <p id="modal-deskripsi" class="text-sm text-neutral-500 leading-relaxed"></p>
                </div>

                
                <div id="modal-resume-wrap" class="hidden">
                    <p class="text-[0.65rem] font-semibold tracking-[0.15em] uppercase text-primary-400 mb-2">Resume</p>
                    <p id="modal-resume" class="text-sm text-neutral-500 leading-relaxed"></p>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
(function () {
    const modal    = document.getElementById('modal-buku');
    const backdrop = document.getElementById('modal-backdrop');
    const panel    = document.getElementById('modal-panel');
    const loading  = document.getElementById('modal-loading');
    const konten   = document.getElementById('modal-konten');

    function setEl(id, value) {
        const el = document.getElementById(id);
        if (el) el.textContent = value ?? '';
    }

    function showWrap(id, value) {
        const wrap = document.getElementById(id + '-wrap');
        if (!wrap) return;
        if (value) {
            wrap.classList.remove('hidden');
            wrap.classList.add('flex');
            setEl(id, value);
        } else {
            wrap.classList.add('hidden');
            wrap.classList.remove('flex');
        }
    }

    window.bukaDetailBuku = function (id) {
        // Reset
        konten.classList.add('hidden');
        loading.classList.remove('hidden');
        loading.innerHTML = `
            <div class="w-8 h-8 border-2 border-primary-200 border-t-primary-500 rounded-full animate-spin"></div>
            <p class="text-sm text-neutral-400">Memuat detail buku…</p>
        `;

        // Tampilkan modal
        modal.style.display = 'flex';
        requestAnimationFrame(() => requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        }));

        document.body.style.overflow = 'hidden';

        fetch(`/detail-buku/${id}`)
            .then(r => r.json())
            .then(data => isiModal(data))
            .catch(() => {
                loading.innerHTML = '<p class="text-sm text-neutral-400 py-20 text-center">Gagal memuat data.</p>';
            });
    };

    window.tutupDetailBuku = function () {
        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }, 250);
    };

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && modal.style.display !== 'none') {
            tutupDetailBuku();
        }
    });

    function isiModal(b) {
        const coverImg         = document.getElementById('modal-cover');
        const coverPlaceholder = document.getElementById('modal-cover-placeholder');

        if (b.cover_url) {
            coverImg.src = b.cover_url;
            coverImg.alt = b.judul;
            coverImg.classList.remove('hidden');
            coverPlaceholder.classList.add('hidden');
        } else {
            coverImg.classList.add('hidden');
            coverPlaceholder.classList.remove('hidden');
        }

        setEl('modal-kategori',  b.kategori ?? 'Umum');
        setEl('modal-judul',     b.judul);
        setEl('modal-pengarang', b.pengarang);
        showWrap('modal-penerbit', b.penerbit);
        showWrap('modal-tahun',    b.tahun_terbit);
        showWrap('modal-tempat',   b.tempat_terbit);
        showWrap('modal-isbn',     b.isbn);

        const stokList = document.getElementById('modal-stok-list');
        stokList.innerHTML = '';
        if (b.eksemplars && b.eksemplars.length > 0) {
            b.eksemplars.forEach(eks => {
                const ada  = eks.stok > 0;
                const nama = eks.lokasi ?? eks.paket ?? '-';
                const row  = document.createElement('div');
                row.className = 'flex items-center justify-between px-3 py-2 rounded-lg bg-neutral-50';
                row.innerHTML = `
                    <div class="flex items-center gap-2 text-xs text-neutral-600">
                        <svg class="w-3 h-3 shrink-0 stroke-current fill-none text-neutral-400" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                            <circle cx="12" cy="9" r="2.5"/>
                        </svg>
                        ${escHtml(nama)}
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full ${ada ? 'bg-emerald-400' : 'bg-red-400'}"></span>
                        <span class="text-xs font-medium ${ada ? 'text-emerald-600' : 'text-red-500'}">
                            ${ada ? eks.stok + ' tersedia' : 'Habis'}
                        </span>
                    </div>
                `;
                stokList.appendChild(row);
            });
        } else {
            stokList.innerHTML = '<p class="text-xs text-neutral-400">Data stok tidak tersedia.</p>';
        }

        const deskWrap = document.getElementById('modal-deskripsi-wrap');
        const resuWrap = document.getElementById('modal-resume-wrap');

        if (b.deskripsi) {
            deskWrap.classList.remove('hidden');
            setEl('modal-deskripsi', b.deskripsi);
        } else {
            deskWrap.classList.add('hidden');
        }

        if (b.resume) {
            resuWrap.classList.remove('hidden');
            setEl('modal-resume', b.resume);
        } else {
            resuWrap.classList.add('hidden');
        }

        loading.classList.add('hidden');
        konten.classList.remove('hidden');
    }

    function escHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }
})();
</script><?php /**PATH D:\Perkuliahan Duniawi\MAGANG GES\PerpusKotaYogyakarta\resources\views/components/home/modal-detail-buku.blade.php ENDPATH**/ ?>