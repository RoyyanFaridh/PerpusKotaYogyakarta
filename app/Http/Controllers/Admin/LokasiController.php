<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Models\User;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index(Request $request)
    {
        $lokasis = Lokasi::with('user')
            ->when($request->search, function ($query, $search) {
                $query->where('nama_lokasi', 'like', "%{$search}%")
                      ->orWhere('alamat', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15);

        $users = User::orderBy('nama')->get();

        return view('admin.lokasi.index', compact('lokasis', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lokasi'      => ['required', 'string', 'max:255'],
            'alamat'           => ['nullable', 'string'],
            'no_telp'          => ['nullable', 'string', 'max:20'],
            'user_id'          => ['required', 'exists:users,id'],
            'tampil_di_search' => ['boolean'],
            'aktif'            => ['boolean'],
        ], [
            'nama_lokasi.required' => 'Nama lokasi wajib diisi.',
            'no_telp.max'          => 'Nomor telepon maksimal 20 karakter.',
            'user_id.required'     => 'Penanggung jawab wajib dipilih.',
            'user_id.exists'       => 'User tidak ditemukan.',
        ]);

        Lokasi::create($validated);

        return redirect()->route('admin.lokasi.index')
                         ->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function edit(Lokasi $lokasi)
    {
        $users = User::orderBy('nama')->get();
        return view('admin.lokasi.edit', compact('lokasi', 'users'));
    }

    public function update(Request $request, Lokasi $lokasi)
    {
        $validated = $request->validate([
            'nama_lokasi'      => ['required', 'string', 'max:255'],
            'alamat'           => ['nullable', 'string'],
            'no_telp'          => ['nullable', 'string', 'max:20'],
            'user_id'          => ['required', 'exists:users,id'],
            'tampil_di_search' => ['boolean'],
            'aktif'            => ['boolean'],
        ], [
            'nama_lokasi.required' => 'Nama lokasi wajib diisi.',
            'no_telp.max'          => 'Nomor telepon maksimal 20 karakter.',
            'user_id.required'     => 'Penanggung jawab wajib dipilih.',
            'user_id.exists'       => 'User tidak ditemukan.',
        ]);

        $lokasi->update($validated);

        return redirect()->route('admin.lokasi.index')
                         ->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Lokasi $lokasi)
    {
        if ($lokasi->pakets()->exists()) {
            return redirect()->back()
                ->with('error', 'Lokasi tidak bisa dihapus karena masih memiliki paket.');
        }

        $lokasi->delete();

        return redirect()->route('admin.lokasi.index')
                         ->with('success', 'Lokasi berhasil dihapus.');
    }
}