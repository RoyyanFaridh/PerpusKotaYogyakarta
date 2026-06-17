<script>
function togglePermission(userId) {
    const row = document.getElementById('permission-row-' + userId);
    const btn = document.getElementById('btn-permission-' + userId);
    if (!row) return;

    const isHidden = row.classList.contains('hidden');

    document.querySelectorAll('[id^="permission-row-"]').forEach(r => {
        if (!r.classList.contains('hidden')) {
            const card = r.querySelector('td > div');
            card.style.transition = 'opacity 0.15s ease, transform 0.15s ease';
            card.style.opacity    = '0';
            card.style.transform  = 'translateY(-4px)';
            setTimeout(() => r.classList.add('hidden'), 150);
        }
    });

    document.querySelectorAll('[id^="btn-permission-"]').forEach(b => {
        b.classList.remove('border-primary-300', 'text-primary-600', 'bg-primary-50');
    });

    if (isHidden) {
        setTimeout(() => {
            row.classList.remove('hidden');
            const card = row.querySelector('td > div');
            card.style.opacity    = '0';
            card.style.transform  = 'translateY(-4px)';
            card.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
            requestAnimationFrame(() => requestAnimationFrame(() => {
                card.style.opacity   = '1';
                card.style.transform = 'translateY(0)';
            }));
            setTimeout(() => row.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 50);
        }, 160);

        if (btn) btn.classList.add('border-primary-300', 'text-primary-600', 'bg-primary-50');
    }
}

// lokasiAktifIds diisi dari PHP saat buka modal
function bukaModalPenugasan(userId, nama, lokasiAktifIds) {
    const modal    = document.getElementById('modal-penugasan');
    const form     = document.getElementById('form-penugasan');
    const subtitle = document.getElementById('modal-penugasan-subtitle');

    form.action          = `/admin/pengaturan/user/${userId}/lokasi/sync`;
    subtitle.textContent = nama;

    // Reset semua checkbox dulu
    document.querySelectorAll('.checkbox-lokasi').forEach(cb => {
        cb.checked = lokasiAktifIds.includes(parseInt(cb.value));

        // Update style label sesuai status checked
        const label = cb.closest('label');
        if (cb.checked) {
            label.classList.add('border-primary-200', 'bg-primary-50');
            label.classList.remove('border-neutral-100', 'bg-neutral-50');
        } else {
            label.classList.remove('border-primary-200', 'bg-primary-50');
            label.classList.add('border-neutral-100', 'bg-neutral-50');
        }
    });

    // Live update style saat checkbox diklik
    document.querySelectorAll('.checkbox-lokasi').forEach(cb => {
        cb.onchange = () => {
            const label = cb.closest('label');
            if (cb.checked) {
                label.classList.add('border-primary-200', 'bg-primary-50');
                label.classList.remove('border-neutral-100', 'bg-neutral-50');
            } else {
                label.classList.remove('border-primary-200', 'bg-primary-50');
                label.classList.add('border-neutral-100', 'bg-neutral-50');
            }
        };
    });

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function tutupModalPenugasan() {
    document.getElementById('modal-penugasan').classList.add('hidden');
    document.body.style.overflow = '';
}

function bukaModalHistori(userId, nama) {
    const modal    = document.getElementById('modal-histori');
    const subtitle = document.getElementById('modal-histori-subtitle');
    const body     = document.getElementById('modal-histori-body');

    subtitle.textContent = nama;
    body.innerHTML       = '<p class="text-sm text-neutral-400 text-center py-6">Memuat data...</p>';

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    fetch(`/admin/pengaturan/user/${userId}/lokasi/histori`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => {
        if (!res.ok) throw new Error('Gagal memuat data.');
        return res.json();
    })
    .then(data => {
        if (!data.histori || data.histori.length === 0) {
            body.innerHTML = '<p class="text-sm text-neutral-400 text-center py-6">Belum ada histori penugasan.</p>';
            return;
        }

        const rows = data.histori.map(item => {
            const assignedAt  = item.assigned_at       ?? '-';
            const assignedBy  = item.assigned_by_nama  ?? '-';
            const lokasi      = item.lokasi_nama        ?? '-';

            const statusBadge = item.aktif
                ? `<span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-success-50 text-success-700 border border-success-100">Aktif</span>`
                : `<span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-neutral-100 text-neutral-500">Selesai</span>`;

            const aksiHtml = item.aktif
                ? `<form method="POST" action="/admin/pengaturan/user/${userId}/lokasi/${item.id}"
                         onsubmit="return confirm('Nonaktifkan penugasan di ${lokasi}?')">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                       <input type="hidden" name="_method" value="DELETE">
                       <button type="submit" class="text-xs text-danger-500 hover:text-danger-700 hover:underline transition-colors">
                           Nonaktifkan
                       </button>
                   </form>`
                : `<span class="text-xs text-neutral-300">${item.unassigned_at ?? '-'}</span>`;

            return `
                <div class="flex items-start justify-between gap-3 py-3 border-b border-neutral-100 last:border-0">
                    <div class="flex flex-col gap-0.5 min-w-0">
                        <p class="text-xs font-semibold text-neutral-700 truncate">${lokasi}</p>
                        <p class="text-xs text-neutral-400">Ditugaskan ${assignedAt} oleh ${assignedBy}</p>
                    </div>
                    <div class="flex flex-col items-end gap-1.5 shrink-0">
                        ${statusBadge}
                        ${aksiHtml}
                    </div>
                </div>`;
        }).join('');

        body.innerHTML = `<div class="flex flex-col">${rows}</div>`;
    })
    .catch(() => {
        body.innerHTML = '<p class="text-sm text-danger-500 text-center py-6">Gagal memuat histori. Coba lagi.</p>';
    });
}

function tutupModalHistori() {
    document.getElementById('modal-histori').classList.add('hidden');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', e => {
    if (e.key !== 'Escape') return;
    tutupModalAssign();
    tutupModalHistori();
});
</script>