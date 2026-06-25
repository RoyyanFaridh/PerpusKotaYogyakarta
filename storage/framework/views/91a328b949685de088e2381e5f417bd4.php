<?php
    $activeMenu = match(true) {
        request()->routeIs('admin.dashboard*')            => 'dashboard',
        request()->routeIs('admin.transaksi*')            => 'transaksi',
        request()->routeIs('admin.member*')               => 'member',
        request()->routeIs('admin.buku*', 'admin.paket*') => 'buku',
        request()->routeIs('admin.lokasi*')               => 'lokasi',
        request()->routeIs('admin.kegiatan*')             => 'kegiatan',
        request()->routeIs('admin.pengaturan*')           => 'pengaturan',
        default                                           => '',
    };

    $navItems = [
        ['key' => 'dashboard',   'label' => 'Dashboard',         'route' => route('admin.dashboard'),           'icon' => 'dashboard',  'group' => 'utama'],
        ['key' => 'transaksi',   'label' => 'Tukar Buku',        'route' => route('admin.transaksi.index'),     'icon' => 'book-up',    'group' => 'utama'],
        ['key' => 'member',      'label' => 'Member',            'route' => route('admin.member.index'),        'icon' => 'users',      'group' => 'data'],
        ['key' => 'buku',        'label' => 'Buku',              'route' => route('admin.buku.index'),          'icon' => 'book-open',  'group' => 'data'],
        ['key' => 'lokasi',      'label' => 'Lokasi',            'route' => route('admin.lokasi.index'),        'icon' => 'location',   'group' => 'data'],
        ['key' => 'kegiatan',    'label' => 'Rencana Kegiatan',  'route' => route('admin.kegiatan.index'),      'icon' => 'calendar',   'group' => 'data'],
        ['key' => 'pengaturan',  'label' => 'Pengaturan',        'route' => auth()->user()->isSuperAdmin() ? route('admin.pengaturan.index') : route('admin.pengaturan.profil.page'), 'icon' => 'settings', 'group' => 'akun'],
    ];
?>

<aside
    x-data="{
        open: localStorage.getItem('sidebarOpen') !== 'false',
        activeMenu: '<?php echo e($activeMenu); ?>',
        loaded: false,
        toggle() {
            this.open = !this.open;
            localStorage.setItem('sidebarOpen', this.open);
            document.documentElement.style.setProperty('--sidebar-w', this.open ? '16rem' : '4.5rem');
        }
    }"
    x-init="$nextTick(() => loaded = true)"
    :style="loaded ? 'transition: width 300ms cubic-bezier(0.4,0,0.2,1)' : ''"
    style="width: var(--sidebar-w, 16rem)"
    class="relative flex flex-col h-screen bg-primary shrink-0 shadow-lg"
