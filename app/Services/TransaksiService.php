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

    public function cariBukuByIsbn(string $isbn, ?int $paketId = null): ?BukuEksemplar
    {
        $query = BukuEksemplar::whereHas('buku', fn($q) => $q->where('isbn', $isbn))
            ->with('buku', 'paket.lokasi');

        if ($paketId) {
            $eksemplar = (clone $query)->where('paket_id', $paketId)->tersedia()->first();
            if ($eksemplar) return $eksemplar;

            return (clone $query)->where('paket_id', $paketId)->first();
        }

        return $query->diPaketAktif()->tersedia()->first()
            ?? $query->diPaketAktif()->first();
    }

    public function cariBukuByJudul(string $keyword, ?int $paketId = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = BukuEksemplar::whereHas('buku', function ($q) use ($keyword) {
                $q->where('judul', 'ilike', "%{$keyword}%")
                  ->orWhere('pengarang', 'ilike', "%{$keyword}%");
            })
            ->with('buku', 'paket.lokasi')
            ->diPaketAktif()
            ->limit(10);

        if ($paketId) {
            $query->where('paket_id', $paketId);
        }

        return $query->orderByDesc('stok')->get();
    }

    public function simpan(array $data): Transaksi
    {
        return DB::transaction(function () use ($data) {
            $member         = $this->simpanAtauUpdateMember($data['member']);
            $isbnDiserahkan = $data['buku_diserahkan']['isbn'] ?? null;
            $paketId        = $data['paket_id'];

            // Cari eksemplar buku diserahkan di paket aktif
            $eksemplarDiserahkan = null;
            if ($isbnDiserahkan) {
                $eksemplarDiserahkan = BukuEksemplar::whereHas('buku', fn($q) => $q->where('isbn', $isbnDiserahkan))
                    ->where('paket_id', $paketId)
                    ->first();
            }

            if ($eksemplarDiserahkan) {
                $eksemplarDiserahkan->tambahStok();
            } else {
                // Cari atau buat row di bukus (bibliografi)
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

                // Buat eksemplar baru di paket aktif
                $eksemplarDiserahkan = BukuEksemplar::create([
                    'buku_id'  => $buku->id,
                    'paket_id' => $paketId,
                    'stok'     => 1,
                ]);
            }

            $eksemplarDiterima = BukuEksemplar::tersedia()
                ->diPaketAktif()
                ->findOrFail($data['buku_diterima_id']);
            $eksemplarDiterima->kurangiStok();

            return Transaksi::create([
                'member_id'          => $member->id,
                'paket_id'           => $paketId,
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

            $transaksi->bukuDiterima->tambahStok();

            $eksemplarDiterima = BukuEksemplar::tersedia()
                ->diPaketAktif()
                ->findOrFail($data['buku_diterima_id']);
            $eksemplarDiterima->kurangiStok();

            $this->simpanAtauUpdateMember($data['member']);

            $transaksi->update([
                'buku_diterima_id' => $eksemplarDiterima->id,
                'catatan_petugas'  => $data['catatan_petugas'] ?? null,
            ]);

            return $transaksi->fresh();
        });
    }

    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $transaksi = Transaksi::findOrFail($id);
            $transaksi->bukuDiterima->tambahStok();
            $transaksi->delete();
        });
    }
}