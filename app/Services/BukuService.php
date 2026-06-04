<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\Lokasi;
use App\Models\Paket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BukuService
{
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        return $this->buildQuery($filters)->paginate(15);
    }

    public function find(int $id): Buku
    {
        return Buku::findOrFail($id);
    }

    public function store(array $data): Buku
    {
        if (isset($data['cover']) && $data['cover'] instanceof UploadedFile) {
            $data['cover'] = $data['cover']->store('covers', 'public');
        }

        return Buku::create($data);
    }

    public function update(int $id, array $data): Buku
    {
        $buku = $this->find($id);

        if (isset($data['cover']) && $data['cover'] instanceof UploadedFile) {
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $data['cover']->store('covers', 'public');
        } else {
            unset($data['cover']);
        }

        $buku->update($data);
        return $buku->fresh();
    }

    public function delete(int $id): bool
    {
        $buku = $this->find($id);

        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        return $buku->delete();
    }

    public function cariByIsbn(string $isbn): ?Buku
    {
        return Buku::where('isbn', $isbn)->first();
    }

    public function export(array $filters): never
    {
        $bukus = $this->buildQuery($filters)->get();
        $this->streamExcel($bukus, $this->buildExportFilterDesc($filters));
    }

    private function buildQuery(array $filters = [])
    {
        $query = Buku::with(['lokasi', 'member', 'paket'])->latest();

        if (! empty($filters['search'])) {
            $query->cari($filters['search']);
        }

        if (! empty($filters['kategori'])) {
            $query->where('kategori', $filters['kategori']);
        }

        if (! empty($filters['lokasi'])) {
            $query->where('lokasi_id', $filters['lokasi']);
        }

        if (! empty($filters['paket'])) {
            if ($filters['paket'] === 'tanpa_paket') {
                $query->whereNull('paket_id');
            } else {
                $query->where('paket_id', $filters['paket']);
            }
        }

        if (isset($filters['visibility'])) {
            match ($filters['visibility']) {
                'visible' => $query->visible(),
                'hidden'  => $query->where(function ($q) {
                    $q->whereNull('paket_id')->where('is_visible', false)
                      ->orWhereHas('paket', fn($p) => $p->where('is_aktif', false));
                }),
                default   => null,
            };
        }

        return $query;
    }

    private function buildExportFilterDesc(array $filters): string
    {
        $parts = [];
        if ($v = $filters['search']     ?? null) $parts[] = "Pencarian: \"{$v}\"";
        if ($v = $filters['kategori']   ?? null) $parts[] = "Kategori: {$v}";
        if ($v = $filters['lokasi']     ?? null) $parts[] = 'Lokasi: ' . (Lokasi::find($v)?->nama_lokasi ?? $v);
        if ($v = $filters['paket']      ?? null) {
            $parts[] = $v === 'tanpa_paket'
                ? 'Paket: Tanpa Paket'
                : 'Paket: ' . (Paket::find($v)?->nama ?? $v);
        }
        if ($v = $filters['visibility'] ?? null) $parts[] = 'Visibilitas: ' . ($v === 'visible' ? 'Tampil' : 'Tersembunyi');
        return implode(' | ', $parts);
    }

    private function streamExcel($bukus, string $filterDesc): never
    {
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Buku');

        // Baris info
        $sheet->setCellValue('A1', 'Data Buku Perpustakaan');
        $sheet->setCellValue('A2', $filterDesc ?: 'Semua Data');
        $sheet->setCellValue('A3', 'Diekspor: ' . now()->format('d/m/Y H:i'));
        foreach (['A1:K1', 'A2:K2', 'A3:K3'] as $merge) {
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

        // Header kolom (baris 5)
        $headers = ['No', 'Judul', 'Pengarang', 'Penerbit', 'ISBN', 'Kategori', 'Tahun', 'Stok', 'Lokasi', 'Paket', 'Tampil'];
        foreach ($headers as $i => $label) {
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 1) . '5', $label);
        }
        $sheet->getStyle('A5:K5')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 10, 'name' => 'Arial'],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1D4ED8']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'BFDBFE']]],
        ]);
        $sheet->getRowDimension(5)->setRowHeight(22);

        // Data rows
        $row = 6;
        foreach ($bukus as $i => $buku) {
            $tampil = $buku->paket_id ? 'via paket' : ($buku->is_visible ? 'Tampil' : 'Tersembunyi');
            $sheet->fromArray([
                $i + 1, $buku->judul, $buku->pengarang, $buku->penerbit ?? '-',
                $buku->isbn ?? '-', $buku->kategori ?? '-', $buku->tahun_terbit ?? '-',
                $buku->stok, $buku->lokasi?->nama_lokasi ?? '-',
                $buku->paket?->nama ?? '-', $tampil,
            ], null, 'A' . $row);

            $bg = $i % 2 === 0 ? 'FFFFFF' : 'EFF6FF';
            $sheet->getStyle("A{$row}:K{$row}")->applyFromArray([
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bg]],
                'font'      => ['name' => 'Arial', 'size' => 10],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DBEAFE']]],
            ]);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("G{$row}:K{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getRowDimension($row)->setRowHeight(18);
            $row++;
        }

        // Baris total
        $sheet->setCellValue('A' . $row, 'Total');
        $sheet->setCellValue('H' . $row, '=SUM(H6:H' . ($row - 1) . ')');
        $sheet->mergeCells("A{$row}:G{$row}");
        $sheet->getStyle("A{$row}:K{$row}")->applyFromArray([
            'font'      => ['bold' => true, 'name' => 'Arial', 'size' => 10],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DBEAFE']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '93C5FD']]],
        ]);
        $sheet->getRowDimension($row)->setRowHeight(20);

        // Lebar kolom & freeze
        foreach (['A'=>5,'B'=>36,'C'=>22,'D'=>20,'E'=>16,'F'=>22,'G'=>8,'H'=>8,'I'=>20,'J'=>18,'K'=>14] as $col => $w) {
            $sheet->getColumnDimension($col)->setWidth($w);
        }
        $sheet->freezePane('A6');

        // Stream ke browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="data-buku-' . now()->format('Ymd-His') . '.xlsx"');
        header('Cache-Control: max-age=0');
        (new Xlsx($spreadsheet))->save('php://output');
        exit;
    }
}