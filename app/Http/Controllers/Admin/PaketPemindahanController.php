<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use App\Models\PaketPemindahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaketPemindahanController extends Controller
{
    public function index(int $paketId)
    {
        $paket   = Paket::with('lokasi')->findOrFail($paketId);
        $riwayat = PaketPemindahan::with(['lokasiAsal', 'lokasiTujuan', 'user'])
            ->where('paket_id', $paketId)
            ->latest('dipindah_pada')
            ->paginate(10);

        return response()->json([
            'paket'   => $paket,
            'riwayat' => $riwayat,
        ]);
    }

    public function store(Request $request, int $paketId): \Illuminate\Http\RedirectResponse
    {
        $paket = Paket::findOrFail($paketId);

        $validated = $request->validate([
            'lokasi_tujuan_id' => 'required|exists:lokasis,id',
            'catatan'          => 'nullable|string|max:500',
        ], [
            'lokasi_tujuan_id.required' => 'Lokasi tujuan wajib dipilih.',
        ]);

        if ($validated['lokasi_tujuan_id'] == $paket->lokasi_id) {
            return redirect()->back()->withErrors([
                'lokasi_tujuan_id' => 'Lokasi tujuan tidak boleh sama dengan lokasi saat ini.',
            ]);
        }

        DB::transaction(function () use ($paket, $validated) {
            PaketPemindahan::create([
                'paket_id'         => $paket->id,
                'lokasi_asal_id'   => $paket->lokasi_id,
                'lokasi_tujuan_id' => $validated['lokasi_tujuan_id'],
                'catatan'          => $validated['catatan'] ?? null,
                'user_id'          => Auth::id(),
                'dipindah_pada'    => now(),
            ]);

            $paket->update(['lokasi_id' => $validated['lokasi_tujuan_id']]);
        });

        $namaLokasi = $paket->fresh()->lokasi?->nama_lokasi ?? 'lokasi baru';

        return redirect()->route('admin.paket.index')
            ->with('success', "Paket \"{$paket->nama}\" berhasil dipindahkan ke {$namaLokasi}.");
    }
}