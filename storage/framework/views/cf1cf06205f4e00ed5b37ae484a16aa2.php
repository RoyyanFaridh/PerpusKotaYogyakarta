<div class="step-content-<?php echo e($prefix); ?>" data-step="<?php echo e(1 + ($offset ?? 0)); ?>">

    <div class="mb-4">
        <label class="block text-sm font-medium text-neutral-600 mb-1.5">Cari Member</label>
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text"
                   id="<?php echo e($prefix); ?>_cariMemberInput"
                   placeholder="Ketik nama atau no. telepon..."
                   class="w-full pl-9 pr-4 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
        </div>
        <p class="mt-1.5 text-xs text-neutral-400">
            Pilih member dari hasil pencarian, atau isi form di bawah untuk member baru.
        </p>
        <div id="<?php echo e($prefix); ?>_cariMemberResults"
             class="mt-1.5 border border-neutral-200 rounded-lg overflow-hidden hidden"></div>
    </div>

    <div class="relative flex items-center gap-3 my-5">
        <div class="flex-1 h-px bg-neutral-100"></div>
        <span class="text-xs text-neutral-400 font-medium shrink-0">Data Member</span>
        <div class="flex-1 h-px bg-neutral-100"></div>
    </div>

    <div class="space-y-4">
        <input type="hidden" id="<?php echo e($prefix); ?>_memberId"/>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-neutral-600 mb-1.5">
                    Nama <span class="text-danger-500">*</span>
                </label>
                <input type="text" id="<?php echo e($prefix); ?>_memberNama" placeholder="Nama lengkap"
                       class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-600 mb-1.5">
                    No. Telepon <span class="text-danger-500">*</span>
                </label>
                <input type="text" id="<?php echo e($prefix); ?>_memberNoTelp" placeholder="08xxxxxxxxxx"
                       class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-neutral-600 mb-1.5">
                Alamat
                <span class="text-xs font-normal text-neutral-400 ml-1">opsional</span>
            </label>
            <input type="text" id="<?php echo e($prefix); ?>_memberAlamat" placeholder="Alamat lengkap"
                   class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
        </div>

        <div>
            <label class="block text-sm font-medium text-neutral-600 mb-1.5">
                Email
                <span class="text-xs font-normal text-neutral-400 ml-1">opsional</span>
            </label>
            <input type="email" id="<?php echo e($prefix); ?>_memberEmail" placeholder="email@contoh.com"
                   class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
        </div>
    </div>

</div><?php /**PATH C:\xampp\htdocs\rotateyourbook\resources\views/admin/transaksi/_step-member.blade.php ENDPATH**/ ?>