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

        $bukuTersedia  = Buku::where('stok', '>', 0)->count();
        $bukuMingguIni = Buku::whereBetween('created_at', [now()->startOfWeek(), now()])->count();
        $perluVerifikasi = Transaksi::whereNull('tanggal_tukar')->count();

        $kategoris        = $this->dummyKategoris();

        $kategoris        = $this->dummyKategoris();
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

    private function dummyKategoris(): array
    {
        return [
            ['nama' => 'Novel',     'jumlah' => 84, 'warna' => 'primary'],
            ['nama' => 'Sains',     'jumlah' => 57, 'warna' => 'success'],
            ['nama' => 'Sejarah',   'jumlah' => 43, 'warna' => 'warning'],
            ['nama' => 'Teknologi', 'jumlah' => 38, 'warna' => 'danger'],
            ['nama' => 'Anak-anak', 'jumlah' => 29, 'warna' => 'primary'],
            ['nama' => 'Lainnya',   'jumlah' => 17, 'warna' => 'neutral'],
        ];
    }
}