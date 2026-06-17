<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\BukuEksemplar;
use App\Models\Member;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class TransaksiService
{
    public function cariMember(string $keyword): \Illuminate\Database\Eloquent\Collection
    {
        return Member::where(function ($q) use ($keyword) {
                $q->where('nama', 'ilike', "%{$keyword}%")
                  ->orWhere('no_telp', 'ilike', "%{$keyword}%");
            })
            ->limit(5)
            ->get(['id', 'nama', 'no_telp', 'alamat', 'email']);
    }

    public function simpanAtauUpdateMember(array $data): Member
    {
        if (! empty($data['id'])) {
            $member = Member::findOrFail($data['id']);
            $member->update(collect($data)->except('id')->toArray());
            return $member->fresh();
        }

        return Member::create($data);
    }

    public function cariBukuByIsbn(string $isbn, ?int $lokasiId): ?BukuEksemplar
    {
        $query = BukuEksemplar::whereHas('buku', fn($q) => $q->where('isbn', $isbn))
            ->whereHas('paket', fn($q) => $q->aktif()->when($lokasiId, fn($q) => $q->where('lokasi_id', $lokasiId)))
            ->with('buku', 'paket.lokasi');

        return $query->clone()->tersedia()->first() ?? $query->first();
    }

    public function cariBukuByJudul(string $keyword, ?int $lokasiId): \Illuminate\Database\Eloquent\Collection
    {
        return BukuEksemplar::whereHas('buku', function ($q) use ($keyword) {
                $q->where('judul', 'ilike', "%{$keyword}%")
                ->orWhere('pengarang', 'ilike', "%{$keyword}%");
            })
            ->whereHas('paket', fn($q) => $q->aktif()->when($lokasiId, fn($q) => $q->where('lokasi_id', $lokasiId)))
            ->with('buku', 'paket.lokasi')
            ->limit(10)
            ->orderByDesc('stok')
            ->get();
    }

    public function bukuByLokasi(?int $lokasiId): \Illuminate\Database\Eloquent\Collection
    {
        return BukuEksemplar::with('buku', 'paket.lokasi')
            ->whereHas('paket', fn($q) => $q->aktif()->when($lokasiId, fn($q) => $q->where('lokasi_id', $lokasiId)))
            ->tersedia()
            ->orderByDesc('stok')
            ->when(is_null($lokasiId), fn($q) => $q->limit(50))
            ->get();
    }

    public function simpan(array $data): Transaksi
    {
        return DB::transaction(function () use ($data) {
            $data['member']['user_id'] = $data['user_id'];
            $member        = $this->simpanAtauUpdateMember($data['member']);
            $isbnMasuk     = $data['buku_masuk']['isbn'] ?? null;
            $paketMasukId  = $data['paket_masuk_id'];
            $paketKeluarId = $data['paket_keluar_id'];
            $lokasiId      = $data['lokasi_id'] ?? null; // ← dari session, dipass controller

            // Guard: paket masuk dan paket keluar harus milik lokasi yang aktif
            if ($lokasiId) {
                $paketMasuk = \App\Models\Paket::findOrFail($paketMasukId);
                if ((int) $paketMasuk->lokasi_id !== (int) $lokasiId) {
                    throw new \RuntimeException('Paket masuk tidak sesuai dengan lokasi aktif.');
                }

                $paketKeluar = \App\Models\Paket::findOrFail($paketKeluarId);
                if ((int) $paketKeluar->lokasi_id !== (int) $lokasiId) {
                    throw new \RuntimeException('Paket keluar tidak sesuai dengan lokasi aktif.');
                }
            }

            // --- Buku masuk ---
            $eksemplarMasuk = null;

            if ($isbnMasuk) {
                $eksemplarMasuk = BukuEksemplar::whereHas('buku', fn($q) => $q->where('isbn', $isbnMasuk))
                    ->where('paket_id', $paketMasukId)
                    ->lockForUpdate()
                    ->first();
            }

            if ($eksemplarMasuk) {
                $eksemplarMasuk->tambahStok();
            } else {
                $buku = $isbnMasuk
                    ? Buku::firstOrCreate(
                        ['isbn' => $isbnMasuk],
                        [
                            'judul'         => $data['buku_masuk']['judul'],
                            'pengarang'     => $data['buku_masuk']['pengarang'],
                            'penerbit'      => $data['buku_masuk']['penerbit']      ?? null,
                            'tahun_terbit'  => $data['buku_masuk']['tahun_terbit']  ?? null,
                            'tempat_terbit' => $data['buku_masuk']['tempat_terbit'] ?? null,
                            'kategori'      => $data['buku_masuk']['kategori']      ?? null,
                            'deskripsi'     => $data['buku_masuk']['deskripsi']     ?? null,
                            'is_visible'    => false,
                            'user_id'       => $data['user_id'],
                        ]
                    )
                    : Buku::create([
                        'judul'         => $data['buku_masuk']['judul'],
                        'pengarang'     => $data['buku_masuk']['pengarang'],
                        'penerbit'      => $data['buku_masuk']['penerbit']      ?? null,
                        'tahun_terbit'  => $data['buku_masuk']['tahun_terbit']  ?? null,
                        'tempat_terbit' => $data['buku_masuk']['tempat_terbit'] ?? null,
                        'kategori'      => $data['buku_masuk']['kategori']      ?? null,
                        'deskripsi'     => $data['buku_masuk']['deskripsi']     ?? null,
                        'is_visible'    => false,
                        'user_id'       => $data['user_id'],
                    ]);

                $eksemplarMasuk = BukuEksemplar::create([
                    'buku_id'  => $buku->id,
                    'paket_id' => $paketMasukId,
                    'stok'     => 1,
                ]);
            }

            // --- Buku keluar ---
            $eksemplarKeluar = BukuEksemplar::with('paket.lokasi')
                ->lockForUpdate()
                ->findOrFail($data['buku_keluar_id']);

            if ($eksemplarKeluar->stok < 1) {
                throw new \RuntimeException('Stok buku yang dipilih sudah habis.');
            }

            if (! $eksemplarKeluar->paket?->is_aktif) {
                throw new \RuntimeException('Paket buku yang dipilih tidak aktif.');
            }

            $eksemplarKeluar->kurangiStok();

            return Transaksi::create([
                'member_id'       => $member->id,
                'paket_id'        => $paketKeluarId,
                'buku_masuk_id'   => $eksemplarMasuk->id,
                'buku_keluar_id'  => $eksemplarKeluar->id,
                'user_id'         => $data['user_id'],
                'catatan_petugas' => $data['catatan_petugas'] ?? null,
                'tanggal_tukar'   => now(),
                'lokasi_snapshot' => $eksemplarKeluar->paket?->lokasi?->nama_lokasi,
            ]);
        });
    }

    public function update(int $id, array $data): Transaksi
    {
        return DB::transaction(function () use ($id, $data) {
            $transaksi = Transaksi::findOrFail($id);

            $data['member']['user_id'] = $transaksi->user_id;
            $this->simpanAtauUpdateMember($data['member']);

            $eksemplarLama = BukuEksemplar::lockForUpdate()->findOrFail($transaksi->buku_keluar_id);
            $eksemplarLama->tambahStok();

            $eksemplarBaru = BukuEksemplar::with('paket')
                ->lockForUpdate()
                ->findOrFail($data['buku_keluar_id']);

            if ($eksemplarBaru->stok < 1) {
                throw new \RuntimeException('Stok buku yang dipilih sudah habis.');
            }

            if (! $eksemplarBaru->paket?->is_aktif) {
                throw new \RuntimeException('Paket buku yang dipilih tidak aktif.');
            }

            $eksemplarBaru->kurangiStok();

            $transaksi->update([
                'buku_keluar_id'  => $eksemplarBaru->id,
                'catatan_petugas' => $data['catatan_petugas'] ?? null,
            ]);

            return $transaksi->fresh();
        });
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $transaksi = Transaksi::findOrFail($id);

            BukuEksemplar::lockForUpdate()->findOrFail($transaksi->buku_keluar_id)->tambahStok();

            $transaksi->delete();
        });
    }
}