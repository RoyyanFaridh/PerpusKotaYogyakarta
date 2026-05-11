<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::orderBy('tanggal_mulai', 'asc')->paginate(10);

        return view('admin.kegiatan.index', compact('kegiatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan'   => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'tanggal_mulai'   => 'required|date',
            'jam_pelaksanaan' => 'nullable|date_format:H:i',
            'jam_selesai'     => 'nullable|date_format:H:i|after:jam_pelaksanaan',
        ]);

        Kegiatan::create($request->only([
            'nama_kegiatan',
            'deskripsi',
            'tanggal_mulai',
            'jam_pelaksanaan',
            'jam_selesai',
        ]));

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(Kegiatan $kegiatan)
    {
        return view('admin.kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'nama_kegiatan'   => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'tanggal_mulai'   => 'required|date',
            'jam_pelaksanaan' => 'nullable|date_format:H:i',
            'jam_selesai'     => 'nullable|date_format:H:i|after:jam_pelaksanaan',
        ]);

        $kegiatan->update($request->only([
            'nama_kegiatan',
            'deskripsi',
            'tanggal_mulai',
            'jam_pelaksanaan',
            'jam_selesai',
        ]));

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }
}