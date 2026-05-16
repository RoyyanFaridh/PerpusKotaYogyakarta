const state = {
    create: { step: 1 },
    edit:   { step: 1, id: null },
};

const el      = (id)      => document.getElementById(id);
const pEl     = (pfx, id) => el(`${pfx}_${id}`);
const pVal    = (pfx, id) => pEl(pfx, id)?.value ?? '';

function apiFetch(url, options = {}) {
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

// ─── Create ────────────────────────────────────────────────────────────────

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
        'catatanPetugas',
    ];
    fields.forEach(id => {
        const e = pEl('create', id);
        if (e) e.value = '';
    });

    const isbnDiserahkanInfo = pEl('create', 'isbnDiserahkanInfo');
    if (isbnDiserahkanInfo) isbnDiserahkanInfo.textContent = '';

    pEl('create', 'cariMemberResults')?.classList.add('hidden');

    setKondisi('create', '');
    resetBukuDiterima('create');
    state.create.step = 1;
}

function simpanTransaksi() {
    const payload = buildPayload('create');

    setBtn('createBtnSimpan', true, 'Menyimpan...');

    apiFetch(window.Routes.transaksiStore, { method: 'POST', body: JSON.stringify(payload) })
        .then(data => {
            if (data.success) { closeCreate(); location.reload(); }
            else alert(data.message ?? 'Terjadi kesalahan.');
        })
        .catch(() => alert('Gagal menyimpan transaksi.'))
        .finally(() => setBtn('createBtnSimpan', false, 'Simpan Transaksi'));
}

// ─── Edit ──────────────────────────────────────────────────────────────────

function openEditTransaksi(id) {
    state.edit.id = id;

    apiFetch(`/admin/transaksi/${id}`)
        .then(data => {
            const m = data.member;
            const b = data.buku_diserahkan;

            pEl('edit', 'memberId').value           = m.id;
            pEl('edit', 'memberNama').value          = m.nama;
            pEl('edit', 'memberNoTelp').value        = m.no_telp;
            pEl('edit', 'memberAlamat').value        = m.alamat   ?? '';
            pEl('edit', 'memberEmail').value         = m.email    ?? '';

            pEl('edit', 'diserahkanJudul').value     = b.judul;
            pEl('edit', 'diserahkanPengarang').value = b.pengarang;
            pEl('edit', 'diserahkanPenerbit').value  = b.penerbit  ?? '';
            pEl('edit', 'diserahkanKategori').value  = b.kategori  ?? '';
            pEl('edit', 'diserahkanDeskripsi').value = b.deskripsi ?? '';
            pEl('edit', 'isbnDiserahkan').value      = b.isbn      ?? '';

            const lokasiSel = pEl('edit', 'lokasiId');
            if (lokasiSel) lokasiSel.value = b.lokasi_id ?? '';

            setKondisi('edit', b.kondisi ?? '');
            setBukuDiterima('edit', data.buku_diterima);

            pEl('edit', 'catatanPetugas').value = data.catatan_petugas ?? '';

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

// ─── Payload ───────────────────────────────────────────────────────────────

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
            kondisi:   document.querySelector(`input[name="${prefix}_diserahkanKondisi"]:checked`)?.value ?? null,
            deskripsi: pVal(prefix, 'diserahkanDeskripsi'),
        },
        buku_diterima_id: pVal(prefix, 'bukuDiterimaId'),
        lokasi_id:        pVal(prefix, 'lokasiId'),
        catatan_petugas:  pVal(prefix, 'catatanPetugas'),
    };
}

// ─── Step navigation ───────────────────────────────────────────────────────

const TOTAL_STEPS = 4;

function goToStep(prefix, step) {
    document.querySelectorAll(`.step-content-${prefix}`)
        .forEach(e => e.classList.add('hidden'));
    document.querySelector(`.step-content-${prefix}[data-step="${step}"]`)
        ?.classList.remove('hidden');

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
    if (step === 3) loadBukuLokasi(prefix);

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
        return true;
    }

    if (step === 3) {
        if (!pEl(prefix, 'bukuDiterimaId')?.value) {
            alert('Pilih buku yang diberikan ke member.'); return false;
        }
    }

    return true;
}

// ─── Konfirmasi ────────────────────────────────────────────────────────────

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

    set('konfirmasiLokasi', pVal(prefix, 'lokasiNama'));
}

// ─── Kondisi & Buku Diterima ───────────────────────────────────────────────

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
    const idEl = pEl(prefix, 'bukuDiterimaId');
    if (idEl) idEl.value = buku.id;

    const judulEl = pEl(prefix, 'bukuDiterimaJudul');
    if (judulEl) judulEl.textContent = buku.judul;

    const pengarangEl = pEl(prefix, 'bukuDiterimaPengarang');
    if (pengarangEl) pengarangEl.textContent = buku.pengarang;

    const stokEl = pEl(prefix, 'bukuDiterimaStok');
    if (stokEl) stokEl.textContent = buku.stok;

    const lokasiEl = pEl(prefix, 'bukuDiterimaLokasi');
    if (lokasiEl) lokasiEl.textContent = buku.lokasi?.nama_lokasi ?? '-';

    pEl(prefix, 'bukuDiterimaResult')?.classList.remove('hidden');
    pEl(prefix, 'bukuDiterimaEmpty')?.classList.add('hidden');

    // sembunyikan hasil pencarian setelah buku dipilih
    const results = pEl(prefix, 'cariBukuDiterimaResults');
    if (results) { results.innerHTML = ''; results.classList.add('hidden'); }
}

