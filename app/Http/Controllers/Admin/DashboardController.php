<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\BukuEksemplar;
use App\Models\Member;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $transaksiBulanIni = Transaksi::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $transaksiBulanLalu = Transaksi::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $selisihTransaksi = $transaksiBulanLalu > 0
            ? round((($transaksiBulanIni - $transaksiBulanLalu) / $transaksiBulanLalu) * 100)
            : 0;

        $bukuTersedia    = BukuEksemplar::where('stok', '>', 0)->sum('stok');
        $bukuMingguIni   = Buku::whereBetween('created_at', [now()->startOfWeek(), now()])->count();
        $perluVerifikasi = Transaksi::whereNull('tanggal_tukar')->count();

        $kategoris        = $this->getKategoris();
        $aktivitas        = $this->getAktivitasTerkini();
        $transaksiTerbaru = Transaksi::with([
                'member',
                'bukuDiserahkan.buku',
                'bukuDiterima.buku',
            ])
            ->latest()
            ->limit(15)
            ->get();

        return view('admin.dashboard', compact(
            'transaksiBulanIni',
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

        Transaksi::with(['member', 'bukuDiserahkan.buku'])
            ->latest()
            ->limit(20)
            ->get()
            ->each(function ($t) use (&$items) {
                $nama  = $t->member?->nama ?? 'Member';
                $judul = $t->bukuDiserahkan?->buku?->judul ?? 'Buku';

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
            ->map(fn($row) => [
                'nama'   => $row->kategori,
                'jumlah' => (int) $row->jumlah,
                'warna'  => $kategoriWarna[$row->kategori] ?? 'sky',
            ])
            ->all();
    }
} 