<div class="step-content-{{ $prefix }}" data-step="1">
    <div class="mb-4">
        <label class="block text-xs font-medium text-neutral-600 mb-1.5">Cari Member</label>
        <div class="relative">
            <input type="text" id="{{ $prefix }}_cariMemberInput" placeholder="Ketik nama atau no. telepon..."
                class="w-full pl-4 pr-10 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            <div id="{{ $prefix }}_cariMemberLoading" class="absolute right-3 top-1/2 -translate-y-1/2 hidden">
                <svg class="w-3.5 h-3.5 text-neutral-400 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>
            </div>
        </div>
        <div id="{{ $prefix }}_cariMemberResults" class="mt-1 border border-neutral-200 rounded-lg overflow-hidden hidden"></div>
    </div>
    <div class="space-y-3">
        <input type="hidden" id="{{ $prefix }}_memberId">
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-medium text-neutral-600 mb-1">Nama <span class="text-danger-500">*</span></label>
                <input type="text" id="{{ $prefix }}_memberNama" placeholder="Nama lengkap"
                    class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
            <div>
                <label class="block text-xs font-medium text-neutral-600 mb-1">No. Telepon <span class="text-danger-500">*</span></label>
                <input type="text" id="{{ $prefix }}_memberNoTelp" placeholder="08xxxxxxxxxx"
                    class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
            </div>
        </div>
        <div>
            <label class="block text-xs font-medium text-neutral-600 mb-1">Alamat</label>
            <input type="text" id="{{ $prefix }}_memberAlamat" placeholder="Alamat lengkap"
                class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
        </div>
        <div>
            <label class="block text-xs font-medium text-neutral-600 mb-1">Email</label>
            <input type="email" id="{{ $prefix }}_memberEmail" placeholder="email@contoh.com"
                class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
        </div>
    </div>
</div>