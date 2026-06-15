<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BukuEksemplar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BukuRelokasiController extends Controller
{
    public function relokasi(Request $request, int $bukuId): JsonResponse
    {
        $validated = $request->validate([
            'eksemplar_id' => 'required|integer|exists:buku_eksemplars,id',
            'paket_tujuan' => 'required|integer|exists:pakets,id',
            'jumlah'       => 'required|integer|min:1',
        ]);

        $sumber = BukuEksemplar::where('buku_id', $bukuId)
            ->findOrFail($validated['eksemplar_id']);

        if ($sumber->paket_id === $validated['paket_tujuan']) {
            return response()->json([
                'success' => false,
                'message' => 'Paket tujuan tidak boleh sama dengan paket sumber.',
            ], 422);
        }

        if ($sumber->stok < $validated['jumlah']) {
            return response()->json([
                'success' => false,
                'message' => "Stok tidak mencukupi. Stok saat ini: {$sumber->stok}.",
            ], 422);
        }

        $sumber->decrement('stok', $validated['jumlah']);

        $tujuan = BukuEksemplar::where('buku_id', $bukuId)
            ->where('paket_id', $validated['paket_tujuan'])
            ->first();

        if ($tujuan) {
            $tujuan->increment('stok', $validated['jumlah']);
            $tujuan->refresh();
        } else {
            $tujuan = BukuEksemplar::create([
                'buku_id'  => $bukuId,
                'paket_id' => $validated['paket_tujuan'],
                'stok'     => $validated['jumlah'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "{$validated['jumlah']} eksemplar berhasil dipindahkan.",
            'sumber'  => $sumber->refresh()->load('paket.lokasi'),
            'tujuan'  => $tujuan->load('paket.lokasi'),
        ]);
    }
}