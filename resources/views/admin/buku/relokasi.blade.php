<div id="modalRelokasi"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 backdrop-blur-sm px-4">

    <div class="absolute inset-0" onclick="tutupModalRelokasi()"></div>

    <div class="relative z-10 w-full max-w-md rounded-2xl bg-white overflow-hidden shadow-xl">

        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 pt-6 pb-5 border-b border-neutral-100">
            <div>
                <h2 class="text-base font-semibold text-neutral-800">Pindah Eksemplar</h2>
                <p id="relokasi-subtitle" class="text-sm text-neutral-400 mt-0.5 truncate max-w-xs"></p>
            </div>
            <button type="button" onclick="tutupModalRelokasi()"
                    aria-label="Tutup modal"
                    class="p-2 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="px-6 py-6 flex flex-col gap-4">

            {{-- Info sumber --}}
            <div class="flex items-center gap-3 px-3.5 py-3 rounded-xl bg-neutral-50 border border-neutral-200">
                <div class="flex flex-col gap-0.5 flex-1 min-w-0">
                    <span class="text-xs text-neutral-400">Sumber</span>
                    <span id="relokasi-sumber-nama" class="text-sm font-medium text-neutral-700 truncate"></span>
                </div>
                <div class="flex flex-col gap-0.5 items-end shrink-0">
                    <span class="text-xs text-neutral-400">Stok saat ini</span>
                    <span id="relokasi-sumber-stok" class="text-sm font-semibold text-neutral-800"></span>
                </div>
            </div>

            {{-- Jumlah --}}
            <div class="flex flex-col gap-1.5">
                <label for="relokasi_jumlah" class="text-xs font-medium text-neutral-700">
                    Jumlah yang dipindah <span class="text-danger-500">*</span>
                </label>
                <input type="number" id="relokasi_jumlah" min="1" placeholder="0"
                       class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                <p id="relokasi-jumlah-hint" class="text-[0.68rem] text-neutral-400"></p>
            </div>

            {{-- Paket tujuan --}}
            <div class="flex flex-col gap-1.5">
                <label for="relokasi_paket_tujuan" class="text-xs font-medium text-neutral-700">
                    Paket tujuan <span class="text-danger-500">*</span>
                </label>
                <select id="relokasi_paket_tujuan"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border border-neutral-200 text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white">
                    <option value="">Pilih paket tujuan</option>
                    @foreach ($pakets as $paket)
                        <option value="{{ $paket->id }}">
                            {{ $paket->nama }}
                            @if ($paket->lokasi)
                                — {{ $paket->lokasi->nama_lokasi }}
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Error --}}
            <p id="relokasi-error" class="hidden text-xs text-danger-600 px-1"></p>

        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-neutral-100 bg-neutral-50">
            <button type="button" onclick="tutupModalRelokasi()"
                    class="text-sm font-medium px-4 py-2 rounded-lg text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 transition-colors">
                Batal
            </button>
            <button type="button" onclick="submitRelokasi()"
                    id="relokasi-submit-btn"
                    class="text-sm font-medium px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                Pindahkan
            </button>
        </div>

    </div>
</div>

<script>
    let _relokasiData = {};

    function bukaModalRelokasi(data) {
        _relokasiData = data;

        document.getElementById('relokasi-subtitle').textContent      = data.judul;
        document.getElementById('relokasi-sumber-nama').textContent   = data.paket_nama;
        document.getElementById('relokasi-sumber-stok').textContent   = data.stok + ' eks';
        document.getElementById('relokasi-jumlah-hint').textContent   = 'Maksimal ' + data.stok + ' eksemplar';
        document.getElementById('relokasi_jumlah').max                = data.stok;
        document.getElementById('relokasi_jumlah').value              = '';
        document.getElementById('relokasi_paket_tujuan').value        = '';
        document.getElementById('relokasi-error').classList.add('hidden');
        document.getElementById('relokasi-error').textContent         = '';

        const el = document.getElementById('modalRelokasi');
        el.classList.remove('hidden');
        el.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function tutupModalRelokasi() {
        const el = document.getElementById('modalRelokasi');
        el.classList.add('hidden');
        el.classList.remove('flex');
        document.body.style.overflow = '';
    }

    async function submitRelokasi() {
        const jumlah      = parseInt(document.getElementById('relokasi_jumlah').value);
        const paketTujuan = document.getElementById('relokasi_paket_tujuan').value;
        const errorEl     = document.getElementById('relokasi-error');
        const btn         = document.getElementById('relokasi-submit-btn');

        errorEl.classList.add('hidden');
        errorEl.textContent = '';

        if (!jumlah || jumlah < 1) {
            errorEl.textContent = 'Jumlah harus diisi minimal 1.';
            errorEl.classList.remove('hidden');
            return;
        }
        if (jumlah > _relokasiData.stok) {
            errorEl.textContent = `Jumlah melebihi stok tersedia (${_relokasiData.stok}).`;
            errorEl.classList.remove('hidden');
            return;
        }
        if (!paketTujuan) {
            errorEl.textContent = 'Paket tujuan harus dipilih.';
            errorEl.classList.remove('hidden');
            return;
        }

        btn.disabled = true;
        btn.textContent = 'Memindahkan...';

        try {
            const res = await fetch(`/admin/buku/${_relokasiData.buku_id}/relokasi`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    eksemplar_id: _relokasiData.eksemplar_id,
                    paket_tujuan: paketTujuan,
                    jumlah,
                }),
            });

            const json = await res.json();

            if (!res.ok || !json.success) {
                errorEl.textContent = json.message ?? 'Terjadi kesalahan.';
                errorEl.classList.remove('hidden');
                return;
            }

            tutupModalRelokasi();
            window.location.reload();

        } catch (e) {
            errorEl.textContent = 'Gagal terhubung ke server.';
            errorEl.classList.remove('hidden');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Pindahkan';
        }
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') tutupModalRelokasi();
    });
</script>