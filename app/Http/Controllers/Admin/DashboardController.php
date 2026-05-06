<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BukuTukar;
use App\Models\Member;
use App\Models\TransaksiTukar;
use App\Enums\StatusTransaksi;
use App\Enums\StatusBukuTukar;

class DashboardController extends Controller
{
    public function index()
    {
        $transaksiHariIni = TransaksiTukar::disetujui()
            ->whereDate('created_at', today())
            ->count();

        $transaksiKemarin = TransaksiTukar::disetujui()
            ->whereDate('created_at', today()->subDay())
            ->count();

        $selisihTransaksi = $transaksiKemarin > 0
            ? round((($transaksiHariIni - $transaksiKemarin) / $transaksiKemarin) * 100)
            : 0;

        $bukuTersedia  = BukuTukar::diterima()->count();
        $bukuMingguIni = BukuTukar::diterima()
            ->whereBetween('created_at', [now()->startOfWeek(), now()])
            ->count();

        $perluVerifikasi  = TransaksiTukar::pending()->count();
        $kategoris        = $this->dummyKategoris();
        $aktivitas        = $this->getAktivitasTerkini();
        $transaksiTerbaru = TransaksiTukar::with(['member', 'bukuTukar', 'bukuPerpus']) // <-- tambah ini
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'transaksiHariIni',
            'selisihTransaksi',
            'bukuTersedia',
            'bukuMingguIni',
            'perluVerifikasi',
            'kategoris',
            'aktivitas',
            'transaksiTerbaru', // <-- tambah ini
        ));
    }

    private function getAktivitasTerkini(): array
    {
        $items = collect();

        TransaksiTukar::with(['member', 'bukuTukar'])
            ->latest()
            ->limit(10)
            ->get()
            ->each(function ($t) use (&$items) {
                $nama  = $t->member?->nama ?? 'Member';
                $judul = $t->bukuTukar?->judul ?? 'Buku';

                $tipe = match (true) {
                    $t->status === StatusTransaksi::Disetujui => 'transaksi_disetujui',
                    $t->status === StatusTransaksi::Ditolak   => 'transaksi_ditolak',
                    default                                   => 'transaksi_pending',
                };

                $label = match (true) {
                    $t->status === StatusTransaksi::Disetujui => 'Transaksi disetujui',
                    $t->status === StatusTransaksi::Ditolak   => 'Transaksi ditolak',
                    default                                   => 'Transaksi menunggu konfirmasi',
                };

                $items->push([
                    'tipe'      => $tipe,
                    'pesan'     => "{$label} oleh {$nama}",
                    'sub'       => $judul,
                    'waktu'     => $t->created_at->diffForHumans(),
                    'timestamp' => $t->created_at,
                ]);
            });

        BukuTukar::with('member')
            ->latest()
            ->limit(5)
            ->get()
            ->each(function ($b) use (&$items) {
                $nama = $b->member?->nama ?? 'Member';
                $items->push([
                    'tipe'      => 'buku_masuk',
                    'pesan'     => "Buku baru dikirim oleh {$nama}",
                    'sub'       => $b->judul,
                    'waktu'     => $b->created_at->diffForHumans(),
                    'timestamp' => $b->created_at,
                ]);
            });

        Member::latest()
            ->limit(5)
            ->get()
            ->each(function ($m) use (&$items) {
                $items->push([
                    'tipe'      => 'member_baru',
                    'pesan'     => "Member baru terdaftar",
                    'sub'       => "{$m->nama} · {$m->nik}",
                    'waktu'     => $m->created_at->diffForHumans(),
                    'timestamp' => $m->created_at,
                ]);
            });

        BukuTukar::with('member')
            ->where('status', StatusBukuTukar::SudahDitukar)
            ->latest()
            ->limit(5)
            ->get()
            ->each(function ($b) use (&$items) {
                $nama = $b->member?->nama ?? 'Member';
                $items->push([
                    'tipe'      => 'sisa_buku',
                    'pesan'     => "Buku berhasil ditukar oleh {$nama}",
                    'sub'       => $b->judul,
                    'waktu'     => $b->updated_at->diffForHumans(),
                    'timestamp' => $b->updated_at,
                ]);
            });

        return $items
            ->sortByDesc('timestamp')
            ->take(12)
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