<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\BukuEksemplar;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BukuEksemplarController extends Controller
{
    use AuthorizesRequests;

    public function index(int $bukuId): JsonResponse
    {
        $buku = Buku::findOrFail($bukuId);

        $eksemplars = BukuEksemplar::where('buku_id', $bukuId)
            ->with('paket.lokasi')
            ->get();

        return response()->json([
            'success'    => true,
            'buku'       => ['id' => $buku->id, 'judul' => $buku->judul],
            'eksemplars' => $eksemplars,
        ]);
    }

    public function store(Request $request, int $bukuId): JsonResponse
    {
        $this->authorize('create', BukuEksemplar::class);

        Buku::findOrFail($bukuId);

        $validated = $request->validate([
            'paket_id' => 'required|exists:pakets,id',
            'stok'     => 'required|integer|min:1',
        ]);

        $eksemplar = BukuEksemplar::where('buku_id', $bukuId)
            ->where('paket_id', $validated['paket_id'])
            ->first();

        if ($eksemplar) {
            $eksemplar->increment('stok', $validated['stok']);
            $eksemplar->refresh();
            $statusCode = 200;
        } else {
            $eksemplar = BukuEksemplar::create([
                'buku_id'  => $bukuId,
                'paket_id' => $validated['paket_id'],
                'stok'     => $validated['stok'],
            ]);
            $statusCode = 201;
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Eksemplar berhasil ditambahkan.',
            'eksemplar' => $eksemplar->load('paket.lokasi'),
        ], $statusCode);
    }

    public function update(Request $request, int $bukuId, int $eksemplarId): JsonResponse
    {
        $this->authorize('update', BukuEksemplar::class);

        $eksemplar = BukuEksemplar::where('buku_id', $bukuId)
            ->findOrFail($eksemplarId);

        $validated = $request->validate([
            'stok' => 'required|integer|min:0',
        ]);

        $eksemplar->update($validated);

        return response()->json([
            'success'   => true,
            'message'   => 'Eksemplar berhasil diperbarui.',
            'eksemplar' => $eksemplar->load('paket.lokasi'),
        ]);
    }

    public function destroy(int $bukuId, int $eksemplarId): JsonResponse
    {
        $this->authorize('delete', BukuEksemplar::class);

        $eksemplar = BukuEksemplar::where('buku_id', $bukuId)
            ->findOrFail($eksemplarId);

        if ($eksemplar->transaksiMasuk()->exists() || $eksemplar->transaksiKeluar()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Eksemplar tidak bisa dihapus karena terlibat dalam transaksi.',
            ], 422);
        }

        $eksemplar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Eksemplar berhasil dihapus.',
        ]);
    }
}