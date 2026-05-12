const state = {
    create: { step: 1 },
    edit:   { step: 1, id: null },
};

const el        = (id)        => document.getElementById(id);
const pEl       = (pfx, id)   => el(`${pfx}_${id}`);
const pVal      = (pfx, id)   => pEl(pfx, id)?.value ?? '';
const pText     = (pfx, id)   => pEl(pfx, id)?.textContent ?? '';

function apiFetch(url, options = {}) {
    const route = window.Routes.transaksiStore;
    return fetch(url, {
        headers: {
            'Content-Type': 'application/json',
            'Accept':       'application/json',
            'X-CSRF-TOKEN': csrf,
            ...options.headers,
        },
        ...options,
    }).then(r => {
        if (!r.ok) throw new Error(`HTTP ${r.status}`);
        return r.json();
    });
}

function setBtn(id, disabled, text) {
    const btn = el(id);
    if (!btn) return;
    btn.disabled    = disabled;
    btn.textContent = text;
}

function showModal(id) {
    el(id)?.classList.remove('hidden');
    el(id)?.classList.add('flex');
}
function hideModal(id) {
    el(id)?.classList.add('hidden');
    el(id)?.classList.remove('flex');
}

function openModal() {
    resetCreate();
    showModal('modalCreate');
    goToStep('create', 1);
}

function closeCreate() {
    hideModal('modalCreate');
    resetCreate();
}

function resetCreate() {
    const fields = [
        'memberId', 'memberNama', 'memberNoTelp', 'memberAlamat', 'memberEmail',
        'cariMemberInput', 'isbnDiserahkan', 'diserahkanJudul', 'diserahkanPengarang',
        'diserahkanPenerbit', 'diserahkanKategori', 'diserahkanDeskripsi',
        'catatanPetugas', 'lokasiId', 'isbnDiterima', 'judulDiterima',
    ];
    fields.forEach(id => {
        const e = pEl('create', id);
        if (e) e.value = '';
    });

    ['isbnDiserahkanInfo', 'isbnDiterimaInfo', 'judulDiterimaInfo'].forEach(id => {
        const e = pEl('create', id);
        if (e) e.textContent = '';
    });

    ['cariMemberResults', 'judulDiterimaResults'].forEach(id => {
        pEl('create', id)?.classList.add('hidden');
    });

    setKondisi('create', '');
    resetBukuDiterima('create');
    state.create.step = 1;
}

function simpanTransaksi() {
    const payload = buildPayload('create');
    payload.lokasi_id = pVal('create', 'lokasiId');

    setBtn('createBtnSimpan', true, 'Menyimpan...');

    apiFetch(window.Routes.transaksiStore, { method: 'POST', body: JSON.stringify(payload) })
        .then(data => {
            if (data.success) { closeCreate(); location.reload(); }
            else alert(data.message ?? 'Terjadi kesalahan.');
        })
        .catch(() => alert('Gagal menyimpan transaksi.'))
        .finally(() => setBtn('createBtnSimpan', false, 'Simpan Transaksi'));
}

function openEditTransaksi(id) {
    state.edit.id = id;

    apiFetch(`/admin/transaksi/${id}`)
        .then(data => {
            const m = data.member;
            const b = data.buku_diserahkan;

            pEl('edit', 'memberId').value            = m.id;
            pEl('edit', 'memberNama').value           = m.nama;
            pEl('edit', 'memberNoTelp').value         = m.no_telp;
            pEl('edit', 'memberAlamat').value         = m.alamat   ?? '';
            pEl('edit', 'memberEmail').value          = m.email    ?? '';

            pEl('edit', 'diserahkanJudul').value      = b.judul;
            pEl('edit', 'diserahkanPengarang').value  = b.pengarang;
            pEl('edit', 'diserahkanPenerbit').value   = b.penerbit  ?? '';
            pEl('edit', 'diserahkanKategori').value   = b.kategori  ?? '';
            pEl('edit', 'diserahkanDeskripsi').value  = b.deskripsi ?? '';
            pEl('edit', 'isbnDiserahkan').value       = b.isbn      ?? '';

            setKondisi('edit', b.kondisi ?? '');
            setBukuDiterima('edit', data.buku_diterima);

            pEl('edit', 'catatanPetugas').value = data.catatan_petugas ?? '';

            const lokasiSel = pEl('edit', 'lokasiId');
            if (lokasiSel) lokasiSel.value = data.lokasi_id ?? '';

            showModal('modalEdit');
            goToStep('edit', 1);
        })
        .catch(() => alert('Gagal memuat data transaksi.'));
}

