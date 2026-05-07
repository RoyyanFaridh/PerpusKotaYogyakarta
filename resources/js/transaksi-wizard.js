// ─── State ───────────────────────────────────────────────
let createStep = 1;
let editStep   = 1;
let editId     = null;

// ─── Create ──────────────────────────────────────────────
function resetCreate() {
    createStep = 1;
    [
        'memberId', 'memberNama', 'memberNoTelp', 'memberAlamat', 'memberEmail',
        'cariMemberInput', 'isbnDiserahkan', 'diserahkanJudul', 'diserahkanPengarang',
        'diserahkanPenerbit', 'diserahkanKategori', 'diserahkanDeskripsi', 'catatanPetugas'
    ].forEach(id => {
        const el = document.getElementById('create_' + id);
        if (el) el.value = '';
    });
    const info    = document.getElementById('create_isbnDiserahkanInfo');
    const results = document.getElementById('create_cariMemberResults');
    if (info)    info.textContent = '';
    if (results) results.classList.add('hidden');
    setKondisi('create', '');
    resetBukuDiterima('create');
}

function openModal() {
    resetCreate();
    document.getElementById('modalCreate').classList.remove('hidden');
    document.getElementById('modalCreate').classList.add('flex');
    goToStep('create', 1);
}

function closeCreate() {
    document.getElementById('modalCreate').classList.add('hidden');
    document.getElementById('modalCreate').classList.remove('flex');
    resetCreate();
}

function simpanTransaksi() {
    const payload = {
        member: {
            id:      document.getElementById('create_memberId').value || null,
            nama:    document.getElementById('create_memberNama').value,
            no_telp: document.getElementById('create_memberNoTelp').value,
            alamat:  document.getElementById('create_memberAlamat').value,
            email:   document.getElementById('create_memberEmail').value,
        },
        buku_diserahkan: {
            judul:     document.getElementById('create_diserahkanJudul').value,
            pengarang: document.getElementById('create_diserahkanPengarang').value,
            penerbit:  document.getElementById('create_diserahkanPenerbit').value,
            isbn:      document.getElementById('create_isbnDiserahkan').value,
            kategori:  document.getElementById('create_diserahkanKategori').value,
            kondisi:   document.querySelector('input[name="create_diserahkanKondisi"]:checked')?.value,
            deskripsi: document.getElementById('create_diserahkanDeskripsi').value,
        },
        buku_diterima_id: document.getElementById('create_bukuDiterimaId').value,
        catatan_petugas:  document.getElementById('create_catatanPetugas').value,
    };

    const btn = document.getElementById('createBtnSimpan');
    btn.disabled    = true;
    btn.textContent = 'Menyimpan...';

    fetch('/admin/transaksi', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: JSON.stringify(payload),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) { closeCreate(); window.location.reload(); }
        else alert(data.message ?? 'Terjadi kesalahan.');
    })
    .catch(() => alert('Gagal menyimpan transaksi.'))
    .finally(() => { btn.disabled = false; btn.textContent = 'Simpan Transaksi'; });
}

