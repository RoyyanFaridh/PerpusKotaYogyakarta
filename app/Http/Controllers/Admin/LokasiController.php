<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LokasiController extends Controller
{
    public function index(Request $request): View
    {
        $lokasis = Lokasi::with(['adminAktif.user'])
            ->when($request->search, function ($query, $search) {
                $query->where('nama_lokasi', 'like', "%{$search}%")
                      ->orWhere('alamat', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15);

        return view('admin.lokasi.index', compact('lokasis'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_lokasi'      => ['required', 'string', 'max:255'],
            'alamat'           => ['required', 'string'],
            'no_telp'          => ['nullable', 'string', 'max:20'],
            'tampil_di_search' => ['boolean'],
            'aktif'            => ['boolean'],
        ], [
            'nama_lokasi.required' => 'Nama lokasi wajib diisi.',
            'alamat.required'      => 'Alamat wajib diisi.',
            'no_telp.max'          => 'Nomor telepon maksimal 20 karakter.',
        ]);

        Lokasi::create($validated);

        return redirect()->route('admin.lokasi.index')
                         ->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function update(Request $request, Lokasi $lokasi): RedirectResponse
    {
        $validated = $request->validate([
            'nama_lokasi'      => ['required', 'string', 'max:255'],
            'alamat'           => ['required', 'string'],
            'no_telp'          => ['nullable', 'string', 'max:20'],
            'tampil_di_search' => ['boolean'],
            'aktif'            => ['boolean'],
        ], [
            'nama_lokasi.required' => 'Nama lokasi wajib diisi.',
            'alamat.required'      => 'Alamat wajib diisi.',
            'no_telp.max'          => 'Nomor telepon maksimal 20 karakter.',
        ]);

        $lokasi->update($validated);

        return redirect()->route('admin.lokasi.index')
                         ->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Lokasi $lokasi): RedirectResponse
    {
        if ($lokasi->pakets()->exists()) {
            return back()->with('error', 'Lokasi tidak bisa dihapus karena masih memiliki paket.');
        }

        $lokasi->delete();

        return redirect()->route('admin.lokasi.index')
                         ->with('success', 'Lokasi berhasil dihapus.');
    }
}