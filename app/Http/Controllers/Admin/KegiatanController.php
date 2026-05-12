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
        return response()->json([
            'nama_kegiatan'   => $kegiatan->nama_kegiatan,
            'tanggal_mulai'   => $kegiatan->tanggal_mulai
                                    ? \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('Y-m-d')
                                    : null,
            'jam_pelaksanaan' => $kegiatan->jam_pelaksanaan
                                    ? \Carbon\Carbon::parse($kegiatan->jam_pelaksanaan)->format('H:i')
                                    : null,
            'jam_selesai'     => $kegiatan->jam_selesai
                                    ? \Carbon\Carbon::parse($kegiatan->jam_selesai)->format('H:i')
                                    : null,
            'deskripsi'       => $kegiatan->deskripsi,
        ]);
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'tanggal_mulai'   => 'nullable|date',
            'jam_pelaksanaan' => 'nullable|date_format:H:i',
            'jam_selesai'     => 'nullable|date_format:H:i',
        ]);

        $kegiatan->update([
            'nama_kegiatan'   => $request->filled('nama_kegiatan')
                                    ? $request->nama_kegiatan
                                    : $request->old_nama_kegiatan,
            'tanggal_mulai'   => $request->filled('tanggal_mulai')
                                    ? $request->tanggal_mulai
                                    : $request->old_tanggal_mulai,
            'jam_pelaksanaan' => $request->filled('jam_pelaksanaan')
                                    ? $request->jam_pelaksanaan
                                    : ($request->old_jam_pelaksanaan ?: null),
            'jam_selesai'     => $request->filled('jam_selesai')
                                    ? $request->jam_selesai
                                    : ($request->old_jam_selesai ?: null),
            'deskripsi'       => $request->filled('deskripsi')
                                    ? $request->deskripsi
                                    : ($request->old_deskripsi ?: null),
        ]);

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