// ─── Edit ────────────────────────────────────────────────
function openEditTransaksi(id) {
    editId = id;
    fetch(`/admin/transaksi/${id}`)
        .then(r => r.json())
        .then(data => {
            document.getElementById('edit_memberId').value            = data.member.id;
            document.getElementById('edit_memberNama').value          = data.member.nama;
            document.getElementById('edit_memberNoTelp').value        = data.member.no_telp;
            document.getElementById('edit_memberAlamat').value        = data.member.alamat  ?? '';
            document.getElementById('edit_memberEmail').value         = data.member.email   ?? '';
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
    btn.disabled    = true;
    btn.textContent = 'Menyimpan...';

    fetch(`/admin/transaksi/${editId}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
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

function goToStep(prefix, step) {
    const totalSteps = 4;

    document.querySelectorAll(`.step-content-${prefix}`).forEach(el => el.classList.add('hidden'));
    document.querySelector(`.step-content-${prefix}[data-step="${step}"]`).classList.remove('hidden');

    for (let i = 1; i <= totalSteps; i++) {
        const dot   = document.getElementById(`${prefix}_dot_${i}`);
        const label = document.getElementById(`${prefix}_label_${i}`);
        if (!dot) continue;
        if (i < step) {
            dot.className = 'w-5 h-5 rounded-full flex items-center justify-center text-[0.6rem] font-bold shrink-0 transition-all bg-success-500 text-white';
            dot.innerHTML = `<svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>`;
        } else if (i === step) {
            dot.className = 'w-5 h-5 rounded-full flex items-center justify-center text-[0.6rem] font-bold shrink-0 transition-all bg-primary text-white';
            dot.innerHTML = i;
        } else {
            dot.className = 'w-5 h-5 rounded-full flex items-center justify-center text-[0.6rem] font-bold shrink-0 transition-all bg-neutral-100 text-neutral-400';
            dot.innerHTML = i;
        }
        if (label) label.className = `text-[0.65rem] font-medium hidden sm:block ${i <= step ? 'text-primary-700' : 'text-neutral-400'}`;
    }

    const subtitle = document.getElementById(`${prefix}Subtitle`);
    if (subtitle) subtitle.textContent = `Langkah ${step} dari ${totalSteps}`;

    const btnPrev   = document.getElementById(`${prefix}BtnPrev`);
    const btnNext   = document.getElementById(`${prefix}BtnNext`);
    const btnSimpan = document.getElementById(`${prefix}BtnSimpan`);
    if (btnPrev)   btnPrev.classList.toggle('hidden', step === 1);
    if (btnNext)   btnNext.classList.toggle('hidden', step === totalSteps);
    if (btnSimpan) btnSimpan.classList.toggle('hidden', step !== totalSteps);

    if (step === totalSteps) fillKonfirmasi(prefix);

    if (prefix === 'create') createStep = step;
    if (prefix === 'edit')   editStep   = step;
}

function nextStep(prefix) {
    const step = prefix === 'create' ? createStep : editStep;
    if (!validateStep(prefix, step)) return;
    goToStep(prefix, step + 1);
}

function prevStep(prefix) {
    const step = prefix === 'create' ? createStep : editStep;
    if (step > 1) goToStep(prefix, step - 1);
}

function validateStep(prefix, step) {
    const p = prefix + '_';
    if (step === 1) {
        if (!document.getElementById(p + 'memberNama')?.value.trim())   { alert('Nama member wajib diisi.');    return false; }
        if (!document.getElementById(p + 'memberNoTelp')?.value.trim()) { alert('No. telepon wajib diisi.');    return false; }
    }
    if (step === 2) {
        if (!document.getElementById(p + 'diserahkanJudul')?.value.trim())     { alert('Judul buku wajib diisi.');    return false; }
        if (!document.getElementById(p + 'diserahkanPengarang')?.value.trim()) { alert('Pengarang wajib diisi.');     return false; }
        if (!document.querySelector(`input[name="${prefix}_diserahkanKondisi"]:checked`)) { alert('Kondisi wajib dipilih.'); return false; }
    }
    if (step === 3) {
        if (!document.getElementById(p + 'bukuDiterimaId')?.value) { alert('Pilih buku yang diberikan ke member.'); return false; }
    }
    return true;
}

function fillKonfirmasi(prefix) {
    const p = prefix + '_';
    document.getElementById(p + 'konfirmasiMemberNama').textContent       = document.getElementById(p + 'memberNama').value;
    document.getElementById(p + 'konfirmasiMemberTelp').textContent       = document.getElementById(p + 'memberNoTelp').value;
    document.getElementById(p + 'konfirmasiBukuDiserahkan').textContent   = document.getElementById(p + 'diserahkanJudul').value;
    const kondisi = document.querySelector(`input[name="${prefix}_diserahkanKondisi"]:checked`)?.value ?? '-';
    document.getElementById(p + 'konfirmasiBukuDiserahkanKondisi').textContent = 'Kondisi: ' + kondisi;
    document.getElementById(p + 'konfirmasiBukuDiterima').textContent     = document.getElementById(p + 'bukuDiterimaJudul').textContent;
}

function setKondisi(prefix, val) {
    document.querySelectorAll(`.kondisi-option-${prefix}`).forEach(el => {
        const isActive = el.dataset.value === val;
        el.querySelector('input').checked = isActive;
        el.classList.toggle('border-primary-400', isActive);
        el.classList.toggle('bg-primary-50', isActive);
        el.classList.toggle('text-primary-700', isActive);
    });
}

function setBukuDiterima(prefix, buku) {
    const p = prefix + '_';
    document.getElementById(p + 'bukuDiterimaId').value                = buku.id;
    document.getElementById(p + 'bukuDiterimaJudul').textContent       = buku.judul;
    document.getElementById(p + 'bukuDiterimaPengarang').textContent   = buku.pengarang;
    document.getElementById(p + 'bukuDiterimaStok').textContent        = buku.stok;
    document.getElementById(p + 'bukuDiterimaResult').classList.remove('hidden');
    document.getElementById(p + 'bukuDiterimaEmpty').classList.add('hidden');
}

function resetBukuDiterima(prefix) {
    const p = prefix + '_';
    document.getElementById(p + 'bukuDiterimaId').value = '';
    document.getElementById(p + 'isbnDiterima').value   = '';
    document.getElementById(p + 'isbnDiterimaInfo').textContent = '';
    document.getElementById(p + 'bukuDiterimaResult').classList.add('hidden');
    document.getElementById(p + 'bukuDiterimaEmpty').classList.remove('hidden');
}

function cariIsbnDiserahkan(prefix) {
    const isbn = document.getElementById(prefix + '_isbnDiserahkan').value.trim();
    if (!isbn) return;
    fetch(`/admin/transaksi/cari-buku-isbn?isbn=${encodeURIComponent(isbn)}`)
        .then(r => r.json())
        .then(data => {
            const info = document.getElementById(prefix + '_isbnDiserahkanInfo');
            const p    = prefix + '_';
            if (data) {
                document.getElementById(p + 'diserahkanJudul').value     = data.judul;
                document.getElementById(p + 'diserahkanPengarang').value = data.pengarang;
                document.getElementById(p + 'diserahkanPenerbit').value  = data.penerbit  ?? '';
                document.getElementById(p + 'diserahkanKategori').value  = data.kategori  ?? '';
                setKondisi(prefix, data.kondisi ?? '');
                info.textContent = '✓ Data buku ditemukan dan diisi otomatis.';
                info.className   = 'text-[0.68rem] text-success-600 mt-1';
            } else {
                info.textContent = 'ISBN tidak ditemukan. Isi data buku secara manual.';
                info.className   = 'text-[0.68rem] text-warning-600 mt-1';
            }
        });
}

function cariIsbnDiterima(prefix) {
    const isbn = document.getElementById(prefix + '_isbnDiterima').value.trim();
    if (!isbn) return;
    fetch(`/admin/transaksi/cari-buku-isbn?isbn=${encodeURIComponent(isbn)}`)
        .then(r => r.json())
        .then(data => {
            const info = document.getElementById(prefix + '_isbnDiterimaInfo');
            if (data && data.stok > 0) {
                setBukuDiterima(prefix, data);
                info.textContent = '';
            } else if (data && data.stok === 0) {
                info.textContent = 'Stok buku ini habis.';
                info.className   = 'text-[0.68rem] text-danger-600 mt-1';
            } else {
                info.textContent = 'ISBN tidak ditemukan di koleksi perpustakaan.';
                info.className   = 'text-[0.68rem] text-warning-600 mt-1';
            }
        });
}

document.addEventListener('DOMContentLoaded', () => {
    ['create', 'edit'].forEach(prefix => {
        const input = document.getElementById(prefix + '_cariMemberInput');
        if (!input) return;

        let timeout;
        input.addEventListener('input', function () {
            clearTimeout(timeout);
            const q = this.value.trim();
            const results = document.getElementById(prefix + '_cariMemberResults');
            if (q.length < 2) { results.classList.add('hidden'); return; }

            timeout = setTimeout(() => {
                fetch(`/admin/transaksi/cari-member?keyword=${encodeURIComponent(q)}`)
                    .then(r => r.json())
                    .then(data => {
                        if (!data.length) { results.classList.add('hidden'); return; }
                        results.innerHTML = data.map(m => `
                            <button type="button" onclick='pilihMember("${prefix}", ${JSON.stringify(m)})'
                                class="w-full text-left px-3 py-2.5 text-xs hover:bg-primary-50 transition-colors border-b border-neutral-50 last:border-0">
                                <span class="font-semibold text-neutral-800">${m.nama}</span>
                                <span class="text-neutral-400 ml-2">${m.no_telp}</span>
                            </button>
                        `).join('');
                        results.classList.remove('hidden');
                    });
            }, 300);
        });

        document.getElementById(prefix + '_isbnDiserahkan')?.addEventListener('keydown', e => {
            if (e.key === 'Enter') cariIsbnDiserahkan(prefix);
        });
        document.getElementById(prefix + '_isbnDiterima')?.addEventListener('keydown', e => {
            if (e.key === 'Enter') cariIsbnDiterima(prefix);
        });

        document.querySelectorAll(`.kondisi-option-${prefix}`).forEach(el => {
            el.addEventListener('click', () => setKondisi(prefix, el.dataset.value));
        });
    });
});

function pilihMember(prefix, m) {
    const p = prefix + '_';
    document.getElementById(p + 'memberId').value     = m.id;
    document.getElementById(p + 'memberNama').value   = m.nama;
    document.getElementById(p + 'memberNoTelp').value = m.no_telp;
    document.getElementById(p + 'memberAlamat').value = m.alamat ?? '';
    document.getElementById(p + 'memberEmail').value  = m.email  ?? '';
    document.getElementById(p + 'cariMemberResults').classList.add('hidden');
    document.getElementById(p + 'cariMemberInput').value = '';
}


window.openModal          = openModal;
window.closeCreate        = closeCreate;
window.simpanTransaksi    = simpanTransaksi;
window.openEditTransaksi  = openEditTransaksi;
window.closeEdit          = closeEdit;
window.updateTransaksi    = updateTransaksi;
window.nextStep           = nextStep;
window.prevStep           = prevStep;
window.pilihMember        = pilihMember;
window.cariIsbnDiserahkan = cariIsbnDiserahkan;
window.cariIsbnDiterima   = cariIsbnDiterima;
window.resetBukuDiterima  = resetBukuDiterima;