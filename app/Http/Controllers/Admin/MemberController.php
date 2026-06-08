<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $members = Member::with('user')
            ->when($request->search, fn($q, $s) => $q->cari($s))
            ->latest()
            ->paginate(15);

        $totalMember = Member::count();

        return view('admin.member.index', compact('members', 'totalMember'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_telp' => ['required', 'string', 'max:15', 'unique:members,no_telp'],
            'nama'    => ['required', 'string', 'max:255'],
            'email'   => ['nullable', 'email', 'max:255'],
            'alamat'  => ['required', 'string'],
        ], [
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_telp.unique'   => 'Nomor telepon sudah terdaftar.',
            'no_telp.max'      => 'Nomor telepon maksimal 15 karakter.',
            'nama.required'    => 'Nama wajib diisi.',
            'alamat.required'  => 'Alamat wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
        ]);

        $validated['user_id'] = Auth::id();

        Member::create($validated);

        return redirect()->route('admin.member.index')
            ->with('success', 'Member berhasil ditambahkan.');
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'no_telp' => ['required', 'string', 'max:15', 'unique:members,no_telp,' . $member->id],
            'nama'    => ['required', 'string', 'max:255'],
            'email'   => ['nullable', 'email', 'max:255'],
            'alamat'  => ['required', 'string'],
        ], [
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_telp.unique'   => 'Nomor telepon sudah terdaftar.',
            'no_telp.max'      => 'Nomor telepon maksimal 15 karakter.',
            'nama.required'    => 'Nama wajib diisi.',
            'alamat.required'  => 'Alamat wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
        ]);

        $member->update($validated);

        return redirect()->route('admin.member.index')
            ->with('success', 'Data member berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        if ($member->transaksis()->exists()) {
            return response()->json([
                'success' => false,
                'message' => "Member \"{$member->nama}\" tidak bisa dihapus karena memiliki riwayat transaksi.",
            ], 422);
        }

        $member->delete();

        return response()->json([
            'success' => true,
            'message' => "Member \"{$member->nama}\" berhasil dihapus.",
        ]);
    }

    public function toggleAktif(Member $member)
    {
        $member->update(['aktif' => ! $member->aktif]);

        return response()->json([
            'success' => true,
            'aktif'   => $member->aktif,
            'message' => $member->aktif ? 'Member diaktifkan.' : 'Member dinonaktifkan.',
        ]);
    }

    public function export()
    {
        $members = Member::with('user')->orderBy('nama')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Member');

        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'DATA MEMBER PERPUSTAKAAN');
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 13, 'color' => ['rgb' => '3730A3']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(28);

        $sheet->mergeCells('A2:F2');
        $sheet->setCellValue('A2', 'Diekspor pada: ' . now()->translatedFormat('d F Y, H:i') . ' WIB');
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['size' => 9, 'color' => ['rgb' => '6B7280'], 'italic' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(18);

        $headers = ['No', 'Nama', 'Email', 'No. Telepon', 'Alamat', 'Ditambahkan Oleh'];
        foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $i => $col) {
            $sheet->setCellValue("{$col}3", $headers[$i]);
        }
        $sheet->getStyle('A3:F3')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 10],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F46E5']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '6366F1']]],
        ]);
        $sheet->getRowDimension(3)->setRowHeight(22);

        foreach ($members as $i => $member) {
            $row = $i + 4;
            $sheet->setCellValue("A{$row}", $i + 1);
            $sheet->setCellValue("B{$row}", $member->nama);
            $sheet->setCellValue("C{$row}", $member->email ?? '-');
            $sheet->setCellValue("D{$row}", $member->no_telp);
            $sheet->setCellValue("E{$row}", $member->alamat ?? '-');
            $sheet->setCellValue("F{$row}", $member->user?->nama ?? '-');

            $bg = $i % 2 === 0 ? 'F5F5FF' : 'FFFFFF';
            $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bg]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']]],
            ]);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("F{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getRowDimension($row)->setRowHeight(20);
        }

        $footerRow = $members->count() + 4;
        $sheet->mergeCells("A{$footerRow}:F{$footerRow}");
        $sheet->setCellValue("A{$footerRow}", 'Total: ' . $members->count() . ' member');
        $sheet->getStyle("A{$footerRow}")->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => '3730A3'], 'size' => 10],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EEF2FF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'C7D2FE']]],
        ]);
        $sheet->getRowDimension($footerRow)->setRowHeight(20);

        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(28);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(22);

        $filename = 'data-member-' . now()->format('Ymd-His') . '.xlsx';
        $writer   = new Xlsx($spreadsheet);

        return response()->streamDownload(
            fn() => $writer->save('php://output'),
            $filename,
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        );
    }
}