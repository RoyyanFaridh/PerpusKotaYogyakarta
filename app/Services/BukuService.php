<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\BukuEksemplar;
use App\Models\Paket;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BukuService
{
    public function find(int $id): Buku
    {
        return Buku::findOrFail($id);
    }

    public function store(array $data): Buku
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['cover']) && $data['cover'] instanceof UploadedFile) {
                $data['cover'] = $data['cover']->store('covers', 'public');
            }

            $paketId = $data['paket_id'] ?? null;
            $stok    = $data['stok'] ?? 0;

            $buku = Buku::create([
                'judul'         => $data['judul'],
                'pengarang'     => $data['pengarang'],
                'penerbit'      => $data['penerbit']      ?? null,
                'isbn'          => $data['isbn']          ?? null,
                'tahun_terbit'  => $data['tahun_terbit']  ?? null,
                'tempat_terbit' => $data['tempat_terbit'] ?? null,
                'resume'        => $data['resume']        ?? null,
                'cover'         => $data['cover']         ?? null,
                'kategori'      => $data['kategori']      ?? null,
                'deskripsi'     => $data['deskripsi']     ?? null,
                'is_visible'    => $data['is_visible']    ?? false,
                'user_id'       => $data['user_id'],
            ]);

            BukuEksemplar::create([
                'buku_id'  => $buku->id,
                'paket_id' => $paketId,
                'stok'     => $stok,
            ]);

            return $buku;
        });
    }

    public function update(int $id, array $data): Buku
    {
        return DB::transaction(function () use ($id, $data) {
            $buku = $this->find($id);

            if (isset($data['cover']) && $data['cover'] instanceof UploadedFile) {
                if ($buku->cover) {
                    Storage::disk('public')->delete($buku->cover);
                }
                $data['cover'] = $data['cover']->store('covers', 'public');
            } else {
                unset($data['cover']);
            }

            $buku->update([
                'judul'         => $data['judul'],
                'pengarang'     => $data['pengarang'],
                'penerbit'      => $data['penerbit']      ?? null,
                'isbn'          => $data['isbn']          ?? null,
                'tahun_terbit'  => $data['tahun_terbit']  ?? null,
                'tempat_terbit' => $data['tempat_terbit'] ?? null,
                'resume'        => $data['resume']        ?? null,
                'cover'         => $data['cover']         ?? $buku->cover,
                'kategori'      => $data['kategori']      ?? null,
                'deskripsi'     => $data['deskripsi']     ?? null,
                'is_visible'    => $data['is_visible']    ?? $buku->is_visible,
            ]);

            if (! empty($data['eksemplar_id'])) {
                $updateEksemplar = [];

                if (isset($data['stok'])) {
                    $updateEksemplar['stok'] = $data['stok'];
                }

                if (array_key_exists('paket_id', $data)) {
                    $updateEksemplar['paket_id'] = $data['paket_id'] ?: null;
                }

                if (! empty($updateEksemplar)) {
                    BukuEksemplar::where('id', $data['eksemplar_id'])
                        ->where('buku_id', $buku->id)
                        ->update($updateEksemplar);
                }
            }

            return $buku->fresh();
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $buku = $this->find($id);

            $terlibatTransaksi = BukuEksemplar::where('buku_id', $id)
                ->where(function ($q) {
                    $q->whereHas('transaksiMasuk')
                      ->orWhereHas('transaksiKeluar');
                })
                ->exists();

            if ($terlibatTransaksi) {
                throw new \Exception("Buku \"{$buku->judul}\" tidak bisa dihapus karena terlibat dalam transaksi.");
            }

            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }

            return $buku->delete();
        });
    }

    public function cariByIsbn(string $isbn): ?Buku
    {
        return Buku::where('isbn', $isbn)->first();
    }

    public function getStats(): array
    {
        return [
            'total_judul'   => Buku::count(),
            'total_stok'    => BukuEksemplar::sum('stok'),
            'stok_tersedia' => BukuEksemplar::where('stok', '>', 0)->sum('stok'),
            'dalam_paket'   => BukuEksemplar::whereNotNull('paket_id')->sum('stok'),
            'tanpa_paket'   => BukuEksemplar::whereNull('paket_id')->sum('stok'),
        ];
    }

    public function getAllGroupedByPaket(): \Illuminate\Database\Eloquent\Collection
    {
        return Paket::with(['lokasi', 'eksemplars.buku'])
            ->withCount('eksemplars')
            ->withSum('eksemplars', 'stok')
            ->orderBy('is_aktif', 'desc')
            ->orderBy('nama')
            ->get();
    }

    public function getTanpaPaket(): \Illuminate\Database\Eloquent\Collection
    {
        return BukuEksemplar::whereNull('paket_id')
            ->with('buku')
            ->get();
    }

    public function export(array $filters, bool $publikOnly = false): never
    {
        if ($publikOnly) {
            $filters['visibility'] = 'visible';
        }

        $bukus = $this->buildExportQuery($filters)->get();

        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $namaFile = $publikOnly
            ? 'Katalog Buku Tukar_' . $bulan[now()->month] . ' ' . now()->year
            : 'Data Buku_' . $bulan[now()->month] . ' ' . now()->year;

        if (! empty($filters['paket'])) {
            $namaPaket = $filters['paket'] === 'tanpa_paket'
                ? 'Tanpa Paket'
                : (Paket::find($filters['paket'])?->nama ?? null);

            if ($namaPaket) {
                $namaFile .= ' - ' . $namaPaket;
            }
        }

        $this->streamExcel($bukus, $this->buildExportFilterDesc($filters), $namaFile, $publikOnly, $filters);
    }

    private function buildExportQuery(array $filters = [])
    {
        $query = Buku::with(['eksemplars.paket.lokasi'])->latest();

        if (! empty($filters['search'])) {
            $query->cari($filters['search']);
        }

        if (! empty($filters['kategori'])) {
            $query->where('kategori', $filters['kategori']);
        }

        if (! empty($filters['paket'])) {
            if ($filters['paket'] === 'tanpa_paket') {
                $query->whereDoesntHave('eksemplars', fn($e) => $e->whereNotNull('paket_id'));
            } else {
                $query->whereHas('eksemplars', fn($e) => $e->where('paket_id', $filters['paket']));
            }
        }

        if (! empty($filters['visibility'])) {
            match ($filters['visibility']) {
                'visible' => $query->where('is_visible', true),
                'hidden'  => $query->where('is_visible', false),
                default   => null,
            };
        }

        return $query;
    }

    private function buildExportFilterDesc(array $filters): string
    {
        $parts = [];
        if ($v = $filters['search']   ?? null) $parts[] = "Pencarian: \"{$v}\"";
        if ($v = $filters['kategori'] ?? null) $parts[] = "Kategori: {$v}";
        if ($v = $filters['paket']    ?? null) {
            $parts[] = $v === 'tanpa_paket'
                ? 'Paket: Tanpa Paket'
                : 'Paket: ' . (Paket::find($v)?->nama ?? $v);
        }
        if ($v = $filters['visibility'] ?? null) {
            $parts[] = 'Visibilitas: ' . ($v === 'visible' ? 'Tampil' : 'Tersembunyi');
        }
        return implode(' | ', $parts);
    }

    private function streamExcel(\Illuminate\Database\Eloquent\Collection $bukus, string $filterDesc, string $namaFile, bool $publikOnly = false, array $filters = []
    ): never {
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Buku');

        $lastCol = $publikOnly ? 'I' : 'J';

        $sheet->setCellValue('A1', 'Data Buku Perpustakaan');
        $sheet->setCellValue('A2', $filterDesc ?: 'Semua Data');
        $sheet->setCellValue('A3', 'Diekspor: ' . now()->format('d/m/Y H:i'));
        foreach (["A1:{$lastCol}1", "A2:{$lastCol}2", "A3:{$lastCol}3"] as $merge) {
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

        $headers = $publikOnly
            ? ['No', 'Judul', 'Pengarang', 'Penerbit', 'ISBN', 'Kategori', 'Tahun', 'Stok', 'Lokasi']
            : ['No', 'Judul', 'Pengarang', 'Penerbit', 'ISBN', 'Kategori', 'Tahun', 'Stok', 'Lokasi', 'Tampil'];

        foreach ($headers as $i => $label) {
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($i + 1) . '5', $label);
        }
        $sheet->getStyle("A5:{$lastCol}5")->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 10, 'name' => 'Arial'],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1D4ED8']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'BFDBFE']]],
        ]);
        $sheet->getRowDimension(5)->setRowHeight(22);
        $sheet->setAutoFilter("A5:{$lastCol}5");

        // Target paket spesifik (kalau ada) — supaya stok & lokasi per baris akurat
        $filterPaketId    = null;
        $filterTanpaPaket = false;
        if (! empty($filters['paket'])) {
            if ($filters['paket'] === 'tanpa_paket') {
                $filterTanpaPaket = true;
            } else {
                $filterPaketId = $filters['paket'];
            }
        }

        $row = 6;
        foreach ($bukus as $i => $buku) {
            $relevantEksemplars = $buku->eksemplars;
            if ($filterPaketId) {
                $relevantEksemplars = $relevantEksemplars->where('paket_id', $filterPaketId);
            } elseif ($filterTanpaPaket) {
                $relevantEksemplars = $relevantEksemplars->whereNull('paket_id');
            }

            $stok      = $relevantEksemplars->sum('stok');
            $eksemplar = $relevantEksemplars->first();

            $tampil    = $buku->is_visible ? 'Tampil' : 'Tersembunyi';
            $isbnValue = $buku->isbn ? (string) preg_replace('/[^0-9]/', '', $buku->isbn) : '-';
            $lokasi    = $eksemplar?->paket?->lokasi?->nama_lokasi ?? '-';

            $rowData = [
                $i + 1,
                $buku->judul,
                $buku->pengarang,
                $buku->penerbit     ?? '-',
                $isbnValue,
                $buku->kategori     ?? '-',
                $buku->tahun_terbit ?? '-',
                $stok,
                $lokasi,
            ];

            if (! $publikOnly) {
                $rowData[] = $tampil;
            }

            $sheet->fromArray($rowData, null, 'A' . $row);

            $bg = $i % 2 === 0 ? 'FFFFFF' : 'EFF6FF';
            $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bg]],
                'font'      => ['name' => 'Arial', 'size' => 10],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DBEAFE']]],
            ]);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("G{$row}:{$lastCol}{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getRowDimension($row)->setRowHeight(18);
            $sheet->getStyle("E{$row}")->getNumberFormat()->setFormatCode('0');

            $row++;
        }

        $colWidths = ['A' => 5, 'B' => 36, 'C' => 22, 'D' => 26, 'E' => 16, 'F' => 22, 'G' => 8, 'H' => 10, 'I' => 26];
        if (! $publikOnly) {
            $colWidths['J'] = 14;
        }
        foreach ($colWidths as $col => $w) {
            $sheet->getColumnDimension($col)->setWidth($w);
        }

        $sheet->freezePane('A6');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $namaFile . '.xlsx"');
        header('Cache-Control: max-age=0');
        (new Xlsx($spreadsheet))->save('php://output');
        exit;
    }
}