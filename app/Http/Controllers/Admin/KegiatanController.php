<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Services\BukuService;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::with(['pakets', 'lokasi'])
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
            'lokasi_id' => 'nullable|exists:lokasis,id',
        ]);

        $exists = Kegiatan::where('nama_kegiatan', $validated['nama_kegiatan'])
            ->where('tanggal_mulai', $validated['tanggal_mulai'])
            ->where('jam_pelaksanaan', $validated['jam_pelaksanaan'])
            ->exists();

        if ($exists) {
            return redirect()->route('admin.kegiatan.index')
                ->with('error', 'Kegiatan dengan data yang sama sudah ada.');
        }

        $kegiatan = Kegiatan::create($validated);

        if (!empty($validated['paket_ids'])) {
            $pakets = \App\Models\Paket::whereIn('id', $validated['paket_ids'])->get();
            $syncData = [];
            foreach ($pakets as $paket) {
                $syncData[$paket->id] = ['lokasi_asal_id' => $paket->lokasi_id];
            }
            $kegiatan->pakets()->sync($syncData);
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
            'lokasi_id'       => $kegiatan->lokasi_id, // tambah ini
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
            'lokasi_id' => 'nullable|exists:lokasis,id',
        ]);

        $paketIdsBaru  = $validated['paket_ids'] ?? [];
        $paketIdsLama  = $kegiatan->pakets->pluck('id')->toArray();
        $masukBaru     = array_diff($paketIdsBaru, $paketIdsLama);
        $sedangAktif   = $kegiatan->status_otomatis === 'sedang_berlangsung';

        $kegiatan->update($validated);
        $syncData = [];

        foreach ($kegiatan->pakets->whereIn('id', array_intersect($paketIdsBaru, $paketIdsLama)) as $paket) {
            $syncData[$paket->id] = ['lokasi_asal_id' => $paket->pivot->lokasi_asal_id];
        }

        if (!empty($masukBaru)) {
            $paketsBaru = \App\Models\Paket::whereIn('id', $masukBaru)->get();
            foreach ($paketsBaru as $paket) {
                $syncData[$paket->id] = ['lokasi_asal_id' => $paket->lokasi_id];

                if ($sedangAktif && $kegiatan->lokasi_id) {
                    $paket->update(['lokasi_id' => $kegiatan->lokasi_id]);
                }
            }
        }

        $dikeluarkan = array_diff($paketIdsLama, $paketIdsBaru);
        if (!empty($dikeluarkan) && $sedangAktif) {
            foreach ($kegiatan->pakets->whereIn('id', $dikeluarkan) as $paket) {
                if ($paket->pivot->lokasi_asal_id) {
                    $paket->update(['lokasi_id' => $paket->pivot->lokasi_asal_id]);
                }
            }
        }

        $kegiatan->pakets()->sync($syncData);

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        if ($kegiatan->status_otomatis === 'sedang_berlangsung') {
            $kegiatan->load('pakets');
            foreach ($kegiatan->pakets as $paket) {
                if ($paket->pivot->lokasi_asal_id) {
                    $paket->update(['lokasi_id' => $paket->pivot->lokasi_asal_id]);
                }
            }
        }

        $kegiatan->delete();

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    public function exportBuku(Kegiatan $kegiatan)
    {
        $paketIds = $kegiatan->pakets->pluck('id')->toArray();

        if (empty($paketIds)) {
            return redirect()->route('admin.kegiatan.index')
                ->with('error', 'Kegiatan ini belum memiliki paket.');
        }

        app(BukuService::class)->export([
            'paket_ids'    => $paketIds,
            'nama_kegiatan' => $kegiatan->nama_kegiatan, // untuk nama file
        ], publikOnly: true);
    }
}