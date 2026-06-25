<section class="relative z-50 flex flex-col items-center justify-center pt-50 pb-16 px-4 sm:px-6 text-center">

    <div class="hero-glow absolute w-[clamp(300px,70vw,860px)] h-[clamp(300px,70vw,860px)] rounded-full pointer-events-none"
         style="background: radial-gradient(circle, rgba(4,68,141,0.10) 0%, transparent 68%);">
    </div>

    <img src="<?php echo e(asset('images/judul-hero.webp')); ?>"
        alt="Tukar Bacaan, Luaskan Wawasan"
        class="animate-fade-up-2 w-auto max-w-full object-contain mb-4 sm:mb-5"
        style="max-width: clamp(320px, 90vw, 1000px);">

    <p class="animate-fade-up-3 max-w-xs sm:max-w-xl text-sm sm:text-base leading-relaxed text-neutral-500 mb-8 sm:mb-12">
        Temukan buku yang kamu inginkan, ajukan penukaran, dan nikmati
        koleksi baru tanpa biaya.
    </p>

    <div class="animate-fade-up-4 w-full max-w-3xl relative z-100">
        <div class="search-box relative flex items-center bg-white border border-primary-100 rounded-xl shadow-sm transition-all duration-200 overflow-hidden">
            <span class="shrink-0 px-3 sm:px-5 grid place-items-center text-neutral-400">
                <?php if (isset($component)) { $__componentOriginala0c73ad9511ae1934ff7056d4fc38e8a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala0c73ad9511ae1934ff7056d4fc38e8a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.search','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala0c73ad9511ae1934ff7056d4fc38e8a)): ?>
<?php $attributes = $__attributesOriginala0c73ad9511ae1934ff7056d4fc38e8a; ?>
<?php unset($__attributesOriginala0c73ad9511ae1934ff7056d4fc38e8a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala0c73ad9511ae1934ff7056d4fc38e8a)): ?>
<?php $component = $__componentOriginala0c73ad9511ae1934ff7056d4fc38e8a; ?>
<?php unset($__componentOriginala0c73ad9511ae1934ff7056d4fc38e8a); ?>
<?php endif; ?>
            </span>
            <input
                id="search-input"
                type="text"
                class="flex-1 border-none outline-none text-sm sm:text-base text-primary-900 bg-transparent py-3.5 sm:py-4 placeholder-neutral-400"
                placeholder="Cari judul, penulis…"
                autocomplete="off"
            >
            <button id="search-btn"
                    class="m-1.5 shrink-0 px-4 sm:px-6 py-2.5 bg-primary-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors shadow-sm hover:bg-primary-700">
                <span class="max-sm:hidden">Cari Buku</span>
                <span class="hidden max-sm:inline" aria-label="Cari">
                    <?php if (isset($component)) { $__componentOriginala0c73ad9511ae1934ff7056d4fc38e8a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala0c73ad9511ae1934ff7056d4fc38e8a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.search','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala0c73ad9511ae1934ff7056d4fc38e8a)): ?>
<?php $attributes = $__attributesOriginala0c73ad9511ae1934ff7056d4fc38e8a; ?>
<?php unset($__attributesOriginala0c73ad9511ae1934ff7056d4fc38e8a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala0c73ad9511ae1934ff7056d4fc38e8a)): ?>
<?php $component = $__componentOriginala0c73ad9511ae1934ff7056d4fc38e8a; ?>
<?php unset($__componentOriginala0c73ad9511ae1934ff7056d4fc38e8a); ?>
<?php endif; ?>
                </span>
            </button>
        </div>

        <div class="animate-fade-up-5 relative z-9999 flex flex-wrap items-center gap-2 justify-center mt-3 sm:mt-4">

            <div class="relative" id="dropdown-kategori-wrapper">
                <button id="dropdown-kategori-btn"
                        class="flex items-center gap-1.5 px-3 sm:px-4 py-1.5 border border-primary-100 rounded-full text-xs font-medium text-neutral-500 bg-white/70 transition-colors hover:bg-primary-600 hover:text-white hover:border-primary-600"
                        onclick="toggleDropdown('kategori')">
                    <?php if (isset($component)) { $__componentOriginalfa68024704d8dee6dbc8b7204baf31f8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa68024704d8dee6dbc8b7204baf31f8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.filter','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.filter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa68024704d8dee6dbc8b7204baf31f8)): ?>
