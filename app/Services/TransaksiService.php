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
        return Member::where('nama', 'like', "%{$keyword}%")
            ->orWhere('no_telp', 'like', "%{$keyword}%")
            ->limit(5)
            ->get(['id', 'nama', 'no_telp', 'alamat', 'email']);
    }

    public function simpanAtauUpdateMember(array $data): Member
    {
        if (!empty($data['id'])) {
            $member = Member::findOrFail($data['id']);
            $member->update($data);
            return $member->fresh();
        }

        return Member::create($data);
    }

    public function cariBukuByIsbn(string $isbn): ?Buku
    {
        return Buku::where('isbn', $isbn)->first();
    }

    public function simpan(array $data): Transaksi
    {
        return DB::transaction(function () use ($data) {

            // 1. Simpan/update member
            $member = $this->simpanAtauUpdateMember($data['member']);

            // 2. Simpan buku yang diserahkan member (sumber: tukar, stok: 0 dulu)
            $bukuDiserahkan = Buku::create([
                'judul'      => $data['buku_diserahkan']['judul'],
                'pengarang'  => $data['buku_diserahkan']['pengarang'],
                'penerbit'   => $data['buku_diserahkan']['penerbit']   ?? null,
                'isbn'       => $data['buku_diserahkan']['isbn']        ?? null,
                'kategori'   => $data['buku_diserahkan']['kategori']   ?? null,
                'kondisi'    => $data['buku_diserahkan']['kondisi'],
                'deskripsi'  => $data['buku_diserahkan']['deskripsi']  ?? null,
                'sumber'     => 'tukar',
                'stok'       => 0,
                'member_id'  => $member->id,
                'user_id'    => $data['user_id'],
            ]);

            // 3. Kurangi stok buku yang diberikan ke member
            $bukuDiterima = Buku::findOrFail($data['buku_diterima_id']);
            $bukuDiterima->kurangiStok();

            // 4. Simpan transaksi
            $transaksi = Transaksi::create([
                'member_id'          => $member->id,
                'buku_diserahkan_id' => $bukuDiserahkan->id,
                'buku_diterima_id'   => $bukuDiterima->id,
                'user_id'            => $data['user_id'],
                'catatan_petugas'    => $data['catatan_petugas'] ?? null,
                'tanggal_tukar'      => now(),
            ]);

            // 5. Opsi B: stok buku diserahkan +1 setelah transaksi selesai
            $bukuDiserahkan->tambahStok();

            return $transaksi;
        });
    }

    public function update(int $id, array $data): Transaksi
    {
        return DB::transaction(function () use ($id, $data) {
            $transaksi = Transaksi::findOrFail($id);

            // Kembalikan stok buku diterima lama
            $transaksi->bukuDiterima->tambahStok();

            // Kurangi stok buku diterima baru
            $bukuDiterima = Buku::findOrFail($data['buku_diterima_id']);
            $bukuDiterima->kurangiStok();

            // Update member
            $this->simpanAtauUpdateMember($data['member']);

            // Update transaksi
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

            // Kembalikan stok buku diterima
            $transaksi->bukuDiterima->tambahStok();

            // Kurangi stok buku diserahkan (hapus dari koleksi)
            $transaksi->bukuDiserahkan->kurangiStok();

            $transaksi->delete();
        });
    }
}