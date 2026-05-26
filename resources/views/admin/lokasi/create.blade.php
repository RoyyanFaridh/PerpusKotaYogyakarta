<div id="modalTambahLokasi"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 backdrop-blur-sm px-4">

    <div class="absolute inset-0" onclick="tutupModalLokasi()"></div>

    <div class="relative z-10 w-full max-w-md rounded-2xl bg-white overflow-hidden shadow-xl">

        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-400"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 sm:px-8 pt-6 pb-5 border-b border-neutral-100 shrink-0">
            <div>
                <h2 class="text-base font-semibold text-neutral-800">Tambah Lokasi Baru</h2>
                <p class="text-sm text-neutral-400 mt-0.5">Lengkapi data lokasi perpustakaan</p>
            </div>
            <button type="button" onclick="tutupModalLokasi()"
                    aria-label="Tutup modal"
                    class="p-2 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form id="formTambahLokasi" method="POST" action="{{ route('admin.lokasi.store') }}"
              class="px-6 sm:px-8 py-6 flex flex-col gap-4">
            @csrf

            {{-- Nama Lokasi --}}
            <div class="flex flex-col gap-1.5">
                <label for="nama_lokasi" class="text-xs font-medium text-neutral-700">
                    Nama Lokasi <span class="text-danger-500">*</span>
                </label>
                <input type="text" id="nama_lokasi" name="nama_lokasi"
                       value="{{ old('nama_lokasi') }}" placeholder="Contoh: Perpustakaan Pusat"
                       class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('nama_lokasi') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                @error('nama_lokasi')
                    <p class="text-[0.68rem] text-danger-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat --}}
            <div class="flex flex-col gap-1.5">
                <label for="alamat" class="text-xs font-medium text-neutral-700">
                    Alamat <span class="text-danger-500">*</span>
                </label>
                <textarea id="alamat" name="alamat" rows="3"
                          placeholder="Masukkan alamat lengkap lokasi"
                          class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('alamat') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition resize-none">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="text-[0.68rem] text-danger-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- No. Telepon --}}
            <div class="flex flex-col gap-1.5">
                <label for="no_telp" class="text-xs font-medium text-neutral-700">Nomor Telepon</label>
                <input type="text" id="no_telp" name="no_telp"
                       value="{{ old('no_telp') }}" maxlength="15" placeholder="Contoh: 0274123456"
                       class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('no_telp') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 placeholder-neutral-300 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition"/>
                @error('no_telp')
                    <p class="text-[0.68rem] text-danger-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Penanggung Jawab --}}
            <div class="flex flex-col gap-1.5">
                <label for="lokasi_user_id" class="text-xs font-medium text-neutral-700">
                    Penanggung Jawab <span class="text-danger-500">*</span>
                </label>
                <select id="lokasi_user_id" name="user_id"
                        class="w-full text-sm px-3.5 py-2.5 rounded-lg border {{ $errors->has('user_id') ? 'border-danger-400 bg-danger-50' : 'border-neutral-200' }} text-neutral-800 focus:outline-none focus:ring-2 focus:ring-primary-300 focus:border-primary-400 transition bg-white">
                    <option value="">Pilih penanggung jawab</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->nama }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-[0.68rem] text-danger-500">{{ $message }}</p>
                @enderror
            </div>

        </form>

        {{-- Footer --}}
        <div class="flex items-center justify-between px-6 sm:px-8 py-4 border-t border-neutral-100 bg-neutral-50">
            <div></div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="tutupModalLokasi()"
                        class="text-sm font-medium px-4 py-2 rounded-lg text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 transition-colors">
                    Batal
                </button>
                <button type="button" onclick="document.getElementById('formTambahLokasi').submit()"
                        class="text-sm font-medium px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-success-700 transition-colors">
                    Simpan Lokasi
                </button>
            </div>
        </div>

    </div>
</div>

<script>
    function bukaModalLokasi() {
        const el = document.getElementById('modalTambahLokasi');
        el.classList.remove('hidden');
        el.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function tutupModalLokasi() {
        const el = document.getElementById('modalTambahLokasi');
        el.classList.add('hidden');
        el.classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') tutupModalLokasi();
    });
</script>