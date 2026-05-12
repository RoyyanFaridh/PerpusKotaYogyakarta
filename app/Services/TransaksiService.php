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
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('no_telp', 'like', "%{$keyword}%");
            })
            ->limit(5)
            ->get(['id', 'nama', 'no_telp', 'alamat', 'email']);
    }

    public function simpanAtauUpdateMember(array $data): Member
    {
        if (!empty($data['id'])) {
            $member = Member::findOrFail($data['id']);
            $member->update(collect($data)->except('id')->toArray());
            return $member->fresh();
        }

        return Member::create($data);
    }

    public function cariBukuByIsbn(string $isbn): ?Buku
    {
        if (blank($isbn)) return null;

        // ambil semua buku dengan isbn ini, kembalikan yang stok > 0 dulu
        return Buku::where('isbn', $isbn)
            ->where('stok', '>', 0)
            ->with('lokasi')
            ->first()
            ?? Buku::where('isbn', $isbn)->with('lokasi')->first();
    }

    public function cariBukuByJudul(string $keyword): \Illuminate\Database\Eloquent\Collection
    {
        return Buku::where(function ($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                ->orWhere('pengarang', 'like', "%{$keyword}%");
            })
            ->where('stok', '>', 0) 
            ->with('lokasi')
            ->limit(10)
            ->get(['id', 'judul', 'pengarang', 'isbn', 'stok', 'lokasi_id']);
    }

    public function simpan(array $data): Transaksi
    {
        return DB::transaction(function () use ($data) {

            // 1. Simpan/update member
            $member = $this->simpanAtauUpdateMember($data['member']);

            // 2. Simpan buku yang diserahkan member (sumber: tukar)
            $isbnDiserahkan = $data['buku_diserahkan']['isbn'] ?? null;
            $lokasiId       = $data['lokasi_id'];

            // cek apakah sudah ada buku dengan isbn + lokasi yang sama
            $bukuDiserahkan = null;
            if ($isbnDiserahkan) {
                $bukuDiserahkan = Buku::where('isbn', $isbnDiserahkan)
                    ->where('lokasi_id', $lokasiId)
                    ->first();
            }

            if ($bukuDiserahkan) {
                // sudah ada di lokasi ini, tambah stok saja
                $bukuDiserahkan->tambahStok();
            } else {
                // buat row baru (isbn baru, atau isbn sama tapi lokasi berbeda)
                $bukuDiserahkan = Buku::create([
                    'judul'      => $data['buku_diserahkan']['judul'],
                    'pengarang'  => $data['buku_diserahkan']['pengarang'],
                    'penerbit'   => $data['buku_diserahkan']['penerbit']  ?? null,
                    'isbn'       => $isbnDiserahkan,
                    'kategori'   => $data['buku_diserahkan']['kategori']  ?? null,
                    'kondisi'    => $data['buku_diserahkan']['kondisi'],
                    'deskripsi'  => $data['buku_diserahkan']['deskripsi'] ?? null,
                    'sumber'     => 'tukar',
                    'stok'       => 1, // langsung 1, tidak perlu tambahStok()
                    'member_id'  => $member->id,
                    'user_id'    => $data['user_id'],
                    'lokasi_id'  => $lokasiId,
                ]);
            }

            // 3. Kurangi stok buku yang diberikan ke member
            // tidak perlu update lokasi_id — lokasi buku perpus tidak berubah
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

            return $transaksi;
        });
    }

    public function update(int $id, array $data): Transaksi
    {
        return DB::transaction(function () use ($id, $data) {
            $transaksi = Transaksi::findOrFail($id);

            // kembalikan stok buku diterima lama
            $transaksi->bukuDiterima->tambahStok();

            // kurangi stok buku diterima baru
            $bukuDiterima = Buku::findOrFail($data['buku_diterima_id']);
            $bukuDiterima->kurangiStok();

            // update member
            $this->simpanAtauUpdateMember($data['member']);

            // update transaksi — tidak ada lokasi_id di tabel transaksis
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

            // kembalikan stok buku diterima (buku perpus kembali +1)
            $transaksi->bukuDiterima->tambahStok();

            // buku diserahkan (dari member) TIDAK dikurangi stoknya
            // karena buku itu tetap ada di koleksi perpustakaan

            $transaksi->delete();
        });
    }
}