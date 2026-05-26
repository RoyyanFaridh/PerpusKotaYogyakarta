{{-- Modal Hapus User --}}
<div id="modalHapusUser-{{ $user->id }}"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/40 backdrop-blur-sm p-4">

    <div class="absolute inset-0" onclick="tutupModalHapusUser({{ $user->id }})"></div>

    <div class="relative z-10 w-full max-w-md rounded-2xl bg-white overflow-hidden shadow-xl">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-danger-400"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 sm:px-8 pt-6 pb-5 border-b border-neutral-100">
            <div>
                <h2 class="text-base font-semibold text-neutral-800">Konfirmasi Hapus</h2>
                <p class="text-sm text-neutral-400 mt-0.5">Tindakan ini tidak dapat dibatalkan</p>
            </div>
            <button type="button" onclick="tutupModalHapusUser({{ $user->id }})"
                    aria-label="Tutup modal"
                    class="p-2 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     aria-hidden="true">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="px-6 sm:px-8 py-5 flex flex-col gap-4">

            {{-- Warning banner --}}
            <div class="flex items-start gap-3 p-3.5 rounded-lg bg-danger-50 border border-danger-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-danger-500 shrink-0 mt-0.5"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <p class="text-xs text-danger-700 leading-relaxed">
                    Akun yang dihapus tidak dapat dikembalikan. Semua permission user ini juga akan ikut terhapus.
                </p>
            </div>

            {{-- User card --}}
            <div class="flex items-center gap-3 p-3.5 rounded-lg border border-neutral-100 bg-neutral-50">
                <div class="w-9 h-9 rounded-full bg-neutral-200 text-neutral-600 flex items-center justify-center text-sm font-bold uppercase shrink-0">
                    {{ substr($user->nama, 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-neutral-800">{{ $user->nama }}</p>
                    <p class="text-xs text-neutral-400 mt-0.5">{{ $user->email ?? 'Tidak ada email' }}</p>
                    <p class="text-xs text-neutral-400">
                        {{ $user->isSuperAdmin() ? 'Superadmin' : 'Admin' }}
                        · Dibuat {{ $user->created_at?->format('d M Y') }}
                    </p>
                </div>
            </div>

        </div>

        {{-- Footer --}}
        <form method="POST" action="{{ route('admin.pengaturan.user.destroy', $user) }}">
            @csrf
            @method('DELETE')
            <div class="flex items-center justify-end gap-2 px-6 sm:px-8 py-4 border-t border-neutral-100 bg-neutral-50">
                <button type="button" onclick="tutupModalHapusUser({{ $user->id }})"
                        class="text-sm font-medium px-4 py-2 rounded-lg text-neutral-500 hover:text-neutral-700 hover:bg-neutral-100 transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="text-sm font-medium px-4 py-2 rounded-lg bg-danger-500 text-white hover:bg-danger-600 transition-colors">
                    Ya, Hapus User
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    function bukaModalHapusUser(id) {
        const el = document.getElementById('modalHapusUser-' + id);
        if (!el) return;
        el.classList.remove('hidden');
        el.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function tutupModalHapusUser(id) {
        const el = document.getElementById('modalHapusUser-' + id);
        if (!el) return;
        el.classList.add('hidden');
        el.classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="modalHapusUser-"]').forEach(el => {
                el.classList.add('hidden');
                el.classList.remove('flex');
            });
            document.body.style.overflow = '';
        }
    });
</script>