function closeEdit() {
    hideModal('modalEdit');
    state.edit.id = null;
}

function updateTransaksi() {
    const payload = buildPayload('edit');

    setBtn('editBtnSimpan', true, 'Menyimpan...');

    apiFetch(`/admin/transaksi/${state.edit.id}`, {
        method: 'PUT',
        body: JSON.stringify(payload),
    })
        .then(data => {
            if (data.success) { closeEdit(); location.reload(); }
            else alert(data.message ?? 'Terjadi kesalahan.');
        })
        .catch(() => alert('Gagal menyimpan perubahan.'))
        .finally(() => setBtn('editBtnSimpan', false, 'Simpan Perubahan'));
}

function buildPayload(prefix) {
    return {
        member: {
            id:      pVal(prefix, 'memberId') || null,
            nama:    pVal(prefix, 'memberNama'),
            no_telp: pVal(prefix, 'memberNoTelp'),
            alamat:  pVal(prefix, 'memberAlamat'),
            email:   pVal(prefix, 'memberEmail'),
        },
        buku_diserahkan: {
            judul:     pVal(prefix, 'diserahkanJudul'),
            pengarang: pVal(prefix, 'diserahkanPengarang'),
            penerbit:  pVal(prefix, 'diserahkanPenerbit'),
            isbn:      pVal(prefix, 'isbnDiserahkan'),
            kategori:  pVal(prefix, 'diserahkanKategori'),
            kondisi:   document.querySelector(`input[name="${prefix}_diserahkanKondisi"]:checked`)?.value,
            deskripsi: pVal(prefix, 'diserahkanDeskripsi'),
        },
        buku_diterima_id: pVal(prefix, 'bukuDiterimaId'),
        catatan_petugas:  pVal(prefix, 'catatanPetugas'),
    };
}

const TOTAL_STEPS = 4;

function goToStep(prefix, step) {
    document.querySelectorAll(`.step-content-${prefix}`)
        .forEach(e => e.classList.add('hidden'));
    document.querySelector(`.step-content-${prefix}[data-step="${step}"]`)
        ?.classList.remove('hidden');

    // Update indikator dot & label
    for (let i = 1; i <= TOTAL_STEPS; i++) {
        const dot   = el(`${prefix}_dot_${i}`);
        const label = el(`${prefix}_label_${i}`);
        if (!dot) continue;

        if (i < step) {
            dot.className = 'w-5 h-5 rounded-full flex items-center justify-center text-[0.6rem] font-bold shrink-0 transition-all bg-success-500 text-white';
            dot.innerHTML = `<svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>`;
        } else if (i === step) {
            dot.className = 'w-5 h-5 rounded-full flex items-center justify-center text-[0.6rem] font-bold shrink-0 transition-all bg-primary text-white';
            dot.innerHTML = String(i);
        } else {
            dot.className = 'w-5 h-5 rounded-full flex items-center justify-center text-[0.6rem] font-bold shrink-0 transition-all bg-neutral-100 text-neutral-400';
            dot.innerHTML = String(i);
        }

        if (label) {
            label.className = `text-[0.65rem] font-medium hidden sm:block ${i <= step ? 'text-primary-700' : 'text-neutral-400'}`;
        }
    }

    const subtitle = el(`${prefix}Subtitle`);
    if (subtitle) subtitle.textContent = `Langkah ${step} dari ${TOTAL_STEPS}`;

    el(`${prefix}BtnPrev`)?.classList.toggle('hidden', step === 1);
    el(`${prefix}BtnNext`)?.classList.toggle('hidden', step === TOTAL_STEPS);
    el(`${prefix}BtnSimpan`)?.classList.toggle('hidden', step !== TOTAL_STEPS);

    if (step === TOTAL_STEPS) fillKonfirmasi(prefix);

    state[prefix].step = step;
}

