<div class="step-content-{{ $prefix }} hidden" data-step="4">
    <div class="space-y-3">
        <div class="p-3.5 rounded-xl border border-neutral-200 bg-neutral-50">
            <p class="text-[0.68rem] font-semibold text-neutral-400 uppercase tracking-wide mb-2">Member</p>
            <p class="text-xs font-semibold text-neutral-800" id="{{ $prefix }}_konfirmasiMemberNama"></p>
            <p class="text-[0.68rem] text-neutral-500 mt-0.5" id="{{ $prefix }}_konfirmasiMemberTelp"></p>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div class="p-3.5 rounded-xl border border-neutral-200 bg-neutral-50">
                <p class="text-[0.68rem] font-semibold text-neutral-400 uppercase tracking-wide mb-2">Buku Diserahkan</p>
                <p class="text-xs font-semibold text-neutral-800 leading-snug" id="{{ $prefix }}_konfirmasiBukuDiserahkan"></p>
                <p class="text-[0.68rem] text-neutral-500 mt-0.5" id="{{ $prefix }}_konfirmasiBukuDiserahkanKondisi"></p>
            </div>
            <div class="p-3.5 rounded-xl border border-neutral-200 bg-neutral-50">
                <p class="text-[0.68rem] font-semibold text-neutral-400 uppercase tracking-wide mb-2">Buku Diterima</p>
                <p class="text-xs font-semibold text-neutral-800 leading-snug" id="{{ $prefix }}_konfirmasiBukuDiterima"></p>
                <p class="text-[0.68rem] text-success-600 mt-0.5">Stok akan berkurang 1</p>
            </div>
        </div>
        <div>
            <label class="block text-xs font-medium text-neutral-600 mb-1">Catatan Petugas</label>
            <textarea id="{{ $prefix }}_catatanPetugas" rows="2" placeholder="Opsional..."
                class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition resize-none"></textarea>
        </div>
    </div>
</div>