function resetBukuDiterima(prefix) {
    const idEl = pEl(prefix, 'bukuDiterimaId');
    if (idEl) idEl.value = '';

    const cariInput = pEl(prefix, 'cariBukuDiterima');
    if (cariInput) cariInput.value = '';

    const cariInfo = pEl(prefix, 'cariBukuDiterimaInfo');
    if (cariInfo) cariInfo.textContent = '';

    const cariResults = pEl(prefix, 'cariBukuDiterimaResults');
    if (cariResults) { cariResults.innerHTML = ''; cariResults.classList.add('hidden'); }

    pEl(prefix, 'bukuDiterimaResult')?.classList.add('hidden');
    pEl(prefix, 'bukuDiterimaEmpty')?.classList.remove('hidden');
}

// ─── Pencarian ISBN Diserahkan ─────────────────────────────────────────────

function cariIsbnDiserahkan(prefix) {
    const isbn = pEl(prefix, 'isbnDiserahkan')?.value.trim();
    if (!isbn) return;

    const info = pEl(prefix, 'isbnDiserahkanInfo');

    apiFetch(`/admin/transaksi/cari-buku-isbn?isbn=${encodeURIComponent(isbn)}`)
        .then(data => {
            if (data) {
                pEl(prefix, 'diserahkanJudul').value     = data.judul     ?? '';
                pEl(prefix, 'diserahkanPengarang').value = data.pengarang ?? '';
                pEl(prefix, 'diserahkanPenerbit').value  = data.penerbit  ?? '';
                pEl(prefix, 'diserahkanKategori').value  = data.kategori  ?? '';
                setKondisi(prefix, data.kondisi ?? '');
                if (info) {
                    info.textContent = '✓ Data buku ditemukan dan diisi otomatis.';
                    info.className   = 'text-[0.68rem] text-success-600 mt-1';
                }
            } else {
                if (info) {
                    info.textContent = 'ISBN tidak ditemukan. Isi data buku secara manual.';
                    info.className   = 'text-[0.68rem] text-warning-600 mt-1';
                }
            }
        })
        .catch(() => {
            if (info) {
                info.textContent = 'Gagal mencari ISBN.';
                info.className   = 'text-[0.68rem] text-danger-600 mt-1';
            }
        });
}

// ─── Pencarian Buku Diterima (gabungan ISBN + judul) ───────────────────────

function cariBukuDiterima(prefix) {
    const input   = pEl(prefix, 'cariBukuDiterima')?.value.trim();
    const lokasiId = pEl(prefix, 'lokasiId')?.value ?? '';
    if (!input) return;

    const info    = pEl(prefix, 'cariBukuDiterimaInfo');
    const results = pEl(prefix, 'cariBukuDiterimaResults');
    if (info)    info.textContent = '';
    if (results) { results.innerHTML = ''; results.classList.add('hidden'); }

    const lokasiParam = lokasiId ? `&lokasi_id=${lokasiId}` : '';
    const isIsbn = /^[\d\-]{10,}$/.test(input);

    if (isIsbn) {
        const isbn = input.replace(/-/g, '');
        apiFetch(`/admin/transaksi/cari-buku-isbn?isbn=${encodeURIComponent(isbn)}${lokasiParam}`)
            .then(data => {
                if (!data) {
                    if (info) {
                        info.textContent = 'Buku tidak ditemukan di lokasi ini.';
                        info.className   = 'text-[0.68rem] text-warning-600 mt-1';
                    }
                } else if (data.stok <= 0) {
                    if (info) {
                        info.textContent = 'Stok buku ini habis di lokasi Anda.';
                        info.className   = 'text-[0.68rem] text-danger-600 mt-1';
                    }
                } else {
                    setBukuDiterima(prefix, data);
                }
            })
            .catch(() => {
                if (info) {
                    info.textContent = 'Gagal mencari ISBN.';
                    info.className   = 'text-[0.68rem] text-danger-600 mt-1';
                }
            });
    } else {
        apiFetch(`/admin/transaksi/cari-buku-judul?keyword=${encodeURIComponent(input)}${lokasiParam}`)
            .then(data => {
                if (!data.length) {
                    if (info) {
                        info.textContent = 'Buku tidak ditemukan di lokasi ini atau stok habis.';
                        info.className   = 'text-[0.68rem] text-warning-600 mt-1';
                    }
                    return;
                }

                if (results) {
                    data.forEach(buku => {
                        const btn = document.createElement('button');
                        btn.type      = 'button';
                        btn.disabled  = buku.stok <= 0;
                        btn.className = `w-full text-left px-3 py-2.5 text-xs border-b border-neutral-50 last:border-0 transition-colors ${
                            buku.stok > 0
                                ? 'hover:bg-primary-50 cursor-pointer'
                                : 'opacity-50 cursor-not-allowed bg-neutral-50'
                        }`;

                        const judul = document.createElement('span');
                        judul.className   = 'font-semibold text-neutral-800';
                        judul.textContent = buku.judul;

                        const pengarang = document.createElement('span');
                        pengarang.className   = 'text-neutral-400 ml-1';
                        pengarang.textContent = `— ${buku.pengarang}`;

                        const meta = document.createElement('span');
                        meta.className   = `ml-2 text-[0.65rem] font-medium ${buku.stok > 0 ? 'text-primary-600' : 'text-danger-500'}`;
                        meta.textContent = buku.stok > 0
                            ? `Stok: ${buku.stok} · ${buku.lokasi?.nama_lokasi ?? '-'}`
                            : 'Stok habis';

                        btn.append(judul, pengarang, meta);
                        if (buku.stok > 0) {
                            btn.addEventListener('click', () => pilihBukuDiterima(prefix, buku));
                        }
                        results.appendChild(btn);
                    });
                    results.classList.remove('hidden');
                }
            })
            .catch(() => {
                if (info) {
                    info.textContent = 'Gagal mencari buku.';
                    info.className   = 'text-[0.68rem] text-danger-600 mt-1';
                }
            });
    }
}

