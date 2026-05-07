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
            ->get();
    }

    public function simpanMember(array $data): Member
    {
        return Member::create($data);
    }

    public function cariBukuByIsbn(string $isbn): ?Buku
    {
        return Buku::where('isbn', $isbn)->first();
    }

    public function simpan(array $data): Transaksi
    {
        return DB::transaction(function () use ($data) {

            $bukuDiserahkan = Buku::create([
                'judul'      => $data['buku_diserahkan']['judul'],
                'pengarang'  => $data['buku_diserahkan']['pengarang'],
                'penerbit'   => $data['buku_diserahkan']['penerbit'] ?? null,
                'isbn'       => $data['buku_diserahkan']['isbn'] ?? null,
                'kondisi'    => $data['buku_diserahkan']['kondisi'],
                'deskripsi'  => $data['buku_diserahkan']['deskripsi'] ?? null,
                'kategori'   => $data['buku_diserahkan']['kategori'] ?? null,
                'sumber'     => 'tukar',
                'stok'       => 0,
                'member_id'  => $data['member_id'],
                'user_id'    => $data['user_id'],
            ]);

            $bukuDiterima = Buku::findOrFail($data['buku_diterima_id']);
            $bukuDiterima->kurangiStok();

            // 3. Simpan transaksi
            $transaksi = Transaksi::create([
                'member_id'          => $data['member_id'],
                'buku_diserahkan_id' => $bukuDiserahkan->id,
                'buku_diterima_id'   => $bukuDiterima->id,
                'user_id'            => $data['user_id'],
                'status'             => 'disetujui',
                'catatan_petugas'    => $data['catatan_petugas'] ?? null,
                'tanggal_tukar'      => now(),
            ]);

            $bukuDiserahkan->tambahStok();

            return $transaksi;
        });
    }
}