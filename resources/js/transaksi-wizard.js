const state = {
    create: { step: 1 },
    edit:   { step: 1, id: null },
};

const el      = (id)      => document.getElementById(id);
const pEl     = (pfx, id) => el(`${pfx}_${id}`);
const pVal    = (pfx, id) => pEl(pfx, id)?.value ?? '';

// ─── API ───────────────────────────────────────────────────────────────────

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

// ─── UI Helpers ────────────────────────────────────────────────────────────

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

// ─── Paket Aktif ──────────────────────────────────────────────────────────

function loadPaketAktif(prefix, selectedId = null) {
    const sel = pEl(prefix, 'paketMasukId');
    if (!sel) return;

    sel.innerHTML = '<option value="">Memuat paket...</option>';
    sel.disabled  = true;

    apiFetch('/admin/transaksi/paket-aktif')
        .then(data => {
            if (!data.length) {
                sel.innerHTML = '<option value="">Tidak ada paket aktif</option>';
                return;
            }
            sel.innerHTML = '<option value="">-- Pilih Paket --</option>';
            data.forEach(paket => {
                const opt       = document.createElement('option');
                opt.value       = paket.id;
                opt.textContent = paket.nama;
                sel.appendChild(opt);
            });
            if (selectedId) sel.value = selectedId;
            sel.disabled = false;
        })
        .catch(() => {
            sel.innerHTML = '<option value="">Gagal memuat paket</option>';
        });
}

// ─── Create ────────────────────────────────────────────────────────────────

function openModal() {
    resetCreate();
    showModal('modalCreate');
    loadPaketAktif('create');
    goToStep('create', 1);
}

function closeCreate() {
    hideModal('modalCreate');
    resetCreate();
}

function resetCreate() {
    const fields = [
        'memberId', 'memberNama', 'memberNoTelp', 'memberAlamat', 'memberEmail',
        'cariMemberInput',
        'cariMasuk', 'isbnMasuk',
        'masukJudul', 'masukPengarang', 'masukPenerbit', 'masukKategori',
        'masukDeskripsi', 'masukTahunTerbit', 'masukTempatTerbit',
        'catatanPetugas', 'paketMasukId',
    ];
    fields.forEach(id => {
        const e = pEl('create', id);
        if (e) e.value = '';
    });

    const cariMasukInfo = pEl('create', 'cariMasukInfo');
    if (cariMasukInfo) cariMasukInfo.textContent = '';

    const cariMasukResults = pEl('create', 'cariMasukResults');
    if (cariMasukResults) { cariMasukResults.innerHTML = ''; cariMasukResults.classList.add('hidden'); }

    pEl('create', 'cariMemberResults')?.classList.add('hidden');

    resetBukuKeluar('create');
    state.create.step = 1;
}

let isSaving = false;

function simpanTransaksi() {
    if (isSaving) return;
    isSaving = true;

    const payload = buildPayload('create');
    setBtn('createBtnSimpan', true, 'Menyimpan...');

    apiFetch(window.Routes.transaksiStore, {
        method: 'POST',
        body: JSON.stringify(payload),
    })
        .then(data => {
            if (data.success) {
                closeCreate();
                location.reload();
            } else {
                handleSimpanError('create', data);
            }
        })
        .catch(err => {
            console.error('FETCH ERROR:', err);
            alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
        })
        .finally(() => {
            setBtn('createBtnSimpan', false, 'Simpan Transaksi');
            isSaving = false;
        });
}

function handleSimpanError(prefix, data) {
    if (data.error_code === 'stok_habis') {
        alert('Stok buku sudah habis saat disimpan. Silakan pilih buku lain.');
        resetBukuKeluar(prefix);
        goToStep(prefix, 3);
    } else {
        alert(data.message ?? 'Terjadi kesalahan.');
    }
}

// ─── Edit ──────────────────────────────────────────────────────────────────

