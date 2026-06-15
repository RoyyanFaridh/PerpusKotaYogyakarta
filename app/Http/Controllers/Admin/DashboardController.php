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

        $bukuTersedia = BukuEksemplar::where('stok', '>', 0)
            ->whereHas('paket', fn($p) => $p->where('is_aktif', true))
            ->whereHas('buku', fn($b) => $b->where('is_visible', true))
            ->sum('stok');
        $bukuMingguIni   = Buku::whereBetween('created_at', [now()->startOfWeek(), now()])->count();
        $memberBulanIni = Member::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $memberBulanLalu = Member::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $selisihMember = $memberBulanIni - $memberBulanLalu;

        $kategoris        = $this->getKategoris();
        $aktivitas        = $this->getAktivitasTerkini();
        $transaksiTerbaru = Transaksi::with([
                'member',
                'bukuMasuk.buku',
                'bukuKeluar.buku',
            ])
            ->latest()
            ->limit(15)
            ->get();

        return view('admin.dashboard', compact(
            'transaksiBulanIni',
            'selisihTransaksi',
            'bukuTersedia',
            'bukuMingguIni',
            'memberBulanIni',
            'selisihMember',
            'kategoris',
            'aktivitas',
            'transaksiTerbaru',
        ));
    }

    private function getAktivitasTerkini(): array
    {
        $items = collect();

        Transaksi::with(['member', 'bukuMasuk.buku'])
            ->latest()
            ->limit(20)
            ->get()
            ->each(function ($t) use (&$items) {
                $nama  = $t->member?->nama ?? 'Member';
                $judul = $t->bukuMasuk?->buku?->judul ?? 'Buku';

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
            'Ilmu Sosial'          => 'amber',
            'Bahasa'               => 'teal',
            'Sains & Matematika'   => 'success',
            'Teknologi'            => 'danger',
            'Seni & Rekreasi'      => 'primary',
            'Literatur & Sastra'   => 'neutral',
            'Geografi & Sejarah'   => 'sky',
        ];

        // Data transaksi bulan ini per kategori
        $dataTransaksi = Transaksi::join('buku_eksemplars', 'transaksis.buku_keluar_id', '=', 'buku_eksemplars.id')
            ->join('bukus', 'buku_eksemplars.buku_id', '=', 'bukus.id')
            ->whereMonth('transaksis.created_at', now()->month)
            ->whereYear('transaksis.created_at', now()->year)
            ->whereNotNull('bukus.kategori')
            ->selectRaw('bukus.kategori, COUNT(*) as jumlah')
            ->groupBy('bukus.kategori')
            ->orderByDesc('jumlah')
            ->get()
            ->keyBy('kategori');

        // Semua kategori yang ada di sistem
        return collect(array_keys($kategoriWarna))
            ->map(fn($nama) => [
                'nama'   => $nama,
                'jumlah' => (int) ($dataTransaksi->get($nama)?->jumlah ?? 0),
                'warna'  => $kategoriWarna[$nama],
            ])
            ->sortByDesc('jumlah')
            ->values()
            ->all();
    }
} 