<div id="modalEdit" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeEdit()"></div>

    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-0.5 bg-warning-400"></div>

        <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-neutral-100">
            <div>
                <h2 class="text-sm font-semibold text-neutral-800">Edit Transaksi</h2>
                <p class="text-xs text-neutral-400 mt-0.5" id="editSubtitle">Langkah 1 dari 4</p>
            </div>
            <button onclick="closeEdit()" class="p-1.5 rounded-lg text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        @include('admin.transaksi._step-indicator', ['prefix' => 'edit'])

        <div class="px-6 py-5 min-h-[280px]">
            @include('admin.transaksi._step-member',     ['prefix' => 'edit'])
            @include('admin.transaksi._step-diserahkan', ['prefix' => 'edit'])
            @include('admin.transaksi._step-diterima',   ['prefix' => 'edit'])
            @include('admin.transaksi._step-konfirmasi', ['prefix' => 'edit'])
        </div>

        <div class="flex items-center justify-between px-6 py-4 border-t border-neutral-100 bg-neutral-50">
            <button id="editBtnPrev" onclick="prevStep('edit')" class="hidden text-xs font-medium px-4 py-2 rounded-lg border border-neutral-200 text-neutral-600 hover:bg-white transition-colors">
                ← Sebelumnya
            </button>
            <div class="ml-auto flex gap-2">
                <button onclick="closeEdit()" class="text-xs font-medium px-4 py-2 rounded-lg border border-neutral-200 text-neutral-500 hover:bg-white transition-colors">
                    Batal
                </button>
                <button id="editBtnNext" onclick="nextStep('edit')" class="text-xs font-medium px-4 py-2 rounded-lg bg-primary text-white hover:bg-primary-600 transition-colors">
                    Selanjutnya →
                </button>
                <button id="editBtnSimpan" onclick="updateTransaksi()" class="hidden text-xs font-medium px-4 py-2 rounded-lg bg-warning-500 text-white hover:bg-warning-600 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let editStep = 1;
let editId   = null;

function openEditTransaksi(id) {
    editId = id;
    fetch(`/admin/transaksi/${id}`)
        .then(r => r.json())
        .then(data => {
            document.getElementById('edit_memberId').value      = data.member.id;
            document.getElementById('edit_memberNama').value    = data.member.nama;
            document.getElementById('edit_memberNoTelp').value  = data.member.no_telp;
            document.getElementById('edit_memberAlamat').value  = data.member.alamat  ?? '';
            document.getElementById('edit_memberEmail').value   = data.member.email   ?? '';
            document.getElementById('edit_diserahkanJudul').value     = data.buku_diserahkan.judul;
            document.getElementById('edit_diserahkanPengarang').value = data.buku_diserahkan.pengarang;
            document.getElementById('edit_diserahkanPenerbit').value  = data.buku_diserahkan.penerbit  ?? '';
            document.getElementById('edit_diserahkanKategori').value  = data.buku_diserahkan.kategori  ?? '';
            document.getElementById('edit_diserahkanDeskripsi').value = data.buku_diserahkan.deskripsi ?? '';
            document.getElementById('edit_isbnDiserahkan').value      = data.buku_diserahkan.isbn      ?? '';
            setKondisi('edit', data.buku_diserahkan.kondisi ?? '');
            setBukuDiterima('edit', data.buku_diterima);
            document.getElementById('edit_catatanPetugas').value = data.catatan_petugas ?? '';
            document.getElementById('modalEdit').classList.remove('hidden');
            document.getElementById('modalEdit').classList.add('flex');
            goToStep('edit', 1);
        });
}

function closeEdit() {
    document.getElementById('modalEdit').classList.add('hidden');
    document.getElementById('modalEdit').classList.remove('flex');
    editId = null;
}

function updateTransaksi() {
    const payload = {
        member: {
            id:      document.getElementById('edit_memberId').value,
            nama:    document.getElementById('edit_memberNama').value,
            no_telp: document.getElementById('edit_memberNoTelp').value,
            alamat:  document.getElementById('edit_memberAlamat').value,
            email:   document.getElementById('edit_memberEmail').value,
        },
        buku_diserahkan: {
            judul:     document.getElementById('edit_diserahkanJudul').value,
            pengarang: document.getElementById('edit_diserahkanPengarang').value,
            penerbit:  document.getElementById('edit_diserahkanPenerbit').value,
            isbn:      document.getElementById('edit_isbnDiserahkan').value,
            kategori:  document.getElementById('edit_diserahkanKategori').value,
            kondisi:   document.querySelector('input[name="edit_diserahkanKondisi"]:checked')?.value,
            deskripsi: document.getElementById('edit_diserahkanDeskripsi').value,
        },
        buku_diterima_id: document.getElementById('edit_bukuDiterimaId').value,
        catatan_petugas:  document.getElementById('edit_catatanPetugas').value,
    };

    const btn = document.getElementById('editBtnSimpan');
    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    fetch(`/admin/transaksi/${editId}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify(payload),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) { closeEdit(); window.location.reload(); }
        else alert(data.message ?? 'Terjadi kesalahan.');
    })
    .catch(() => alert('Gagal menyimpan perubahan.'))
    .finally(() => { btn.disabled = false; btn.textContent = 'Simpan Perubahan'; });
}
</script>