function nextStep(prefix) {
    const { step } = state[prefix];
    if (validateStep(prefix, step)) goToStep(prefix, step + 1);
}

function prevStep(prefix) {
    const { step } = state[prefix];
    if (step > 1) goToStep(prefix, step - 1);
}

function validateStep(prefix, step) {
    const requireField = (id, msg) => {
        if (!pEl(prefix, id)?.value.trim()) { alert(msg); return false; }
        return true;
    };

    if (step === 1) {
        return requireField('memberNama',   'Nama member wajib diisi.')
            && requireField('memberNoTelp', 'No. telepon wajib diisi.');
    }

    if (step === 2) {
        if (!requireField('diserahkanJudul',     'Judul buku wajib diisi.'))  return false;
        if (!requireField('diserahkanPengarang', 'Pengarang wajib diisi.'))   return false;
        if (!document.querySelector(`input[name="${prefix}_diserahkanKondisi"]:checked`)) {
            alert('Kondisi wajib dipilih.'); return false;
        }
        // Lokasi hanya wajib saat create; di edit sudah fix dari transaksi awal
        if (prefix === 'create' && !pEl('create', 'lokasiId')?.value) {
            alert('Pilih lokasi perpustakaan.'); return false;
        }
        return true;
    }

    if (step === 3) {
        if (!pEl(prefix, 'bukuDiterimaId')?.value) {
            alert('Pilih buku yang diberikan ke member.'); return false;
        }
    }

    return true;
}

function fillKonfirmasi(prefix) {
    const set = (id, text) => {
        const e = pEl(prefix, id);
        if (e) e.textContent = text;
    };

    set('konfirmasiMemberNama',            pVal(prefix, 'memberNama'));
    set('konfirmasiMemberTelp',            pVal(prefix, 'memberNoTelp'));
    set('konfirmasiBukuDiserahkan',        pVal(prefix, 'diserahkanJudul'));
    set('konfirmasiBukuDiserahkanKondisi', 'Kondisi: ' + (
        document.querySelector(`input[name="${prefix}_diserahkanKondisi"]:checked`)?.value ?? '-'
    ));
    set('konfirmasiBukuDiterima', pEl(prefix, 'bukuDiterimaJudul')?.textContent ?? '-');

    const lokasiSel = pEl(prefix, 'lokasiId');
    set('konfirmasiLokasi', lokasiSel?.options[lokasiSel.selectedIndex]?.text ?? '-');
}

function setKondisi(prefix, val) {
    document.querySelectorAll(`.kondisi-option-${prefix}`).forEach(e => {
        const active = e.dataset.value === val;
        e.querySelector('input').checked = active;
        e.classList.toggle('border-primary-400', active);
        e.classList.toggle('bg-primary-50',      active);
        e.classList.toggle('text-primary-700',   active);
    });
}

function setBukuDiterima(prefix, buku) {
    pEl(prefix, 'bukuDiterimaId').value              = buku.id;
    pEl(prefix, 'bukuDiterimaJudul').textContent     = buku.judul;
    pEl(prefix, 'bukuDiterimaPengarang').textContent = buku.pengarang;
    pEl(prefix, 'bukuDiterimaStok').textContent      = buku.stok;

    const lokasiEl = pEl(prefix, 'bukuDiterimaLokasi');
    if (lokasiEl) lokasiEl.textContent = buku.lokasi?.nama_lokasi ?? '-';

    pEl(prefix, 'bukuDiterimaResult').classList.remove('hidden');
    pEl(prefix, 'bukuDiterimaEmpty').classList.add('hidden');

    // Sembunyikan hasil pencarian judul setelah buku dipilih
    pEl(prefix, 'judulDiterimaResults')?.classList.add('hidden');
}

function resetBukuDiterima(prefix) {
    pEl(prefix, 'bukuDiterimaId').value         = '';
    pEl(prefix, 'isbnDiterima').value           = '';
    pEl(prefix, 'isbnDiterimaInfo').textContent = '';
    pEl(prefix, 'bukuDiterimaResult').classList.add('hidden');
    pEl(prefix, 'bukuDiterimaEmpty').classList.remove('hidden');

    const judulInput   = pEl(prefix, 'judulDiterima');
    const judulResults = pEl(prefix, 'judulDiterimaResults');
    const judulInfo    = pEl(prefix, 'judulDiterimaInfo');
    if (judulInput)   judulInput.value       = '';
    if (judulResults) judulResults.classList.add('hidden');
    if (judulInfo)    judulInfo.textContent  = '';
}