>
    
    <button
        @click="toggle()"
        aria-label="Toggle sidebar"
        class="absolute -right-3 top-6 z-50 flex items-center justify-center w-6 h-6 rounded-full bg-white border border-primary-200 shadow-md text-primary hover:bg-primary-50 transition-colors"
    >
        <span x-show="open"
              x-transition:enter="transition-opacity duration-150"
              x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100"
              x-transition:leave="transition-opacity duration-100"
              x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M15 18l-6-6 6-6"/>
            </svg>
        </span>
        <span x-show="!open"
              x-transition:enter="transition-opacity duration-150"
              x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100"
              x-transition:leave="transition-opacity duration-100"
              x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M9 18l6-6-6-6"/>
            </svg>
        </span>
    </button>

    
    <div class="flex items-center gap-3 px-4 py-5 border-b border-white/10 overflow-hidden">
        <div class="shrink-0 flex items-center justify-center w-9 h-9 rounded-xl bg-white/15 text-white">
            <?php if (isset($component)) { $__componentOriginal285eddc9278dae58281aa961bf08a625 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal285eddc9278dae58281aa961bf08a625 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.book','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.book'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal285eddc9278dae58281aa961bf08a625)): ?>
<?php $attributes = $__attributesOriginal285eddc9278dae58281aa961bf08a625; ?>
<?php unset($__attributesOriginal285eddc9278dae58281aa961bf08a625); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal285eddc9278dae58281aa961bf08a625)): ?>
<?php $component = $__componentOriginal285eddc9278dae58281aa961bf08a625; ?>
<?php unset($__componentOriginal285eddc9278dae58281aa961bf08a625); ?>
<?php endif; ?>
        </div>
        <div x-show="open"
             x-transition:enter="transition-opacity duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="overflow-hidden">
            <p class="text-white font-semibold text-sm leading-tight whitespace-nowrap">Perpustakaan</p>
            <p class="text-primary-300 text-xs whitespace-nowrap">Admin Panel</p>
        </div>
    </div>

    
    <nav class="flex-1 overflow-y-auto overflow-x-visible py-4 px-2 space-y-0.5">

        <div x-show="open" class="px-3 pt-1 pb-2">
            <span class="text-xs font-semibold uppercase tracking-wider text-primary-400">Menu Utama</span>
        </div>

        <?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php if($item['key'] === 'member'): ?>
                <div x-show="open" class="px-3 pt-4 pb-2">
                    <span class="text-xs font-semibold uppercase tracking-wider text-primary-400">Kelola Data</span>
                </div>
                <div x-show="!open" class="my-2 mx-3 border-t border-white/10"></div>
            <?php endif; ?>

            <?php if($item['key'] === 'pengaturan'): ?>
                <div x-show="open" class="px-3 pt-4 pb-2">
                    <span class="text-xs font-semibold uppercase tracking-wider text-primary-400">Akun</span>
                </div>
                <div x-show="!open" class="my-2 mx-3 border-t border-white/10"></div>
            <?php endif; ?>

            <div class="relative group/nav">
                <a href="<?php echo e($item['route']); ?>"
                    :class="[
                        activeMenu === '<?php echo e($item['key']); ?>' ? 'bg-white/15 text-white' : 'text-primary-300 hover:bg-white/10 hover:text-white',
                        open ? 'px-3 gap-3' : 'px-0 gap-0 justify-center'
                    ]"
                    class="flex items-center rounded-xl py-2.5 transition-colors duration-150 relative w-full"
                >
                    <span x-show="activeMenu === '<?php echo e($item['key']); ?>'"
                          class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-5 rounded-r-full bg-white shrink-0"></span>

                    <span class="shrink-0 flex items-center justify-center w-5 h-5">
                        <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => 'icons.' . $item['icon']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
                    </span>

                    <span x-show="open" class="text-sm font-medium whitespace-nowrap"
                          x-transition:enter="transition-opacity duration-150"
                          x-transition:enter-start="opacity-0"
                          x-transition:enter-end="opacity-100"><?php echo e($item['label']); ?></span>
                </a>

                <div x-show="!open"
                     class="pointer-events-none absolute left-[calc(100%+0.75rem)] top-1/2 -translate-y-1/2 z-50
                            opacity-0 group-hover/nav:opacity-100 transition-opacity duration-150
                            flex items-center gap-1">
                    <div class="w-0 h-0 border-y-4 border-y-transparent border-r-4 border-r-primary-600"></div>
                    <div class="bg-primary-600 text-white text-xs font-medium px-2.5 py-1.5 rounded-md shadow-lg whitespace-nowrap">
                        <?php echo e($item['label']); ?>

                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </nav>

    
    <div class="border-t border-white/10 p-3">

        
        <div x-show="open"
             x-transition:enter="transition-opacity duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="flex items-center gap-3 rounded-xl px-2 py-2">
            <div class="shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-white/20 text-white text-sm font-bold uppercase select-none">
                <?php echo e(substr(auth()->user()->name ?? 'A', 0, 1)); ?>

            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white text-xs font-semibold truncate"><?php echo e(auth()->user()->name ?? 'Admin'); ?></p>
                <p class="text-primary-300 text-xs truncate"><?php echo e(auth()->user()->email ?? ''); ?></p>
            </div>
            <button type="button"
                    @click="$dispatch('logout-confirm')"
                    aria-label="Logout"
                    class="shrink-0 p-1.5 rounded-lg text-primary-300 hover:text-white hover:bg-white/10 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
            </button>
        </div>

        
        <div x-show="!open"
             x-data="{ dropdownOpen: false }"
             class="relative flex justify-center">

            <button @click="dropdownOpen = !dropdownOpen"
                    @click.outside="dropdownOpen = false"
                    aria-label="Menu akun"
                    class="flex items-center justify-center w-8 h-8 rounded-full bg-white/20 text-white text-sm font-bold uppercase hover:bg-white/30 transition-colors select-none">
                <?php echo e(substr(auth()->user()->name ?? 'A', 0, 1)); ?>

            </button>

            <div x-show="dropdownOpen"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 -translate-x-2"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 -translate-x-2"
                 class="absolute bottom-0 left-full ml-2 w-48 bg-white rounded-lg shadow-lg border border-neutral-200 overflow-hidden z-50">

                <div class="px-3 py-2.5 border-b border-neutral-100">
                    <p class="text-xs font-semibold text-neutral-800 truncate"><?php echo e(auth()->user()->name ?? 'Admin'); ?></p>
                    <p class="text-xs text-neutral-500 truncate"><?php echo e(auth()->user()->email ?? ''); ?></p>
                </div>

                <button type="button"
                        @click="$dispatch('logout-confirm'); dropdownOpen = false"
                        class="w-full flex items-center gap-2 px-3 py-2.5 text-xs font-medium text-danger-600 hover:bg-danger-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Logout
                </button>
            </div>
        </div>

    </div>

</aside>



<div x-data="{ showLogout: false }"
     @logout-confirm.window="showLogout = true"
     x-cloak>

    <div x-show="showLogout"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-999 flex items-center justify-center p-4">

        
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
             @click="showLogout = false"></div>

        
        <div x-show="showLogout"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 flex flex-col items-center gap-4">

            <div class="w-12 h-12 rounded-full bg-danger-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-danger-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
            </div>

            <div class="text-center">
                <p class="text-sm font-semibold text-neutral-800">Keluar dari akun?</p>
                <p class="text-xs text-neutral-500 mt-1">Sesi kamu akan diakhiri dan kamu perlu login kembali.</p>
            </div>

            <div class="flex gap-2 w-full">
                <button type="button"
                        @click="showLogout = false"
                        class="flex-1 px-4 py-2 rounded-lg text-xs font-medium text-neutral-600 border border-neutral-200 hover:bg-neutral-50 transition-colors">
                    Batal
                </button>
                <form method="POST" action="<?php echo e(route('auth.logout')); ?>" class="flex-1">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                            class="w-full px-4 py-2 rounded-lg text-xs font-semibold text-white bg-danger-600 hover:bg-danger-700 transition-colors">
                        Ya, Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/components/admin/sidebar.blade.php ENDPATH**/ ?>