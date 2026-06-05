<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::with('pakets.lokasi')
            ->orderBy('tanggal_mulai', 'asc')
            ->paginate(10);

        return view('admin.kegiatan.index', compact('kegiatans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan'   => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jam_pelaksanaan' => 'nullable|date_format:H:i',
            'jam_selesai'     => [
                'nullable',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    $jamMulai = $request->jam_pelaksanaan;
                    if ($jamMulai && $value && $value <= $jamMulai) {
                        $fail('Jam selesai harus setelah jam mulai.');
                    }
                },
            ],
            'paket_ids'   => 'nullable|array',
            'paket_ids.*' => 'exists:pakets,id',
        ]);

        $kegiatan = Kegiatan::create($validated);

        if (! empty($validated['paket_ids'])) {
            $kegiatan->pakets()->sync($validated['paket_ids']);
        }

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(Kegiatan $kegiatan)
    {
        return response()->json([
            'nama_kegiatan'   => $kegiatan->nama_kegiatan,
            'deskripsi'       => $kegiatan->deskripsi,
            'tanggal_mulai'   => $kegiatan->tanggal_mulai?->format('Y-m-d'),
            'tanggal_selesai' => $kegiatan->tanggal_selesai?->format('Y-m-d'),
            'jam_pelaksanaan' => $kegiatan->jam_pelaksanaan,
            'jam_selesai'     => $kegiatan->jam_selesai,
            'paket_ids'       => $kegiatan->pakets->pluck('id'),
        ]);
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validated = $request->validate([
            'nama_kegiatan'   => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jam_pelaksanaan' => 'nullable|date_format:H:i',
            'jam_selesai'     => [
                'nullable',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    $jamMulai = $request->jam_pelaksanaan;
                    if ($jamMulai && $value && $value <= $jamMulai) {
                        $fail('Jam selesai harus setelah jam mulai.');
                    }
                },
            ],
            'paket_ids'   => 'nullable|array',
            'paket_ids.*' => 'exists:pakets,id',
        ]);

        $kegiatan->update($validated);
        $kegiatan->pakets()->sync($validated['paket_ids'] ?? []);

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