<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiTukar;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiTukar::with(['member', 'bukuTukar', 'bukuPerpus'])
                        ->latest()
                        ->paginate(15);

        return view('admin.transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        $item = TransaksiTukar::with(['member', 'bukuTukar', 'bukuPerpus'])->findOrFail($id);
        return view('admin.transaksi-detail', compact('item'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        TransaksiTukar::findOrFail($id)->delete();
        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}