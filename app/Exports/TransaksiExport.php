<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TransaksiExport
{
    protected ?string $lokasiFilter;

    public function __construct(?string $lokasiFilter = null)
    {
        $this->lokasiFilter = $lokasiFilter;
    }

    public function download(string $filename = 'transaksi'): never
    {
        $transaksis = $this->getTransaksis();
        $filterDesc = $this->buildFilterDesc();
        $this->streamExcel($transaksis, $filterDesc, $filename);
    }

    private function getTransaksis(): Collection
    {
        $query = Transaksi::with([
                'member',
                'bukuMasuk.buku',
                'bukuKeluar.buku',
                'paket',
            ]);

        if ($this->lokasiFilter) {
            $query->where('lokasi_snapshot', $this->lokasiFilter);
        }

        return $query->latest()->get();
    }

    private function buildFilterDesc(): string
    {
        if (! $this->lokasiFilter) {
            return 'Semua Lokasi';
        }
        return "Lokasi: {$this->lokasiFilter}";
    }

    private function streamExcel(Collection $transaksis, string $filterDesc, string $filename): never
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Transaksi');

        // Header info rows
        $sheet->setCellValue('A1', 'Data Transaksi Tukar Buku');
        $sheet->setCellValue('A2', $filterDesc);
        $sheet->setCellValue('A3', 'Diekspor: ' . now()->format('d/m/Y H:i'));

        foreach (['A1:J1', 'A2:J2', 'A3:J3'] as $merge) {
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
        $headers = [
            'No',
            'ID Transaksi',
            'Member',
            'No. Telp',
            'Buku Masuk',
            'Buku Keluar',
            'Paket',
            'Lokasi',
            'Tanggal',
            'Catatan',
        ];

        $cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        foreach ($headers as $i => $label) {
            $sheet->setCellValue("{$cols[$i]}5", $label);
        }

        $sheet->getStyle('A5:J5')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 10, 'name' => 'Arial'],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1D4ED8']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'BFDBFE']]],
        ]);
        $sheet->getRowDimension(5)->setRowHeight(22);

        $sheet->setAutoFilter('A5:J5');

        // Data rows
        $row = 6;
        foreach ($transaksis as $i => $txn) {
            $rowData = [
                $i + 1,
                '#TXN-' . str_pad($txn->id, 4, '0', STR_PAD_LEFT),
                $txn->member?->nama ?? '-',
                $txn->member?->no_telp ?? '-',
                $txn->bukuMasuk?->buku?->judul ?? '-',
                $txn->bukuKeluar?->buku?->judul ?? '-',
                $txn->paket?->nama ?? '-',
                $txn->lokasi_snapshot ?? '-',
                $txn->tanggal_tukar?->format('d/m/Y') ?? '-',
                $txn->catatan_petugas ?? '-',
            ];

            $sheet->fromArray($rowData, null, 'A' . $row);

            $bg = $i % 2 === 0 ? 'FFFFFF' : 'EFF6FF';
            $sheet->getStyle("A{$row}:J{$row}")->applyFromArray([
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bg]],
                'font'      => ['name' => 'Arial', 'size' => 10],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DBEAFE']]],
            ]);

            $sheet->getRowDimension($row)->setRowHeight(18);
            $row++;
        }

        // Column widths
        $colWidths = ['A' => 5, 'B' => 14, 'C' => 24, 'D' => 14, 'E' => 30, 'F' => 30, 'G' => 18, 'H' => 22, 'I' => 12, 'J' => 25];

        foreach ($colWidths as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        $sheet->freezePane('A6');

        // Stream
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '-' . now()->format('Y-m-d') . '.xlsx"');
        header('Cache-Control: max-age=0');

        (new Xlsx($spreadsheet))->save('php://output');
        exit;
    }
}