function loadBukuLokasi(prefix) {
    const container = pEl(prefix, 'listBukuLokasi');
    if (!container) return;

    container.innerHTML = '<div class="px-3 py-4 text-center text-xs text-neutral-400">Memuat daftar buku...</div>';

    apiFetch('/admin/transaksi/cari-buku-lokasi')
        .then(data => {
            if (!data.length) {
                container.innerHTML = '<div class="px-3 py-4 text-center text-xs text-neutral-400">Tidak ada buku tersedia di cabang ini.</div>';
                return;
            }

            container.innerHTML = '';
            data.forEach(buku => {
                const btn = document.createElement('button');
                btn.type      = 'button';
                btn.className = 'w-full text-left px-3 py-2.5 text-xs hover:bg-primary-50 transition-colors border-b border-neutral-50 last:border-0 cursor-pointer';

                const judul = document.createElement('span');
                judul.className   = 'font-semibold text-neutral-800';
                judul.textContent = buku.judul;

                const pengarang = document.createElement('span');
                pengarang.className   = 'text-neutral-400 ml-1';
                pengarang.textContent = `— ${buku.pengarang}`;

                const stok = document.createElement('span');
                stok.className   = 'ml-2 text-[0.65rem] font-medium text-primary-600';
                stok.textContent = `Stok: ${buku.stok}`;

                btn.append(judul, pengarang, stok);
                btn.addEventListener('click', () => pilihBukuDiterima(prefix, buku));
                container.appendChild(btn);
            });
        })
        .catch(() => {
            container.innerHTML = '<div class="px-3 py-4 text-center text-xs text-danger-400">Gagal memuat daftar buku.</div>';
        });
}

function pilihBukuDiterima(prefix, buku) {
    setBukuDiterima(prefix, buku);
    const input = pEl(prefix, 'cariBukuDiterima');
    if (input) input.value = '';
}

// ─── Member ────────────────────────────────────────────────────────────────

function pilihMember(prefix, m) {
    pEl(prefix, 'memberId').value     = m.id;
    pEl(prefix, 'memberNama').value   = m.nama;
    pEl(prefix, 'memberNoTelp').value = m.no_telp;
    pEl(prefix, 'memberAlamat').value = m.alamat ?? '';
    pEl(prefix, 'memberEmail').value  = m.email  ?? '';
    pEl(prefix, 'cariMemberResults')?.classList.add('hidden');
    pEl(prefix, 'cariMemberInput').value = '';
}

// ─── Modal Hapus ───────────────────────────────────────────────────────────

function bukaModalHapusTransaksi(action, label) {
    document.getElementById('formHapusTransaksi').action    = action;
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

// ─── DOMContentLoaded ──────────────────────────────────────────────────────

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

        // update: listener gabungan untuk ISBN + judul buku diterima
        pEl(prefix, 'cariBukuDiterima')?.addEventListener('keydown', e => {
            if (e.key === 'Enter') cariBukuDiterima(prefix);
        });

        document.querySelectorAll(`.kondisi-option-${prefix}`).forEach(e => {
            e.addEventListener('click', () => setKondisi(prefix, e.dataset.value));
        });
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') tutupModalHapusTransaksi();
    });
});

// ─── Global exports ────────────────────────────────────────────────────────

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
    cariBukuDiterima,
    resetBukuDiterima,
    bukaModalHapusTransaksi,
    tutupModalHapusTransaksi,
});