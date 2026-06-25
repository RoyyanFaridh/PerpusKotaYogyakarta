<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

/**
 * Export reusable untuk halaman Statistik (Transaksi, Buku, Member).
 *
 * Berisi data ringkasan sesuai yang ditampilkan di chart: periode (tanggal
 * atau nama bulan) + jumlah pada periode itu, bukan data mentah per baris
 * (data mentah per baris sudah punya export sendiri di masing-masing
 * halaman Transaksi/Buku/Member, lihat TransaksiExport).
 *
 * Mengikuti pola yang sama dengan TransaksiExport: pakai PhpSpreadsheet
 * langsung (bukan paket Laravel Excel / maatwebsite, yang tidak dipakai
 * di project ini).
 */
class StatistikExport
{
    /**
     * @param array<string> $labels            Label periode (tanggal 1..31, atau nama bulan Jan..Des)
     * @param array<int>    $values             Jumlah pada masing-masing periode, urutan sejajar dengan $labels
     * @param string        $kolomLabelPeriode  Nama kolom periode di header, misal "Tanggal" / "Bulan"
     * @param string        $kolomLabelJumlah   Nama kolom jumlah di header, misal "Jumlah Transaksi"
     * @param string        $judulSheet         Judul sheet/tab Excel & judul di baris atas file
     * @param string        $filterDesc         Deskripsi filter yang sedang aktif, misal "Tahun: 2026" atau "Juni 2026"
     */
    public function __construct(
        protected array $labels,
        protected array $values,
        protected string $kolomLabelPeriode,
        protected string $kolomLabelJumlah,
        protected string $judulSheet,
        protected string $filterDesc = '',
    ) {
    }

    public function download(string $filename = 'statistik'): never
    {
        $this->streamExcel($filename);
    }

    private function streamExcel(string $filename): never
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($this->judulSheet);

        // Header info rows
        $sheet->setCellValue('A1', $this->judulSheet);
        $sheet->setCellValue('A2', $this->filterDesc ?: 'Semua Periode');
        $sheet->setCellValue('A3', 'Diekspor: ' . now()->format('d/m/Y H:i'));

        foreach (['A1:B1', 'A2:B2', 'A3:B3'] as $merge) {
            $sheet->mergeCells($merge);
        }

        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'name' => 'Arial', 'color' => ['rgb' => '1D4ED8']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $sheet->getStyle('A2:A3')->applyFromArray([
            'font'      => ['size' => 9, 'name' => 'Arial', 'color' => ['rgb' => '6B7280']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $sheet->getRowDimension(4)->setRowHeight(8);

        // Headers
        $headers = [$this->kolomLabelPeriode, $this->kolomLabelJumlah];
        $cols = ['A', 'B'];

        foreach ($headers as $i => $label) {
            $sheet->setCellValue("{$cols[$i]}5", $label);
        }

        $sheet->getStyle('A5:B5')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 10, 'name' => 'Arial'],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1D4ED8']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'BFDBFE']]],
        ]);
        $sheet->getRowDimension(5)->setRowHeight(22);

        $sheet->setAutoFilter('A5:B5');

        // Data rows
        $row = 6;
        foreach ($this->labels as $i => $label) {
            $jumlah = $this->values[$i] ?? 0;

            $sheet->fromArray([$label, $jumlah], null, 'A' . $row);

            $bg = $i % 2 === 0 ? 'FFFFFF' : 'EFF6FF';
            $sheet->getStyle("A{$row}:B{$row}")->applyFromArray([
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bg]],
                'font'      => ['name' => 'Arial', 'size' => 10],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DBEAFE']]],
            ]);

            $sheet->getRowDimension($row)->setRowHeight(18);
            $row++;
        }

        // Baris Total di akhir
        $sheet->setCellValue("A{$row}", 'Total');
        $sheet->setCellValue("B{$row}", array_sum($this->values));
        $sheet->getStyle("A{$row}:B{$row}")->applyFromArray([
            'font'      => ['bold' => true, 'name' => 'Arial', 'size' => 10],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DBEAFE']],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'BFDBFE']]],
        ]);
        $sheet->getRowDimension($row)->setRowHeight(18);

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(20);

        $sheet->freezePane('A6');

        // Stream
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        (new Xlsx($spreadsheet))->save('php://output');
        exit;
    }
}