function cariIsbnDiserahkan(prefix) {
    const isbn = pEl(prefix, 'isbnDiserahkan')?.value.trim();
    if (!isbn) return;

    apiFetch(`/admin/transaksi/cari-buku-isbn?isbn=${encodeURIComponent(isbn)}`)
        .then(data => {
            const info = pEl(prefix, 'isbnDiserahkanInfo');
            if (data) {
                pEl(prefix, 'diserahkanJudul').value     = data.judul;
                pEl(prefix, 'diserahkanPengarang').value = data.pengarang;
                pEl(prefix, 'diserahkanPenerbit').value  = data.penerbit  ?? '';
                pEl(prefix, 'diserahkanKategori').value  = data.kategori  ?? '';
                setKondisi(prefix, data.kondisi ?? '');
                info.textContent = '✓ Data buku ditemukan dan diisi otomatis.';
                info.className   = 'text-[0.68rem] text-success-600 mt-1';
            } else {
                info.textContent = 'ISBN tidak ditemukan. Isi data buku secara manual.';
                info.className   = 'text-[0.68rem] text-warning-600 mt-1';
            }
        })
        .catch(() => {
            const info = pEl(prefix, 'isbnDiserahkanInfo');
            if (info) {
                info.textContent = 'Gagal mencari ISBN.';
                info.className   = 'text-[0.68rem] text-danger-600 mt-1';
            }
        });
}

function cariIsbnDiterima(prefix) {
    const isbn = pEl(prefix, 'isbnDiterima')?.value.trim();
    if (!isbn) return;

    apiFetch(`/admin/transaksi/cari-buku-isbn?isbn=${encodeURIComponent(isbn)}`)
        .then(data => {
            const info = pEl(prefix, 'isbnDiterimaInfo');
            if (data?.stok > 0) {
                setBukuDiterima(prefix, data);
                info.textContent = '';
            } else if (data?.stok === 0) {
                info.textContent = 'Stok buku ini habis.';
                info.className   = 'text-[0.68rem] text-danger-600 mt-1';
            } else {
                info.textContent = 'ISBN tidak ditemukan di koleksi perpustakaan.';
                info.className   = 'text-[0.68rem] text-warning-600 mt-1';
            }
        })
        .catch(() => {
            const info = pEl(prefix, 'isbnDiterimaInfo');
            if (info) {
                info.textContent = 'Gagal mencari ISBN.';
                info.className   = 'text-[0.68rem] text-danger-600 mt-1';
            }
        });
}

function cariJudulDiterima(prefix) {
    const keyword = pEl(prefix, 'judulDiterima')?.value.trim();
    if (!keyword) return;

    const info    = pEl(prefix, 'judulDiterimaInfo');
    const results = pEl(prefix, 'judulDiterimaResults');

    apiFetch(`/admin/transaksi/cari-buku-judul?keyword=${encodeURIComponent(keyword)}`)
        .then(data => {
            if (!data.length) {
                results.classList.add('hidden');
                info.textContent = 'Buku tidak ditemukan atau stok habis.';
                info.className   = 'text-[0.68rem] text-warning-600 mt-1';
                return;
            }

            info.textContent  = '';
            results.innerHTML = '';

            data.forEach(buku => {
                const btn = document.createElement('button');
                btn.type      = 'button';
                btn.className = 'w-full text-left px-3 py-2.5 text-xs hover:bg-primary-50 transition-colors border-b border-neutral-50 last:border-0';

                const judul = document.createElement('span');
                judul.className   = 'font-semibold text-neutral-800';
                judul.textContent = buku.judul;

                const pengarang = document.createElement('span');
                pengarang.className   = 'text-neutral-400 ml-1';
                pengarang.textContent = `— ${buku.pengarang}`;

                const meta = document.createElement('span');
                meta.className   = 'ml-2 text-[0.65rem] text-primary-600 font-medium';
                meta.textContent = `Stok: ${buku.stok} · ${buku.lokasi?.nama_lokasi ?? '-'}`;

                btn.append(judul, pengarang, meta);
                btn.addEventListener('click', () => pilihBukuDiterima(prefix, buku));
                results.appendChild(btn);
            });

            results.classList.remove('hidden');
        })
        .catch(() => {
            if (info) {
                info.textContent = 'Gagal mencari buku.';
                info.className   = 'text-[0.68rem] text-danger-600 mt-1';
            }
        });
}

