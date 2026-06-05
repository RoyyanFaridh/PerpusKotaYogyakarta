<div id="modalAktifkanPaket"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 backdrop-blur-sm p-4">
    <div class="absolute inset-0" onclick="tutupModalAktifkanPaket()"></div>
    <div class="relative z-10 w-full max-w-md rounded-2xl bg-white overflow-hidden shadow-xl">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-success-400"></div>
        <div class="px-6 pt-6 pb-2 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-semibold text-neutral-800">Aktifkan Paket</h2>
                <p id="aktifkanPaketNama" class="text-xs text-neutral-400 mt-0.5"></p>
            </div>
            <button type="button" onclick="tutupModalAktifkanPaket()"
                    class="w-7 h-7 flex items-center justify-center rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="formAktifkanPaket" method="POST" action="" class="px-6 pb-6 pt-4 flex flex-col gap-4">
            @csrf
            <div class="flex flex-col gap-1.5">
                <label for="aktifkanLokasiId" class="text-xs font-medium text-neutral-600">
                    Lokasi Tujuan <span class="text-danger-500">*</span>
                </label>
                <select id="aktifkanLokasiId" name="lokasi_id" required
                        class="w-full px-3 py-2 text-sm text-neutral-700 bg-neutral-50 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition">
                    <option value="">Pilih lokasi</option>
                    @foreach (\App\Models\Lokasi::aktif()->get() as $lokasi)
                        <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>
                    @endforeach
                </select>
                <p class="text-[0.68rem] text-neutral-400">Paket akan dipindah ke lokasi ini saat diaktifkan.</p>
            </div>
            <div class="flex items-center gap-2 pt-1">
                <button type="button" onclick="tutupModalAktifkanPaket()"
                        class="flex-1 px-4 py-2 text-sm font-medium rounded-lg text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2 text-sm font-semibold rounded-lg bg-success-500 text-white hover:bg-success-600 transition-colors">
                    Aktifkan
                </button>
            </div>
        </form>
    </div>
</div>