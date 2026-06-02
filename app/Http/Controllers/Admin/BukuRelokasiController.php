<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Lokasi;
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
            ->get(['id', 'judul', 'pengarang', 'isbn', 'stok', 'kategori', 'lokasi_id', 'paket_id']);

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
            'lokasi_tujuan_id'    => 'required|exists:lokasis,id',
            'items'               => 'required|array|min:1',
            'items.*.buku_id'     => 'required|exists:bukus,id',
            'items.*.jumlah'      => 'required|integer|min:1',
        ]);

        $lokasiTujuanId = $validated['lokasi_tujuan_id'];
        $items          = $validated['items'];
        $lokasiTujuan   = Lokasi::findOrFail($lokasiTujuanId);

        $bukuIds  = collect($items)->pluck('buku_id')->unique();
        $bukuAsal = Buku::whereIn('id', $bukuIds)->get()->keyBy('id');

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

        $dipindahkan = DB::transaction(function () use ($items, $bukuAsal, $lokasiTujuanId, $lokasiTujuan) {
            $hasil = [];

            foreach ($items as $item) {
                $asal   = $bukuAsal->get($item['buku_id']);
                $jumlah = $item['jumlah'];

                $asal->decrement('stok', $jumlah);
                $asal->refresh();

                if ($asal->stok === 0) {
                    $asal->delete();
                }

                $tujuan = $this->cariBukuDiLokasi($asal, $lokasiTujuanId);

                if ($tujuan) {
                    $tujuan->increment('stok', $jumlah);
                } else {
                    // Ketika relokasi ke bank_buku, is_visible otomatis false
                    $isVisible = ! $lokasiTujuan->isBankBuku();

                    $tujuan = Buku::create([
                        'judul'         => $asal->judul,
                        'pengarang'     => $asal->pengarang,
                        'penerbit'      => $asal->penerbit,
                        'isbn'          => $asal->isbn,
                        'tahun_terbit'  => $asal->tahun_terbit,
                        'tempat_terbit' => $asal->tempat_terbit,
                        'resume'        => $asal->resume,
                        'kategori'      => $asal->kategori,
                        'deskripsi'     => $asal->deskripsi,
                        'stok'          => $jumlah,
                        'is_visible'    => $isVisible,
                        'paket_id'      => $asal->paket_id,
                        'lokasi_id'     => $lokasiTujuanId,
                        'user_id'       => $asal->user_id,
                    ]);
                }

                $hasil[] = [
                    'judul'         => $asal->judul,
                    'jumlah'        => $jumlah,
                    'lokasi_tujuan' => $tujuan->lokasi?->nama_lokasi ?? '-',
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

    private function cariBukuDiLokasi(Buku $asal, int $lokasiTujuanId): ?Buku
    {
        $query = Buku::where('lokasi_id', $lokasiTujuanId);

        if (! empty($asal->isbn)) {
            return $query->where('isbn', $asal->isbn)->first();
        }

        return $query
            ->where('judul', $asal->judul)
            ->where('pengarang', $asal->pengarang)
            ->first();
    }
}