function openEditTransaksi(id) {
    state.edit.id = id;

    apiFetch(`/admin/transaksi/${id}`)
        .then(data => {
            const m = data.member;
            const b = data.buku_masuk;

            pEl('edit', 'memberId').value    = m.id;
            pEl('edit', 'memberNama').value   = m.nama;
            pEl('edit', 'memberNoTelp').value = m.no_telp;
            pEl('edit', 'memberAlamat').value = m.alamat ?? '';
            pEl('edit', 'memberEmail').value  = m.email  ?? '';

            // Isi input cari masuk dengan judul supaya user tahu buku mana
            const judulLama = b.buku?.judul ?? '';
            const cariMasukEl = pEl('edit', 'cariMasuk');
            if (cariMasukEl) cariMasukEl.value = judulLama;

            isiBukuMasuk('edit', {
                judul:         b.buku?.judul         ?? '',
                pengarang:     b.buku?.pengarang     ?? '',
                penerbit:      b.buku?.penerbit      ?? '',
                kategori:      b.buku?.kategori      ?? '',
                deskripsi:     b.buku?.deskripsi     ?? '',
                isbn:          b.buku?.isbn          ?? '',
                tahun_terbit:  b.buku?.tahun_terbit  ?? '',
                tempat_terbit: b.buku?.tempat_terbit ?? '',
            });

            setBukuKeluar('edit', data.buku_keluar);

            pEl('edit', 'catatanPetugas').value = data.catatan_petugas ?? '';

            showModal('modalEdit');
            loadPaketAktif('edit', b.paket_id ?? null);
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
            if (data.success) {
                closeEdit();
                location.reload();
            } else {
                handleSimpanError('edit', data);
            }
        })
        .catch(() => alert('Gagal menyimpan perubahan.'))
        .finally(() => setBtn('editBtnSimpan', false, 'Simpan Perubahan'));
}

// ─── Payload ───────────────────────────────────────────────────────────────

