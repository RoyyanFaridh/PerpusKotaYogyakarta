<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Transaksi::with([
                'member',
                'paket.lokasi',
                'bukuDiserahkan.buku',
                'bukuDiterima.buku',
            ])
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Nama Member',
            'No. Telepon',
            'Buku Diserahkan',
            'Pengarang (Diserahkan)',
            'Buku Diterima',
            'Pengarang (Diterima)',
            'Paket',
            'Lokasi',
            'Tanggal Tukar',
        ];
    }

    public function map($row): array
    {
        return [
            '#TXN-' . str_pad($row->id, 4, '0', STR_PAD_LEFT),
            $row->member?->nama                             ?? '-',
            $row->member?->no_telp                         ?? '-',
            $row->bukuDiserahkan?->buku?->judul             ?? '-',
            $row->bukuDiserahkan?->buku?->pengarang         ?? '-',
            $row->bukuDiterima?->buku?->judul               ?? '-',
            $row->bukuDiterima?->buku?->pengarang           ?? '-',
            $row->paket?->nama                              ?? '-',
            $row->paket?->lokasi?->nama_lokasi              ?? '-',
            $row->tanggal_tukar?->format('d M Y')           ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}