<?php $attributes = $__attributesOriginalfa68024704d8dee6dbc8b7204baf31f8; ?>
<?php unset($__attributesOriginalfa68024704d8dee6dbc8b7204baf31f8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa68024704d8dee6dbc8b7204baf31f8)): ?>
<?php $component = $__componentOriginalfa68024704d8dee6dbc8b7204baf31f8; ?>
<?php unset($__componentOriginalfa68024704d8dee6dbc8b7204baf31f8); ?>
<?php endif; ?>
                    <span id="label-kategori">Kategori</span>
                    <?php if (isset($component)) { $__componentOriginalfb5ab559e4014313073efeb5cdff727a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfb5ab559e4014313073efeb5cdff727a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.chevron-down','data' => ['class' => 'w-3 h-3 stroke-current fill-none shrink-0 transition-transform pointer-events-none','id' => 'chevron-kategori']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.chevron-down'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3 stroke-current fill-none shrink-0 transition-transform pointer-events-none','id' => 'chevron-kategori']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfb5ab559e4014313073efeb5cdff727a)): ?>
<?php $attributes = $__attributesOriginalfb5ab559e4014313073efeb5cdff727a; ?>
<?php unset($__attributesOriginalfb5ab559e4014313073efeb5cdff727a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfb5ab559e4014313073efeb5cdff727a)): ?>
<?php $component = $__componentOriginalfb5ab559e4014313073efeb5cdff727a; ?>
<?php unset($__componentOriginalfb5ab559e4014313073efeb5cdff727a); ?>
<?php endif; ?>
                </button>
                <div id="dropdown-kategori"
                     class="hidden absolute left-0 top-[calc(100%+6px)] z-9999 bg-white border border-neutral-200 rounded-xl shadow-lg py-1.5 w-56 max-h-64 overflow-y-auto text-left custom-scroll">
                    <?php $__currentLoopData = ['Kategori', 'Filsafat & Psikologi', 'Agama', 'Ilmu Sosial', 'Bahasa', 'Sains & Matematika', 'Teknologi', 'Seni & Rekreasi', 'Literatur & Sastra', 'Geografi & Sejarah']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button
                            data-value="<?php echo e($kat === 'Kategori' ? '' : $kat); ?>"
                            class="dropdown-item-kategori w-full text-left px-3.5 py-2 text-xs text-neutral-600 hover:bg-primary-50 hover:text-primary-700 transition-colors">
                            <?php echo e($kat); ?>

                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="relative" id="dropdown-lokasi-wrapper">
                <button id="dropdown-lokasi-btn"
                        class="flex items-center gap-1.5 px-3 sm:px-4 py-1.5 border border-primary-100 rounded-full text-xs font-medium text-neutral-500 bg-white/70 transition-colors hover:bg-primary-600 hover:text-white hover:border-primary-600"
                        onclick="toggleDropdown('lokasi')">
                    <?php if (isset($component)) { $__componentOriginal529f05da3443eaef4aa8815e981f7826 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal529f05da3443eaef4aa8815e981f7826 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.location','data' => ['width' => '14','height' => '14']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.location'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['width' => '14','height' => '14']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal529f05da3443eaef4aa8815e981f7826)): ?>
