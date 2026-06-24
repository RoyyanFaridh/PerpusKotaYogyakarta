<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Buku;
use App\Models\Member;
use App\Exports\StatistikExport;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatistikController extends Controller
{
    /**
     * Statistik Transaksi (jumlah transaksi tukar buku per hari/bulan).
     * Dihitung berdasarkan kolom `tanggal_tukar` (tanggal kejadian transaksi),
     * bukan `created_at` (tanggal baris dibuat di database).
     */
    public function transaksi(Request $request)
    {
        [$tahun, $bulan, $mode] = $this->resolveFilter($request);

        $data = $this->hitungPerPeriode(
            query: Transaksi::query(),
            kolomTanggal: 'tanggal_tukar',
            tahun: $tahun,
            bulan: $bulan,
            mode: $mode,
        );

        return view('admin.statistik.transaksi', [
            'tahun'        => $tahun,
            'bulan'        => $bulan,
            'mode'         => $mode,
            'labels'       => $data['labels'],
            'values'       => $data['values'],
            'totalPeriode' => array_sum($data['values']),
            'tahunOptions' => $this->tahunOptions(),
        ]);
    }

    /**
     * Statistik Buku (jumlah buku baru ditambahkan ke katalog per hari/bulan).
     * Dihitung berdasarkan `created_at` di tabel buku (model tidak punya
     * kolom tanggal khusus lain).
     */
    public function buku(Request $request)
    {
        [$tahun, $bulan, $mode] = $this->resolveFilter($request);

        $data = $this->hitungPerPeriode(
            query: Buku::query(),
            kolomTanggal: 'created_at',
            tahun: $tahun,
            bulan: $bulan,
            mode: $mode,
        );

        return view('admin.statistik.buku', [
            'tahun'        => $tahun,
            'bulan'        => $bulan,
            'mode'         => $mode,
            'labels'       => $data['labels'],
            'values'       => $data['values'],
            'totalPeriode' => array_sum($data['values']),
            'tahunOptions' => $this->tahunOptions(),
        ]);
    }

    /**
     * Statistik Member (jumlah member baru mendaftar per hari/bulan).
     * Dihitung berdasarkan `created_at` di tabel member.
     */
    public function member(Request $request)
    {
        [$tahun, $bulan, $mode] = $this->resolveFilter($request);

        $data = $this->hitungPerPeriode(
            query: Member::query(),
            kolomTanggal: 'created_at',
            tahun: $tahun,
            bulan: $bulan,
            mode: $mode,
        );

        return view('admin.statistik.member', [
            'tahun'        => $tahun,
            'bulan'        => $bulan,
            'mode'         => $mode,
            'labels'       => $data['labels'],
            'values'       => $data['values'],
            'totalPeriode' => array_sum($data['values']),
            'tahunOptions' => $this->tahunOptions(),
        ]);
    }

    /**
     * Export Excel Statistik Transaksi.
     * Mengikuti filter tahun/bulan yang sedang aktif di halaman: kalau bulan
     * dipilih spesifik, export berisi data harian bulan itu; kalau bulan =
     * "Semua", export berisi data bulanan (Jan-Des) tahun itu.
     */
    public function exportTransaksi(Request $request)
    {
        [$tahun, $bulan, $mode] = $this->resolveFilter($request);

        $data = $this->hitungPerPeriode(
            query: Transaksi::query(),
            kolomTanggal: 'tanggal_tukar',
            tahun: $tahun,
            bulan: $bulan,
            mode: $mode,
        );

        $filterDesc = $mode === 'harian'
            ? Carbon::create($tahun, $bulan, 1)->translatedFormat('F Y')
            : "Tahun {$tahun}";

        (new StatistikExport(
            labels: $data['labels'],
            values: $data['values'],
            kolomLabelPeriode: $mode === 'harian' ? 'Tanggal' : 'Bulan',
            kolomLabelJumlah: 'Jumlah Transaksi',
            judulSheet: 'Statistik Transaksi',
            filterDesc: $filterDesc,
        ))->download($this->namaFileExport('statistik-transaksi', $tahun, $bulan));
    }

    /**
     * Export Excel Statistik Buku.
     * Mengikuti filter tahun/bulan yang sedang aktif, sama seperti exportTransaksi().
     */
    public function exportBuku(Request $request)
    {
        [$tahun, $bulan, $mode] = $this->resolveFilter($request);

        $data = $this->hitungPerPeriode(
            query: Buku::query(),
            kolomTanggal: 'created_at',
            tahun: $tahun,
            bulan: $bulan,
            mode: $mode,
        );

        $filterDesc = $mode === 'harian'
            ? Carbon::create($tahun, $bulan, 1)->translatedFormat('F Y')
            : "Tahun {$tahun}";

        (new StatistikExport(
            labels: $data['labels'],
            values: $data['values'],
            kolomLabelPeriode: $mode === 'harian' ? 'Tanggal' : 'Bulan',
            kolomLabelJumlah: 'Jumlah Buku',
            judulSheet: 'Statistik Buku',
            filterDesc: $filterDesc,
        ))->download($this->namaFileExport('statistik-buku', $tahun, $bulan));
    }

    /**
     * Export Excel Statistik Member.
     * Mengikuti filter tahun/bulan yang sedang aktif, sama seperti exportTransaksi().
     */
    public function exportMember(Request $request)
    {
        [$tahun, $bulan, $mode] = $this->resolveFilter($request);

        $data = $this->hitungPerPeriode(
            query: Member::query(),
            kolomTanggal: 'created_at',
            tahun: $tahun,
            bulan: $bulan,
            mode: $mode,
        );

        $filterDesc = $mode === 'harian'
            ? Carbon::create($tahun, $bulan, 1)->translatedFormat('F Y')
            : "Tahun {$tahun}";

        (new StatistikExport(
            labels: $data['labels'],
            values: $data['values'],
            kolomLabelPeriode: $mode === 'harian' ? 'Tanggal' : 'Bulan',
            kolomLabelJumlah: 'Jumlah Member',
            judulSheet: 'Statistik Member',
            filterDesc: $filterDesc,
        ))->download($this->namaFileExport('statistik-member', $tahun, $bulan));
    }

    /**
     * Buat nama file export yang mencerminkan filter aktif, misal:
     * statistik-transaksi-2026.xlsx (mode bulanan)
     * statistik-transaksi-juni-2026.xlsx (mode harian)
     */
    private function namaFileExport(string $prefix, int $tahun, ?int $bulan): string
    {
        if ($bulan === null) {
            return "{$prefix}-{$tahun}.xlsx";
        }

        $namaBulan = Carbon::create($tahun, $bulan, 1)->translatedFormat('F');

        return "{$prefix}-" . str($namaBulan)->lower() . "-{$tahun}.xlsx";
    }

    /**
     * Ambil & normalisasi filter tahun/bulan dari request.
     * bulan = null/('' / 'semua') -> mode bulanan (agregat per bulan dalam 1 tahun)
     * bulan = 1-12               -> mode harian (agregat per tanggal dalam bulan itu)
     *
     * @return array{0:int,1:?int,2:string} [$tahun, $bulan, $mode]
     */
    private function resolveFilter(Request $request): array
    {
        $tahun = (int) $request->query('tahun', now()->year);

        $bulanRaw = $request->query('bulan', 'semua');
        $bulan    = ($bulanRaw === 'semua' || $bulanRaw === '' || $bulanRaw === null)
            ? null
            : (int) $bulanRaw;

        // Guard nilai bulan tidak valid (di luar 1-12) -> anggap "semua"
        if ($bulan !== null && ($bulan < 1 || $bulan > 12)) {
            $bulan = null;
        }

        $mode = $bulan === null ? 'bulanan' : 'harian';

        return [$tahun, $bulan, $mode];
    }

    /**
     * Hitung jumlah baris per periode (harian dalam 1 bulan, atau bulanan dalam 1 tahun).
     *
     * Catatan: pengelompokan dilakukan di sisi PHP (bukan via fungsi SQL seperti
     * MONTH()/DAY()) supaya kode ini berjalan sama di MySQL, PostgreSQL, maupun
     * SQLite tanpa perlu deteksi driver database. whereYear()/whereMonth() dari
     * Eloquent sendiri sudah aman dipakai di semua driver tersebut.
     *
     * @return array{labels: array<string>, values: array<int>}
     */
    private function hitungPerPeriode($query, string $kolomTanggal, int $tahun, ?int $bulan, string $mode): array
    {
        if ($mode === 'harian') {
            // Agregat per tanggal (1..akhir bulan) dalam $tahun-$bulan
            $jumlahHari = Carbon::create($tahun, $bulan, 1)->daysInMonth;

            $rows = $query
                ->whereYear($kolomTanggal, $tahun)
                ->whereMonth($kolomTanggal, $bulan)
                ->get([$kolomTanggal])
                ->countBy(fn ($row) => Carbon::parse($row->{$kolomTanggal})->day);

            $labels = [];
            $values = [];
            for ($hari = 1; $hari <= $jumlahHari; $hari++) {
                $labels[] = (string) $hari;
                $values[] = (int) ($rows[$hari] ?? 0);
            }

            return ['labels' => $labels, 'values' => $values];
        }

        // mode bulanan: agregat per bulan (1..12) dalam $tahun
        $rows = $query
            ->whereYear($kolomTanggal, $tahun)
            ->get([$kolomTanggal])
            ->countBy(fn ($row) => Carbon::parse($row->{$kolomTanggal})->month);

        $namaBulan = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
        ];

        $labels = [];
        $values = [];
        for ($bulanKe = 1; $bulanKe <= 12; $bulanKe++) {
            $labels[] = $namaBulan[$bulanKe];
            $values[] = (int) ($rows[$bulanKe] ?? 0);
        }

        return ['labels' => $labels, 'values' => $values];
    }

    /**
     * Daftar pilihan tahun untuk dropdown filter (dari tahun sekarang ke belakang).
     */
    private function tahunOptions(int $jumlahTahunKeBelakang = 5): array
    {
        $tahunIni = now()->year;

        return range($tahunIni, $tahunIni - $jumlahTahunKeBelakang);
    }
}