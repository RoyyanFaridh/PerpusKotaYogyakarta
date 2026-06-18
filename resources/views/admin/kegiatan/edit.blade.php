<div id="modalEditKegiatan" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="tutupModalEditKegiatan()"></div>

    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden max-h-[90vh] flex flex-col">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-warning-400"></div>

        <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-neutral-100 shrink-0">
            <div>
                <h2 class="text-sm font-semibold text-neutral-800">Edit Kegiatan</h2>
                <p class="text-xs text-neutral-400 mt-0.5">Perbarui data rencana kegiatan</p>
            </div>
            <button onclick="tutupModalEditKegiatan()"
                    class="p-1.5 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form id="formEditKegiatan" method="POST" action="" class="overflow-y-auto custom-scroll">
            @csrf
            @method('PUT')

            <div class="px-6 py-5 space-y-4">

                {{-- Nama Kegiatan --}}
                <div>
                    <label class="block text-xs font-medium text-neutral-600 mb-1">
                        Nama Kegiatan <span class="text-danger-500">*</span>
                    </label>
                    <input type="text" id="edit_nama_kegiatan" name="nama_kegiatan"
                           class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                </div>

                {{-- Tanggal Mulai & Selesai --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">
                            Tanggal Mulai <span class="text-danger-500">*</span>
                        </label>
                        <input type="date" id="edit_tanggal_mulai" name="tanggal_mulai"
                               class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">
                            Tanggal Selesai
                            <span class="text-[0.65rem] font-normal text-neutral-400 ml-1">opsional</span>
                        </label>
                        <input type="date" id="edit_tanggal_selesai" name="tanggal_selesai"
                               class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                    </div>
                </div>

                {{-- Jam Mulai & Selesai --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">Jam Mulai</label>
                        <input type="time" id="edit_jam_pelaksanaan" name="jam_pelaksanaan"
                               class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-neutral-600 mb-1">Jam Selesai</label>
                        <input type="time" id="edit_jam_selesai" name="jam_selesai"
                               class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition"/>
                    </div>
                </div>
                
                {{-- Lokasi Kegiatan --}}
                <div>
                    <label class="block text-xs font-medium text-neutral-600 mb-1">
                        Lokasi Kegiatan
                        <span class="text-[0.65rem] font-normal text-neutral-400 ml-1">opsional</span>
                    </label>
                    <select name="lokasi_id" id="edit_lokasi_id"
                            class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition bg-white">
                        <option value="">— Pilih lokasi —</option>
                        @foreach (\App\Models\Lokasi::orderBy('nama_lokasi')->get() as $lokasi)
                            <option value="{{ $lokasi->id }}">
                                {{ $lokasi->nama_lokasi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Paket --}}
                <div>
                    <label class="block text-xs font-medium text-neutral-600 mb-1">
                        Paket & Lokasi
                        <span class="text-[0.65rem] font-normal text-neutral-400 ml-1">opsional</span>
                    </label>
                    <div id="edit_paket_list"
                         class="rounded-lg border border-neutral-200 divide-y divide-neutral-100 max-h-36 overflow-y-auto custom-scroll">
                        @foreach (\App\Models\Paket::with('lokasi')->orderBy('nama')->get() as $paket)
                            <label class="flex items-center gap-2.5 px-3 py-2 hover:bg-primary-50 cursor-pointer transition-colors">
                                <input type="checkbox" name="paket_ids[]"
                                       value="{{ $paket->id }}"
                                       data-paket-id="{{ $paket->id }}"
                                       class="edit-paket-checkbox w-3.5 h-3.5 rounded border-neutral-300 text-primary-600 focus:ring-primary-300"/>
                                <span class="text-xs text-neutral-700">{{ $paket->nama }}</span>
                                @if ($paket->lokasi)
                                    <span class="text-[0.65rem] text-neutral-400 ml-auto shrink-0">
                                        {{ $paket->lokasi->nama_lokasi }}
                                    </span>
                                @endif
                                @if (! $paket->is_aktif)
                                    <span class="text-[0.65rem] text-neutral-300 ml-1">nonaktif</span>
                                @endif
                            </label>
                        @endforeach
                    </div>
                    <p class="text-[0.68rem] text-neutral-400 mt-1">
                        Paket yang dipilih akan dipindahkan sementara ke lokasi kegiatan.
                    </p>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-xs font-medium text-neutral-600 mb-1">Deskripsi</label>
                    <textarea id="edit_deskripsi" name="deskripsi" rows="3"
                              class="w-full px-3 py-2 text-xs rounded-lg border border-neutral-200 focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-primary-400 transition resize-none"></textarea>
                </div>

            </div>

            <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-neutral-100 bg-neutral-50 shrink-0">
                <button type="button" onclick="tutupModalEditKegiatan()"
                        class="text-xs font-medium px-4 py-2 rounded-lg border border-neutral-200 text-neutral-500 hover:bg-white transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="text-xs font-medium px-4 py-2 rounded-lg bg-warning-500 text-white hover:bg-warning-600 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function bukaModalEditKegiatan(id) {
        fetch("{{ url('admin/kegiatan') }}/" + id + '/edit', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            document.getElementById('edit_nama_kegiatan').value   = data.nama_kegiatan   ?? '';
            document.getElementById('edit_tanggal_mulai').value   = data.tanggal_mulai   ?? '';
            document.getElementById('edit_tanggal_selesai').value = data.tanggal_selesai ?? '';
            document.getElementById('edit_jam_pelaksanaan').value = data.jam_pelaksanaan ?? '';
            document.getElementById('edit_jam_selesai').value     = data.jam_selesai     ?? '';
            document.getElementById('edit_deskripsi').value       = data.deskripsi       ?? '';
            document.getElementById('edit_lokasi_id').value       = data.lokasi_id       ?? ''; 

            const paketIds = data.paket_ids ?? [];
            document.querySelectorAll('.edit-paket-checkbox').forEach(cb => {
                cb.checked = paketIds.includes(parseInt(cb.dataset.paketId));
            });

            document.getElementById('formEditKegiatan').action =
                "{{ url('admin/kegiatan') }}/" + id;

            const modal = document.getElementById('modalEditKegiatan');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        });
    }

    function tutupModalEditKegiatan() {
        const modal = document.getElementById('modalEditKegiatan');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') tutupModalEditKegiatan();
    });
</script>