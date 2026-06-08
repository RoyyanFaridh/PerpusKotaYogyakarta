<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BukuEksemplar;
use App\Models\Paket;
use Illuminate\Http\Request;
use App\Models\PaketPemindahan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::with('lokasi')
            ->withCount('eksemplars')
            ->withSum('eksemplars', 'stok')
            ->orderBy('nama')
            ->paginate(20);

        $stats = [
            'total'       => Paket::count(),
            'aktif'       => Paket::where('is_aktif', true)->count(),
            'total_stok'  => BukuEksemplar::sum('stok'),
        ];

        return view('admin.paket.index', compact('pakets', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255|unique:pakets,nama',
            'lokasi_id' => 'nullable|exists:lokasis,id',
        ]);

        $paket = Paket::create([
            'nama'      => $request->nama,
            'lokasi_id' => $request->lokasi_id ?: null,
        ]);

        if ($request->expectsJson()) {
            return response()->json($paket, 201);
        }

        return redirect()->back()->with('success', 'Paket berhasil ditambahkan.');
    }

    public function update(Request $request, int $id)
    {
        $paket = Paket::findOrFail($id);

        $request->validate([
            'nama'      => 'required|string|max:255|unique:pakets,nama,' . $id,
            'lokasi_id' => 'nullable|exists:lokasis,id',
        ]);

        $lokasiIdBaru = $request->lokasi_id ?: null;
        $lokasiIdLama = $paket->lokasi_id;

        DB::transaction(function () use ($paket, $request, $lokasiIdBaru, $lokasiIdLama) {
            $paket->update([
                'nama'      => $request->nama,
                'lokasi_id' => $lokasiIdBaru,
            ]);

            if ((int) $lokasiIdBaru !== (int) $lokasiIdLama && $lokasiIdBaru !== null) {
                PaketPemindahan::create([
                    'paket_id'         => $paket->id,
                    'lokasi_asal_id'   => $lokasiIdLama,
                    'lokasi_tujuan_id' => $lokasiIdBaru,
                    'catatan'          => 'Diubah via edit paket.',
                    'user_id'          => Auth::id(),
                    'dipindah_pada'    => now(),
                ]);
            }
        });

        return redirect()->back()->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $paket = Paket::withCount('eksemplars')->findOrFail($id);

        if ($paket->eksemplars_count > 0) {
            return redirect()->back()
                ->with('error', 'Paket tidak bisa dihapus karena masih memiliki buku.');
        }

        $paket->delete();

        return redirect()->back()->with('success', 'Paket berhasil dihapus.');
    }

    public function aktifkan(Request $request, int $id)
    {
        $request->validate([
            'lokasi_id' => 'required|exists:lokasis,id',
        ]);

        $paket = Paket::findOrFail($id);
        $paket->update([
            'is_aktif'  => true,
            'lokasi_id' => $request->lokasi_id,
        ]);

        return redirect()->back()->with('success', "Paket \"{$paket->nama}\" diaktifkan.");
    }

    public function nonaktifkan(int $id)
    {
        $paket = Paket::findOrFail($id);
        $paket->nonaktifkan();

        return redirect()->back()->with('success', "Paket \"{$paket->nama}\" dinonaktifkan.");
    }
}