<?php $attributes = $__attributesOriginal529f05da3443eaef4aa8815e981f7826; ?>
<?php unset($__attributesOriginal529f05da3443eaef4aa8815e981f7826); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal529f05da3443eaef4aa8815e981f7826)): ?>
<?php $component = $__componentOriginal529f05da3443eaef4aa8815e981f7826; ?>
<?php unset($__componentOriginal529f05da3443eaef4aa8815e981f7826); ?>
<?php endif; ?>
                    <span id="label-lokasi">Lokasi</span>
                    <?php if (isset($component)) { $__componentOriginalfb5ab559e4014313073efeb5cdff727a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfb5ab559e4014313073efeb5cdff727a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.chevron-down','data' => ['class' => 'w-3 h-3 stroke-current fill-none shrink-0 transition-transform pointer-events-none','id' => 'chevron-lokasi']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.chevron-down'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3 stroke-current fill-none shrink-0 transition-transform pointer-events-none','id' => 'chevron-lokasi']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfb5ab559e4014313073efeb5cdff727a)): ?>
<?php $attributes = $__attributesOriginalfb5ab559e4014313073efeb5cdff727a; ?>
<?php unset($__attributesOriginalfb5ab559e4014313073efeb5cdff727a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfb5ab559e4014313073efeb5cdff727a)): ?>
<?php $component = $__componentOriginalfb5ab559e4014313073efeb5cdff727a; ?>
<?php unset($__componentOriginalfb5ab559e4014313073efeb5cdff727a); ?>
<?php endif; ?>
                </button>
                <div id="dropdown-lokasi"
                     class="hidden absolute left-0 top-[calc(100%+6px)] z-9999 bg-white border border-neutral-200 rounded-xl shadow-lg py-1.5 w-64 sm:min-w-70 max-h-64 overflow-y-auto text-left custom-scroll">
                    <button
                        data-value=""
                        class="dropdown-item-lokasi w-full text-left px-3.5 py-2 text-xs text-neutral-600 hover:bg-primary-50 hover:text-primary-700 transition-colors">
                        Semua Lokasi
                    </button>
                    <?php $__currentLoopData = $lokasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button
                            data-value="<?php echo e($lokasi->id); ?>"
                            data-label="<?php echo e($lokasi->nama_lokasi); ?>"
                            class="dropdown-item-lokasi w-full text-left px-3.5 py-2 text-xs text-neutral-600 hover:bg-primary-50 hover:text-primary-700 transition-colors">
                            <?php echo e($lokasi->nama_lokasi); ?>

                            <span class="block text-[0.68rem] text-neutral-400 mt-0.5"><?php echo e($lokasi->alamat); ?></span>
                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <button id="reset-filter"
                    class="hidden items-center gap-1 px-3 sm:px-4 py-1.5 border border-danger-200 rounded-full text-xs font-medium text-danger-500 bg-white/70 transition-colors hover:bg-danger-50">
                <svg class="w-3 h-3 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2.5" aria-hidden="true">
                    <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round"/>
                </svg>
                Reset
            </button>
        </div>
    </div>

    <div id="katalog-section" class="relative z-1 w-full max-w-6xl mt-10 sm:mt-14">

        <div class="flex items-center justify-between mb-4 sm:mb-6 px-1">
            <div class="text-left">
                <p id="katalog-label" class="text-xs font-semibold tracking-widest uppercase text-primary-400 mb-1">Hasil Pencarian</p>
                <h2 id="katalog-title" class="font-bold text-primary-900 text-sm sm:text-lg leading-tight"></h2>
            </div>
            <button id="katalog-close"
                    class="flex items-center gap-1 sm:gap-1.5 text-xs font-medium text-neutral-400 hover:text-primary-600 transition-colors">
                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                    <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round"/>
                </svg>
                Tutup
            </button>
        </div>

        <div id="katalog-loading" class="hidden flex-col items-center justify-center py-12 sm:py-16 gap-4">
            <div class="spinner"></div>
            <p class="text-sm text-neutral-400 font-medium">Mencari buku…</p>
        </div>

        <div id="katalog-empty" class="hidden flex-col items-center justify-center py-12 sm:py-16 gap-3">
            <svg class="w-12 h-12 sm:w-14 sm:h-14 text-primary-200 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="1.3" aria-hidden="true">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                <rect x="9" y="3" width="6" height="4" rx="1"/>
                <path d="M9 12h6M9 16h4" stroke-linecap="round"/>
            </svg>
            <p class="font-semibold text-primary-800 text-sm">Buku tidak ditemukan</p>
            <p class="text-xs sm:text-sm text-neutral-400">Coba kata kunci lain atau ubah filter</p>
        </div>

        <div id="katalog-grid" class="flex gap-4 overflow-x-auto pb-3 -mx-4 px-4 snap-x snap-mandatory scrollbar-hide"></div>
    </div>
</section><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/components/home/hero-search.blade.php ENDPATH**/ ?>