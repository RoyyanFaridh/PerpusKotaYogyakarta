<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
// use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['member', 'bukuDiserahkan', 'bukuDiterima'])
                        ->latest()
                        ->paginate(15);

        return view('admin.transaksi.index', compact('transaksi'));
    }

    public function show(string $id)
    {
        $item = Transaksi::with(['member', 'bukuDiserahkan', 'bukuDiterima'])->findOrFail($id);
        return view('admin.transaksi-detail', compact('item'));
    }

    public function destroy(string $id)
    {
        Transaksi::findOrFail($id)->delete();
        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}