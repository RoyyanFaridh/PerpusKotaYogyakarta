<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Member;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $transaksiHariIni = Transaksi::whereDate('created_at', today())->count();

        $transaksiKemarin = Transaksi::whereDate('created_at', today()->subDay())->count();

        $selisihTransaksi = $transaksiKemarin > 0
            ? round((($transaksiHariIni - $transaksiKemarin) / $transaksiKemarin) * 100)
            : 0;

        $bukuTersedia    = Buku::where('stok', '>', 0)->count();
        $bukuMingguIni   = Buku::whereBetween('created_at', [now()->startOfWeek(), now()])->count();
        $perluVerifikasi = Transaksi::whereNull('tanggal_tukar')->count();

        $kategoris        = $this->getKategoris();
        $aktivitas        = $this->getAktivitasTerkini();
        $transaksiTerbaru = Transaksi::with(['member', 'bukuDiserahkan', 'bukuDiterima'])
            ->latest()
            ->limit(15)
            ->get();

        return view('admin.dashboard', compact(
            'transaksiHariIni',
            'selisihTransaksi',
            'bukuTersedia',
            'bukuMingguIni',
            'perluVerifikasi',
            'kategoris',
            'aktivitas',
            'transaksiTerbaru',
        ));
    }

    private function getAktivitasTerkini(): array
    {
        $items = collect();

        Transaksi::with(['member', 'bukuDiserahkan'])
            ->latest()
            ->limit(20)
            ->get()
            ->each(function ($t) use (&$items) {
                $nama  = $t->member?->nama ?? 'Member';
                $judul = $t->bukuDiserahkan?->judul ?? 'Buku';

                $items->push([
                    'tipe'      => 'transaksi_pending',
                    'pesan'     => "Transaksi tukar buku oleh {$nama}",
                    'sub'       => $judul,
                    'waktu'     => $t->created_at->diffForHumans(),
                    'timestamp' => $t->created_at,
                ]);
            });

        Member::latest()
            ->limit(10)
            ->get()
            ->each(function ($m) use (&$items) {
                $items->push([
                    'tipe'      => 'member_baru',
                    'pesan'     => "Member baru terdaftar",
                    'sub'       => $m->nama,
                    'waktu'     => $m->created_at->diffForHumans(),
                    'timestamp' => $m->created_at,
                ]);
            });

        return $items
            ->sortByDesc('timestamp')
            ->take(20)
            ->values()
            ->all();
    }

    private function getKategoris(): array
    {
        $kategoriWarna = [
            'Umum/Komputer'        => 'indigo',
            'Filsafat & Psikologi' => 'violet',
            'Agama'                => 'rose',
            'ILmu Sosial'          => 'amber',
            'Bahasa'               => 'teal',
            'Sains & Matematika'   => 'success',
            'Teknologi'            => 'danger',
            'Seni & Rekreasi'      => 'primary',
            'Literatur & Sastra'   => 'neutral',
            'Geografi & Sejarah'   => 'sky',
        ];

        return Buku::selectRaw('kategori, COUNT(*) as jumlah')
            ->whereNotNull('kategori')
            ->groupBy('kategori')
            ->orderByDesc('jumlah')
            ->get()
            ->map(fn ($row) => [
                'nama'   => $row->kategori,
                'jumlah' => (int) $row->jumlah,
                'warna'  => $kategoriWarna[$row->kategori] ?? 'sky',
            ])
            ->all();
    }
}