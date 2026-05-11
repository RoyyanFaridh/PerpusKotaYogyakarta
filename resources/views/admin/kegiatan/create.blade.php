<div id="modalTambahKegiatan" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="tutupModalKegiatan()"></div>

    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden max-h-[90vh] flex flex-col">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-neutral-100 shrink-0">
            <div>
                <h2 class="text-sm font-semibold text-neutral-800">Tambah Kegiatan</h2>
                <p class="text-xs text-neutral-400 mt-0.5">Isi data rencana kegiatan perpustakaan</p>
            </div>
            <button onclick="tutupModalKegiatan()" class="p-1.5 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.kegiatan.store') }}" class="overflow-y-auto">
            @csrf
            <div class="px-6 py-5 space-y-4">

                {{-- Nama Kegiatan --}}
                <div>
                    <label class="block text-xs font-medium text-neutral-600 mb-1">
                        Nama Kegiatan <span class="text-danger-500">*</span>
                    </label>
                    <input type="text" name="nama_kegiatan" required
                        value="{{ old('nama_kegiatan') }}"
                        placeholder="Contoh: Pameran Buku Nasional"
                        class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition
                            @error('nama_kegiatan') border-danger-400 focus:ring-danger-200 @enderror"/>
                    @error('nama_kegiatan')
                        <p class="text-[0.68rem] text-danger-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Mulai, Jam Pelaksanaan, Jam Selesai --}}
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">
                            Tanggal Mulai <span class="text-danger-500">*</span>
                        </label>
                        <input type="date" name="tanggal_mulai" required
                            value="{{ old('tanggal_mulai') }}"
                            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition
                                @error('tanggal_mulai') border-danger-400 focus:ring-danger-200 @enderror"/>
                        @error('tanggal_mulai')
                            <p class="text-[0.68rem] text-danger-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">Jam Mulai</label>
                        <input type="time" name="jam_pelaksanaan"
                            value="{{ old('jam_pelaksanaan') }}"
                            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition
                                @error('jam_pelaksanaan') border-danger-400 focus:ring-danger-200 @enderror"/>
                        @error('jam_pelaksanaan')
                            <p class="text-[0.68rem] text-danger-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">Jam Selesai</label>
                        <input type="time" name="jam_selesai"
                            value="{{ old('jam_selesai') }}"
                            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition
                                @error('jam_selesai') border-danger-400 focus:ring-danger-200 @enderror"/>
                        @error('jam_selesai')
                            <p class="text-[0.68rem] text-danger-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-xs font-medium text-neutral-600 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        placeholder="Jelaskan kegiatan secara singkat..."
                        class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition resize-none
                            @error('deskripsi') border-danger-400 focus:ring-danger-200 @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-[0.68rem] text-danger-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-neutral-100 bg-neutral-50 shrink-0">
                <button type="button" onclick="tutupModalKegiatan()"
                    class="text-xs font-medium px-4 py-2 rounded-lg border border-neutral-200 text-neutral-500 hover:bg-white transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="text-xs font-medium px-4 py-2 rounded-lg bg-primary text-white hover:bg-primary-600 transition-colors">
                    Simpan Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function bukaModalKegiatan() {
    document.getElementById('modalTambahKegiatan').classList.remove('hidden');
    document.getElementById('modalTambahKegiatan').classList.add('flex');
}
function tutupModalKegiatan() {
    document.getElementById('modalTambahKegiatan').classList.add('hidden');
    document.getElementById('modalTambahKegiatan').classList.remove('flex');
}
</script>