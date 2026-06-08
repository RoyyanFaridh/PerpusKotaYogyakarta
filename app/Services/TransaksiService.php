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

    public function cariBukuByIsbn(string $isbn, int $lokasiId): ?BukuEksemplar
    {
        return BukuEksemplar::whereHas('buku', fn($q) => $q->where('isbn', $isbn))
            ->whereHas('paket', fn($q) => $q->aktif()->where('lokasi_id', $lokasiId))
            ->with('buku', 'paket.lokasi')
            ->tersedia()
            ->first()
            ?? BukuEksemplar::whereHas('buku', fn($q) => $q->where('isbn', $isbn))
                ->whereHas('paket', fn($q) => $q->aktif()->where('lokasi_id', $lokasiId))
                ->with('buku', 'paket.lokasi')
                ->first();
    }

    public function cariBukuByJudul(string $keyword, int $lokasiId): \Illuminate\Database\Eloquent\Collection
    {
        return BukuEksemplar::whereHas('buku', function ($q) use ($keyword) {
                $q->where('judul', 'ilike', "%{$keyword}%")
                ->orWhere('pengarang', 'ilike', "%{$keyword}%");
            })
            ->whereHas('paket', fn($q) => $q->aktif()->where('lokasi_id', $lokasiId))
            ->with('buku', 'paket.lokasi')
            ->limit(10)
            ->orderByDesc('stok')
            ->get();
    }

    public function bukuByLokasi(int $lokasiId): \Illuminate\Database\Eloquent\Collection
    {
        return BukuEksemplar::with('buku')
            ->whereHas('paket', fn($q) => $q->aktif()->where('lokasi_id', $lokasiId))
            ->tersedia()
            ->orderByDesc('stok')
            ->get();
    }

    public function simpan(array $data): Transaksi
    {
        return DB::transaction(function () use ($data) {
            $member              = $this->simpanAtauUpdateMember($data['member']);
            $isbnDiserahkan      = $data['buku_diserahkan']['isbn'] ?? null;
            $paketDiserahkanId   = $data['paket_diserahkan_id'];
            $paketDiterimaId     = $data['paket_diterima_id'];

            // --- Buku diserahkan (masuk ke paket diserahkan) ---
            $eksemplarDiserahkan = null;

            if ($isbnDiserahkan) {
                $eksemplarDiserahkan = BukuEksemplar::whereHas('buku', fn($q) => $q->where('isbn', $isbnDiserahkan))
                    ->where('paket_id', $paketDiserahkanId)
                    ->lockForUpdate()
                    ->first();
            }

            if ($eksemplarDiserahkan) {
                $eksemplarDiserahkan->tambahStok();
            } else {
                $buku = $isbnDiserahkan
                    ? Buku::firstOrCreate(
                        ['isbn' => $isbnDiserahkan],
                        [
                            'judul'         => $data['buku_diserahkan']['judul'],
                            'pengarang'     => $data['buku_diserahkan']['pengarang'],
                            'penerbit'      => $data['buku_diserahkan']['penerbit']      ?? null,
                            'tahun_terbit'  => $data['buku_diserahkan']['tahun_terbit']  ?? null,
                            'tempat_terbit' => $data['buku_diserahkan']['tempat_terbit'] ?? null,
                            'kategori'      => $data['buku_diserahkan']['kategori']      ?? null,
                            'deskripsi'     => $data['buku_diserahkan']['deskripsi']     ?? null,
                            'is_visible'    => false,
                            'user_id'       => $data['user_id'],
                        ]
                    )
                    : Buku::create([
                        'judul'         => $data['buku_diserahkan']['judul'],
                        'pengarang'     => $data['buku_diserahkan']['pengarang'],
                        'penerbit'      => $data['buku_diserahkan']['penerbit']      ?? null,
                        'tahun_terbit'  => $data['buku_diserahkan']['tahun_terbit']  ?? null,
                        'tempat_terbit' => $data['buku_diserahkan']['tempat_terbit'] ?? null,
                        'kategori'      => $data['buku_diserahkan']['kategori']      ?? null,
                        'deskripsi'     => $data['buku_diserahkan']['deskripsi']     ?? null,
                        'is_visible'    => false,
                        'user_id'       => $data['user_id'],
                    ]);

                $eksemplarDiserahkan = BukuEksemplar::create([
                    'buku_id'  => $buku->id,
                    'paket_id' => $paketDiserahkanId,
                    'stok'     => 1,
                ]);
            }

            $eksemplarDiterima = BukuEksemplar::with('paket')
                ->lockForUpdate()
                ->findOrFail($data['buku_diterima_id']);

            if ($eksemplarDiterima->stok < 1) {
                throw new \RuntimeException('Stok buku yang dipilih sudah habis.');
            }

            if (! $eksemplarDiterima->paket?->is_aktif) {
                throw new \RuntimeException('Paket buku yang dipilih tidak aktif.');
            }

            $eksemplarDiterima->kurangiStok();

            return Transaksi::create([
                'member_id'          => $member->id,
                'paket_id'           => $paketDiterimaId,
                'buku_diserahkan_id' => $eksemplarDiserahkan->id,
                'buku_diterima_id'   => $eksemplarDiterima->id,
                'user_id'            => $data['user_id'],
                'catatan_petugas'    => $data['catatan_petugas'] ?? null,
                'tanggal_tukar'      => now(),
            ]);
        });
    }

    public function update(int $id, array $data): Transaksi
    {
        return DB::transaction(function () use ($id, $data) {
            $transaksi = Transaksi::findOrFail($id);

            // Restore stok buku diterima lama sebelum diganti
            $eksemplarLama = BukuEksemplar::lockForUpdate()->findOrFail($transaksi->buku_diterima_id);
            $eksemplarLama->tambahStok();

            $eksemplarBaru = BukuEksemplar::with('paket')
                ->lockForUpdate()
                ->findOrFail($data['buku_diterima_id']);

            if ($eksemplarBaru->stok < 1) {
                throw new \RuntimeException('Stok buku yang dipilih sudah habis.');
            }

            if (! $eksemplarBaru->paket?->is_aktif) {
                throw new \RuntimeException('Paket buku yang dipilih tidak aktif.');
            }

            $eksemplarBaru->kurangiStok();

            $this->simpanAtauUpdateMember($data['member']);

            $transaksi->update([
                'buku_diterima_id' => $eksemplarBaru->id,
                'catatan_petugas'  => $data['catatan_petugas'] ?? null,
            ]);

            return $transaksi->fresh();
        });
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $transaksi = Transaksi::findOrFail($id);

            BukuEksemplar::lockForUpdate()->findOrFail($transaksi->buku_diterima_id)->tambahStok();

            $transaksi->delete();
        });
    }
}