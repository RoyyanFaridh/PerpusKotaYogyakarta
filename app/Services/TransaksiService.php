<?php

namespace App\Services;

use App\Models\Buku;
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

    public function cariBukuByIsbn(string $isbn, ?int $lokasiId = null): ?Buku
    {
        $query = Buku::where('isbn', $isbn)->visible()->with('lokasi');

        if ($lokasiId) {
            $buku = (clone $query)->where('lokasi_id', $lokasiId)->tersedia()->first();
            if ($buku) return $buku;

            $buku = (clone $query)->where('lokasi_id', $lokasiId)->first();
            if ($buku) return $buku;

            return null;
        }

        return $query->tersedia()->first() ?? $query->first();
    }

    public function cariBukuByJudul(string $keyword, ?int $lokasiId = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = Buku::where(function ($q) use ($keyword) {
                $q->where('judul', 'ilike', "%{$keyword}%")
                  ->orWhere('pengarang', 'ilike', "%{$keyword}%");
            })
            ->visible()
            ->with('lokasi')
            ->limit(10)
            ->select(['id', 'judul', 'pengarang', 'isbn', 'stok', 'lokasi_id', 'paket_id']);

        if ($lokasiId) {
            $query->where('lokasi_id', $lokasiId);
        }

        return $query->orderByDesc('stok')->get();
    }

    public function simpan(array $data): Transaksi
    {
        return DB::transaction(function () use ($data) {
            $member         = $this->simpanAtauUpdateMember($data['member']);
            $isbnDiserahkan = $data['buku_diserahkan']['isbn'] ?? null;
            $lokasiId       = $data['lokasi_id'];

            $bukuDiserahkan = null;
            if ($isbnDiserahkan) {
                $bukuDiserahkan = Buku::where('isbn', $isbnDiserahkan)
                    ->where('lokasi_id', $lokasiId)
                    ->first();
            }

            if ($bukuDiserahkan) {
                $bukuDiserahkan->tambahStok();
            } else {
                // Buku donasi masuk dengan is_visible = false
                // Admin yang akan decide: tampilkan langsung atau masukkan paket
                $bukuDiserahkan = Buku::create([
                    'judul'         => $data['buku_diserahkan']['judul'],
                    'pengarang'     => $data['buku_diserahkan']['pengarang'],
                    'penerbit'      => $data['buku_diserahkan']['penerbit']      ?? null,
                    'isbn'          => $isbnDiserahkan,
                    'tahun_terbit'  => $data['buku_diserahkan']['tahun_terbit']  ?? null,
                    'tempat_terbit' => $data['buku_diserahkan']['tempat_terbit'] ?? null,
                    'kategori'      => $data['buku_diserahkan']['kategori']      ?? null,
                    'deskripsi'     => $data['buku_diserahkan']['deskripsi']     ?? null,
                    'stok'          => 1,
                    'is_visible'    => false,
                    'paket_id'      => null,
                    'member_id'     => $member->id,
                    'user_id'       => $data['user_id'],
                    'lokasi_id'     => $lokasiId,
                ]);
            }

            $bukuDiterima = Buku::visible()->tersedia()->findOrFail($data['buku_diterima_id']);
            $bukuDiterima->kurangiStok();

            return Transaksi::create([
                'member_id'          => $member->id,
                'buku_diserahkan_id' => $bukuDiserahkan->id,
                'buku_diterima_id'   => $bukuDiterima->id,
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

            // Pastikan buku pengganti juga visible dan tersedia
            $bukuDiterima = Buku::visible()->tersedia()->findOrFail($data['buku_diterima_id']);
            $bukuDiterima->kurangiStok();

            $this->simpanAtauUpdateMember($data['member']);

            $transaksi->update([
                'buku_diterima_id' => $bukuDiterima->id,
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