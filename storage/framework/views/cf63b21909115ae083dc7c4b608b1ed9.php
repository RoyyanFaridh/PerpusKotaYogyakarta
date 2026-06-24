<nav class="fixed top-0 left-0 right-0 z-200 h-16 sm:h-18 bg-white/95 backdrop-blur-md border-b border-primary-100 flex items-center px-4 sm:px-8 shadow-sm">
    <div class="w-full max-w-7xl mx-auto flex items-center justify-between gap-4">

        <a href="<?php echo e(url('/')); ?>" class="flex items-center gap-2 sm:gap-2.5 no-underline shrink-0">
                <img src="<?php echo e(asset('images/dinas_jogja.webp')); ?>"
                    class="w-8 h-8 sm:w-10 sm:h-10 object-contain">

            <div>
                <span class="font-extrabold text-lg sm:text-xl text-primary-700 tracking-wider leading-none block">SIROBY</span>
                <span class="text-[0.6rem] font-medium tracking-widest text-neutral-400 uppercase block mt-0.5">Sistem Rotate Your Book</span>
            </div>
        </a>

        <a href="<?php echo e(route('auth.login')); ?>"
           class="inline-flex items-center gap-1.5 px-4 sm:px-5 py-2 bg-primary-600 text-white text-xs sm:text-sm font-semibold rounded-lg no-underline transition-colors whitespace-nowrap shadow-sm hover:bg-primary-700">
            Login Admin
        </a>
    </div>
</nav><?php /**PATH D:\Perkuliahan Duniawi\MAGANG GES\PerpusKotaYogyakarta\resources\views/components/home/navbar.blade.php ENDPATH**/ ?>