function buildPayload(prefix) {
    const bukuKeluarIdEl = pEl(prefix, 'bukuKeluarId');

    return {
        member: {
            id:      pVal(prefix, 'memberId') || null,
            nama:    pVal(prefix, 'memberNama'),
            no_telp: pVal(prefix, 'memberNoTelp'),
            alamat:  pVal(prefix, 'memberAlamat'),
            email:   pVal(prefix, 'memberEmail'),
        },
        buku_masuk: {
            judul:         pVal(prefix, 'masukJudul'),
            pengarang:     pVal(prefix, 'masukPengarang'),
            penerbit:      pVal(prefix, 'masukPenerbit'),
            isbn:          pVal(prefix, 'isbnMasuk'),
            kategori:      pVal(prefix, 'masukKategori'),
            deskripsi:     pVal(prefix, 'masukDeskripsi'),
            tahun_terbit:  pVal(prefix, 'masukTahunTerbit')  || null,
            tempat_terbit: pVal(prefix, 'masukTempatTerbit') || null,
        },
        paket_masuk_id:  parseInt(pVal(prefix, 'paketMasukId'))      || null,
        paket_keluar_id: parseInt(bukuKeluarIdEl?.dataset.paketId)   || null,
        buku_keluar_id:  parseInt(pVal(prefix, 'bukuKeluarId'))      || null,
        catatan_petugas: pVal(prefix, 'catatanPetugas'),
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
    if (step === 3) loadBukuPaket(prefix);

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
        if (!requireField('paketMasukId',    'Pilih paket tujuan buku yang masuk.')) return false;
        if (!requireField('masukJudul',      'Judul buku wajib diisi.'))             return false;
        if (!requireField('masukPengarang',  'Pengarang wajib diisi.'))              return false;
        return true;
    }

    if (step === 3) {
        if (!pEl(prefix, 'bukuKeluarId')?.value) {
            alert('Pilih buku yang diberikan ke member.');
            return false;
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

    const paketMasukSel  = pEl(prefix, 'paketMasukId');
    const paketMasukNama = paketMasukSel?.selectedOptions[0]?.textContent ?? '-';

    set('konfirmasiMemberNama', pVal(prefix, 'memberNama'));
    set('konfirmasiMemberTelp', pVal(prefix, 'memberNoTelp'));
    set('konfirmasiBukuMasuk',  pVal(prefix, 'masukJudul'));
    set('konfirmasiPaketMasuk', paketMasukNama);
    set('konfirmasiBukuKeluar', pEl(prefix, 'bukuKeluarJudul')?.textContent  ?? '-');
    set('konfirmasiPaket',      pEl(prefix, 'bukuKeluarPaket')?.textContent  ?? '-');
    set('konfirmasiLokasi',     pEl(prefix, 'bukuKeluarLokasi')?.textContent ?? '-');
    set('konfirmasiCatatan',    pVal(prefix, 'catatanPetugas') || '-');
}

// ─── Buku Masuk — live search ──────────────────────────────────────────────

function cariMasukByInput(prefix, input) {
    const info    = pEl(prefix, 'cariMasukInfo');
    const results = pEl(prefix, 'cariMasukResults');

    if (info)    info.textContent = '';
    if (results) { results.innerHTML = ''; results.classList.add('hidden'); }

    if (!input) return;

    const isIsbn = /^[\d\-]{10,}$/.test(input);

    if (isIsbn) {
        const isbn = input.replace(/-/g, '');
        apiFetch(`/admin/transaksi/cari-buku-meta?isbn=${encodeURIComponent(isbn)}`)
            .then(data => {
                if (data && data.judul) {
                    isiBukuMasuk(prefix, data);
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
    } else {
        apiFetch(`/admin/transaksi/cari-buku-masuk-judul?keyword=${encodeURIComponent(input)}`)
            .then(data => {
                if (!data.length) {
                    if (results) results.classList.add('hidden');
                    return;
                }
                renderHasilBukuMasuk(prefix, data, results);
            })
            .catch(() => {
                if (info) {
                    info.textContent = 'Gagal mencari buku.';
                    info.className   = 'text-[0.68rem] text-danger-600 mt-1';
                }
            });
    }
}

function renderHasilBukuMasuk(prefix, data, container) {
    container.innerHTML = '';
    data.forEach(buku => {
        const btn = document.createElement('button');
        btn.type      = 'button';
        btn.className = 'w-full text-left px-3 py-2.5 text-xs hover:bg-primary-50 transition-colors border-b border-neutral-50 last:border-0';

        const judul = document.createElement('span');
        judul.className   = 'font-semibold text-neutral-800';
        judul.textContent = buku.judul ?? '-';

        const pengarang = document.createElement('span');
        pengarang.className   = 'text-neutral-400 ml-1';
        pengarang.textContent = `— ${buku.pengarang ?? '-'}`;

        const isbn = document.createElement('span');
        isbn.className   = 'block text-[0.65rem] text-neutral-400 mt-0.5 font-mono';
        isbn.textContent = buku.isbn ? `ISBN: ${buku.isbn}` : '';

        btn.append(judul, pengarang, isbn);
        btn.addEventListener('click', () => {
            isiBukuMasuk(prefix, buku);
            container.innerHTML = '';
            container.classList.add('hidden');
            const cariInput = pEl(prefix, 'cariMasuk');
            if (cariInput) cariInput.value = buku.judul ?? '';
        });
        container.appendChild(btn);
    });
    container.classList.remove('hidden');
}

function isiBukuMasuk(prefix, data) {
    pEl(prefix, 'masukJudul').value        = data.judul         ?? '';
    pEl(prefix, 'masukPengarang').value    = data.pengarang     ?? '';
    pEl(prefix, 'masukPenerbit').value     = data.penerbit      ?? '';
    pEl(prefix, 'masukKategori').value     = data.kategori      ?? '';
    pEl(prefix, 'masukTahunTerbit').value  = data.tahun_terbit  ?? '';
    pEl(prefix, 'masukTempatTerbit').value = data.tempat_terbit ?? '';
    pEl(prefix, 'masukDeskripsi').value    = data.deskripsi     ?? '';
    pEl(prefix, 'isbnMasuk').value         = data.isbn          ?? '';
}

// ─── Buku Keluar ──────────────────────────────────────────────────────────

function setBukuKeluar(prefix, buku) {
    const idEl = pEl(prefix, 'bukuKeluarId');
    if (idEl) {
        idEl.value           = buku.id;
        idEl.dataset.paketId = buku.paket_id ?? buku.paket?.id ?? '';
    }

    const judulEl = pEl(prefix, 'bukuKeluarJudul');
    if (judulEl) judulEl.textContent = buku.buku?.judul ?? buku.judul ?? '-';

    const pengarangEl = pEl(prefix, 'bukuKeluarPengarang');
    if (pengarangEl) pengarangEl.textContent = buku.buku?.pengarang ?? buku.pengarang ?? '-';

    const stokEl = pEl(prefix, 'bukuKeluarStok');
    if (stokEl) stokEl.textContent = buku.stok ?? '-';

    const paketEl = pEl(prefix, 'bukuKeluarPaket');
    if (paketEl) paketEl.textContent = buku.paket?.nama ?? '-';

    const lokasiEl = pEl(prefix, 'bukuKeluarLokasi');
    if (lokasiEl) lokasiEl.textContent = buku.paket?.lokasi?.nama_lokasi ?? '-';

    pEl(prefix, 'bukuKeluarResult')?.classList.remove('hidden');
    pEl(prefix, 'bukuKeluarEmpty')?.classList.add('hidden');

    const results = pEl(prefix, 'cariBukuKeluarResults');
    if (results) { results.innerHTML = ''; results.classList.add('hidden'); }
}

function resetBukuKeluar(prefix) {
    const idEl = pEl(prefix, 'bukuKeluarId');
    if (idEl) {
        idEl.value           = '';
        idEl.dataset.paketId = '';
    }

    const cariInput = pEl(prefix, 'cariBukuKeluar');
    if (cariInput) cariInput.value = '';

    const cariInfo = pEl(prefix, 'cariBukuKeluarInfo');
    if (cariInfo) cariInfo.textContent = '';

    const cariResults = pEl(prefix, 'cariBukuKeluarResults');
    if (cariResults) { cariResults.innerHTML = ''; cariResults.classList.add('hidden'); }

    pEl(prefix, 'bukuKeluarResult')?.classList.add('hidden');
    pEl(prefix, 'bukuKeluarEmpty')?.classList.remove('hidden');
}

// ─── Buku Keluar — live search ────────────────────────────────────────────

function cariBukuKeluar(prefix) {
    const input = pEl(prefix, 'cariBukuKeluar')?.value.trim();
    if (!input) return;

    const info    = pEl(prefix, 'cariBukuKeluarInfo');
    const results = pEl(prefix, 'cariBukuKeluarResults');
    if (info)    info.textContent = '';
    if (results) { results.innerHTML = ''; results.classList.add('hidden'); }

    const isIsbn = /^[\d\-]{10,}$/.test(input);

    if (isIsbn) {
        const isbn = input.replace(/-/g, '');
        apiFetch(`/admin/transaksi/cari-buku-isbn?isbn=${encodeURIComponent(isbn)}`)
            .then(data => {
                if (!data) {
                    if (info) {
                        info.textContent = 'Buku tidak ditemukan.';
                        info.className   = 'text-[0.68rem] text-warning-600 mt-1';
                    }
                } else if (data.stok <= 0) {
                    if (info) {
                        info.textContent = 'Stok buku ini habis.';
                        info.className   = 'text-[0.68rem] text-danger-600 mt-1';
                    }
                } else {
                    setBukuKeluar(prefix, data);
                }
            })
            .catch(() => {
                if (info) {
                    info.textContent = 'Gagal mencari ISBN.';
                    info.className   = 'text-[0.68rem] text-danger-600 mt-1';
                }
            });
    } else {
        apiFetch(`/admin/transaksi/cari-buku-judul?keyword=${encodeURIComponent(input)}`)
            .then(data => {
                if (!data.length) {
                    if (info) {
                        info.textContent = 'Buku tidak ditemukan atau stok habis.';
                        info.className   = 'text-[0.68rem] text-warning-600 mt-1';
                    }
                    return;
                }
                renderHasilBukuKeluar(prefix, data, results);
            })
            .catch(() => {
                if (info) {
                    info.textContent = 'Gagal mencari buku.';
                    info.className   = 'text-[0.68rem] text-danger-600 mt-1';
                }
            });
    }
}

function loadBukuPaket(prefix) {
    const container = pEl(prefix, 'listBukuLokasi');
    if (!container) return;

    if (container.dataset.loaded === '1') return;

    container.innerHTML = '<div class="px-3 py-4 text-center text-xs text-neutral-400">Memuat daftar buku...</div>';

    apiFetch('/admin/transaksi/buku-by-paket')
        .then(data => {
            if (!data.length) {
                container.innerHTML = '<div class="px-3 py-4 text-center text-xs text-neutral-400">Tidak ada buku tersedia di lokasi ini.</div>';
                return;
            }
            container.innerHTML = '';
            renderHasilBukuKeluar(prefix, data, container);
            container.dataset.loaded = '1';
        })
        .catch(() => {
            container.innerHTML = '<div class="px-3 py-4 text-center text-xs text-danger-400">Gagal memuat daftar buku.</div>';
        });
}

function renderHasilBukuKeluar(prefix, data, container) {
    data.forEach(buku => {
        const btn     = document.createElement('button');
        btn.type      = 'button';
        btn.disabled  = buku.stok <= 0;
        btn.className = `w-full text-left px-3 py-2.5 text-xs border-b border-neutral-50 last:border-0 transition-colors ${
            buku.stok > 0
                ? 'hover:bg-primary-50 cursor-pointer'
                : 'opacity-50 cursor-not-allowed bg-neutral-50'
        }`;

        const judul = document.createElement('span');
        judul.className   = 'font-semibold text-neutral-800';
        judul.textContent = buku.buku?.judul ?? '-';

        const pengarang = document.createElement('span');
        pengarang.className   = 'text-neutral-400 ml-1';
        pengarang.textContent = `— ${buku.buku?.pengarang ?? '-'}`;

        const meta = document.createElement('span');
        meta.className   = `ml-2 text-[0.65rem] font-medium ${buku.stok > 0 ? 'text-primary-600' : 'text-danger-500'}`;
        meta.textContent = buku.stok > 0
            ? `Stok: ${buku.stok} · ${buku.paket?.nama ?? '-'} · ${buku.paket?.lokasi?.nama_lokasi ?? '-'}`
            : 'Stok habis';

        btn.append(judul, pengarang, meta);
        if (buku.stok > 0) {
            btn.addEventListener('click', () => pilihBukuKeluar(prefix, buku));
        }
        container.appendChild(btn);
    });

    if (container.classList.contains('hidden')) {
        container.classList.remove('hidden');
    }
}

function pilihBukuKeluar(prefix, buku) {
    setBukuKeluar(prefix, buku);
    const input = pEl(prefix, 'cariBukuKeluar');
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

        // Member live search
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

            document.addEventListener('click', e => {
                if (!memberInput.contains(e.target)) {
                    pEl(prefix, 'cariMemberResults')?.classList.add('hidden');
                }
            });
        }

        // Buku masuk live search
        const cariMasukInput = pEl(prefix, 'cariMasuk');
        if (cariMasukInput) {
            let debounceMasuk;
            cariMasukInput.addEventListener('input', function () {
                clearTimeout(debounceMasuk);
                const val = this.value.trim();
                debounceMasuk = setTimeout(() => cariMasukByInput(prefix, val), 250);
            });

            document.addEventListener('click', e => {
                if (!cariMasukInput.contains(e.target)) {
                    pEl(prefix, 'cariMasukResults')?.classList.add('hidden');
                }
            });
        }

        // Buku keluar live search
        const cariBukuKeluarInput = pEl(prefix, 'cariBukuKeluar');
        if (cariBukuKeluarInput) {
            let debounceKeluar;
            cariBukuKeluarInput.addEventListener('input', function () {
                clearTimeout(debounceKeluar);
                const val = this.value.trim();
                debounceKeluar = setTimeout(() => cariBukuKeluar(prefix), 250);
            });

            cariBukuKeluarInput.addEventListener('keydown', e => {
                if (e.key === 'Enter') cariBukuKeluar(prefix);
            });

            document.addEventListener('click', e => {
                if (!cariBukuKeluarInput.contains(e.target)) {
                    pEl(prefix, 'cariBukuKeluarResults')?.classList.add('hidden');
                }
            });
        }
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
    pilihBukuKeluar,
    cariBukuKeluar,
    resetBukuKeluar,
    bukaModalHapusTransaksi,
    tutupModalHapusTransaksi,
});