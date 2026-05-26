<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BukuRelokasiController extends Controller
{
    /**
     * Tampilkan daftar buku yang bisa direlokasi dari suatu lokasi asal.
     * GET /admin/buku/relokasi?lokasi_id=1
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'lokasi_id' => 'required|exists:lokasis,id',
        ]);

        $buku = Buku::with('lokasi')
            ->where('lokasi_id', $request->lokasi_id)
            ->where('stok', '>', 0)
            ->orderBy('judul')
            ->get(['id', 'judul', 'pengarang', 'isbn', 'stok', 'kategori', 'lokasi_id']);

        return response()->json($buku);
    }

    /**
     * Proses relokasi buku (bulk).
     *
     * Payload yang diharapkan:
     * {
     *   "lokasi_tujuan_id": 2,
     *   "items": [
     *     { "buku_id": 10, "jumlah": 3 },
     *     { "buku_id": 11, "jumlah": 1 }
     *   ]
     * }
     *
     * POST /admin/buku/relokasi
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'lokasi_tujuan_id'        => 'required|exists:lokasis,id',
            'items'                   => 'required|array|min:1',
            'items.*.buku_id'         => 'required|exists:bukus,id',
            'items.*.jumlah'          => 'required|integer|min:1',
        ]);

        $lokasiTujuanId = $validated['lokasi_tujuan_id'];
        $items          = $validated['items'];

        // Kumpulkan semua buku asal sekaligus (N+1 prevention)
        $bukuIds  = collect($items)->pluck('buku_id')->unique();
        $bukuAsal = Buku::whereIn('id', $bukuIds)->get()->keyBy('id');

        // --- Validasi awal sebelum menyentuh DB ---
        $errors = [];

        foreach ($items as $i => $item) {
            $buku = $bukuAsal->get($item['buku_id']);

            if (! $buku) {
                $errors["items.{$i}.buku_id"] = ["Buku tidak ditemukan."];
                continue;
            }

            if ($buku->lokasi_id === $lokasiTujuanId) {
                $errors["items.{$i}.buku_id"] = [
                    "Buku \"{$buku->judul}\" sudah berada di lokasi tujuan.",
                ];
            }

            if ($item['jumlah'] > $buku->stok) {
                $errors["items.{$i}.jumlah"] = [
                    "Jumlah melebihi stok tersedia ({$buku->stok}) untuk buku \"{$buku->judul}\".",
                ];
            }
        }

        if (! empty($errors)) {
            throw ValidationException::withMessages($errors);
        }

        // --- Proses relokasi dalam satu transaksi DB ---
        $dipindahkan = DB::transaction(function () use ($items, $bukuAsal, $lokasiTujuanId) {
            $hasil = [];

            foreach ($items as $item) {
                $asal   = $bukuAsal->get($item['buku_id']);
                $jumlah = $item['jumlah'];

                // 1. Kurangi stok di lokasi asal
                $asal->decrement('stok', $jumlah);

                // Refresh karena decrement tidak update instance
                $asal->refresh();

                // 2. Hapus row asal kalau stok sudah 0
                if ($asal->stok === 0) {
                    $asal->delete();
                }

                // 3. Cari apakah buku dengan ISBN yang sama sudah ada di lokasi tujuan
                //    Fallback ke judul+pengarang kalau ISBN kosong (data lama/buku tukar)
                $tujuan = $this->cariBukuDiLokasi($asal, $lokasiTujuanId);

                if ($tujuan) {
                    // Sudah ada — tambah stok
                    $tujuan->increment('stok', $jumlah);
                } else {
                    // Belum ada — buat row baru dengan data dari buku asal
                    $tujuan = Buku::create([
                        'judul'          => $asal->judul,
                        'pengarang'      => $asal->pengarang,
                        'penerbit'       => $asal->penerbit,
                        'isbn'           => $asal->isbn,
                        'tahun_terbit'   => $asal->tahun_terbit,
                        'tempat_terbit'  => $asal->tempat_terbit,
                        'resume'         => $asal->resume,
                        'kategori'       => $asal->kategori,
                        'sumber'         => $asal->sumber,
                        'kondisi'        => $asal->kondisi,
                        'deskripsi'      => $asal->deskripsi,
                        'stok'           => $jumlah,
                        'lokasi_id'      => $lokasiTujuanId,
                        'user_id'        => $asal->user_id,
                        // member_id tidak diikutkan — relokasi bukan transaksi tukar
                    ]);
                }

                $hasil[] = [
                    'judul'          => $asal->judul,
                    'jumlah'         => $jumlah,
                    'lokasi_tujuan'  => $tujuan->lokasi?->nama_lokasi ?? '-',
                ];
            }

            return $hasil;
        });

        return response()->json([
            'success' => true,
            'message' => count($dipindahkan) . ' buku berhasil direlokasi.',
            'data'    => $dipindahkan,
        ]);
    }

    /**
     * Cari row buku di lokasi tujuan.
     * Prioritas: ISBN (kalau ada) → judul + pengarang (fallback).
     */
    private function cariBukuDiLokasi(Buku $asal, int $lokasiTujuanId): ?Buku
    {
        $query = Buku::where('lokasi_id', $lokasiTujuanId);

        if (! empty($asal->isbn)) {
            return $query->where('isbn', $asal->isbn)->first();
        }

        // Fallback untuk buku tanpa ISBN (umumnya buku tukar)
        return $query
            ->where('judul',     $asal->judul)
            ->where('pengarang', $asal->pengarang)
            ->first();
    }
}