<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::withCount('bukus')
                       ->withSum('bukus', 'stok')
                       ->orderBy('nama')
                       ->paginate(20);

        $stats = [
            'total'      => Paket::count(),
            'aktif'      => Paket::where('is_aktif', true)->count(),
            'total_buku' => \App\Models\Buku::whereNotNull('paket_id')->count(),
        ];

        return view('admin.paket.index', compact('pakets', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:pakets,nama',
        ]);

        $paket = Paket::create(['nama' => $request->nama]);

        if ($request->expectsJson()) {
            return response()->json($paket, 201);
        }

        return redirect()->back()->with('success', 'Paket berhasil ditambahkan.');
    }

    public function update(Request $request, int $id)
    {
        $paket = Paket::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255|unique:pakets,nama,' . $id,
        ]);

        $paket->update(['nama' => $request->nama]);

        return redirect()->back()->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $paket = Paket::withCount('bukus')->findOrFail($id);

        if ($paket->bukus_count > 0) {
            return redirect()->back()->with('error', 'Paket tidak bisa dihapus karena masih memiliki buku.');
        }

        $paket->delete();

        return redirect()->back()->with('success', 'Paket berhasil dihapus.');
    }

    public function aktifkan(int $id)
    {
        $paket = Paket::findOrFail($id);
        $paket->aktivasi();

        return redirect()->back()->with('success', "Paket \"{$paket->nama}\" diaktifkan.");
    }

    public function nonaktifkan(int $id)
    {
        $paket = Paket::findOrFail($id);
        $paket->nonaktifkan();

        return redirect()->back()->with('success', "Paket \"{$paket->nama}\" dinonaktifkan.");
    }
}