function pilihBukuDiterima(prefix, buku) {
    setBukuDiterima(prefix, buku);
    const judulInput = pEl(prefix, 'judulDiterima');
    if (judulInput) judulInput.value = '';
}

function pilihMember(prefix, m) {
    pEl(prefix, 'memberId').value     = m.id;
    pEl(prefix, 'memberNama').value   = m.nama;
    pEl(prefix, 'memberNoTelp').value = m.no_telp;
    pEl(prefix, 'memberAlamat').value = m.alamat ?? '';
    pEl(prefix, 'memberEmail').value  = m.email  ?? '';
    pEl(prefix, 'cariMemberResults').classList.add('hidden');
    pEl(prefix, 'cariMemberInput').value = '';
}

function bukaModalHapusTransaksi(action, label) {
    document.getElementById('formHapusTransaksi').action = action;
    document.getElementById('hapusTransaksiId').textContent = label;
    const modal = document.getElementById('modalHapusTransaksi');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function tutupModalHapusTransaksi() {
    const modal = document.getElementById('modalHapusTransaksi');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', () => {
    ['create', 'edit'].forEach(prefix => {

        const memberInput = pEl(prefix, 'cariMemberInput');
        if (memberInput) {
            let debounce;
            memberInput.addEventListener('input', function () {
                clearTimeout(debounce);
                const q       = this.value.trim();
                const results = pEl(prefix, 'cariMemberResults');
                if (q.length < 2) { results?.classList.add('hidden'); return; }

                debounce = setTimeout(() => {
                    apiFetch(`/admin/transaksi/cari-member?keyword=${encodeURIComponent(q)}`)
                        .then(data => {
                            if (!data.length) { results?.classList.add('hidden'); return; }

                            results.innerHTML = '';
                            data.forEach(m => {
                                const btn = document.createElement('button');
                                btn.type      = 'button';
                                btn.className = 'w-full text-left px-3 py-2.5 text-xs hover:bg-primary-50 transition-colors border-b border-neutral-50 last:border-0';

                                const nama = document.createElement('span');
                                nama.className   = 'font-semibold text-neutral-800';
                                nama.textContent = m.nama;

                                const telp = document.createElement('span');
                                telp.className   = 'text-neutral-400 ml-2';
                                telp.textContent = m.no_telp;

                                btn.append(nama, telp);
                                btn.addEventListener('click', () => pilihMember(prefix, m));
                                results.appendChild(btn);
                            });
                            results.classList.remove('hidden');
                        })
                        .catch(() => results?.classList.add('hidden'));
                }, 300);
            });
        }

        pEl(prefix, 'isbnDiserahkan')?.addEventListener('keydown', e => {
            if (e.key === 'Enter') cariIsbnDiserahkan(prefix);
        });
        pEl(prefix, 'isbnDiterima')?.addEventListener('keydown', e => {
            if (e.key === 'Enter') cariIsbnDiterima(prefix);
        });
        pEl(prefix, 'judulDiterima')?.addEventListener('keydown', e => {
            if (e.key === 'Enter') cariJudulDiterima(prefix);
        });

        document.querySelectorAll(`.kondisi-option-${prefix}`).forEach(e => {
            e.addEventListener('click', () => setKondisi(prefix, e.dataset.value));
        });
    });

    // Tutup modal hapus transaksi dengan tombol Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') tutupModalHapusTransaksi();
    });
});


Object.assign(window, {
    openModal,
    closeCreate,
    simpanTransaksi,
    openEditTransaksi,
    closeEdit,
    updateTransaksi,
    nextStep,
    prevStep,
    pilihMember,
    pilihBukuDiterima,
    cariIsbnDiserahkan,
    cariIsbnDiterima,
    cariJudulDiterima,
    resetBukuDiterima,
    bukaModalHapusTransaksi,
    tutupModalHapusTransaksi,
});