<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $members = Member::with('user')
            ->when($request->search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('no_telp', 'like', "%{$search}%");
            })
            ->latest('created_at')
            ->paginate(15);

        $totalMember = Member::count();
        $users       = User::orderBy('nama')->get();

        return view('admin.member.index', compact('members', 'totalMember', 'users'));
    }

    public function export()
    {
        $members = Member::with('user')->orderBy('nama')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Member');

        // ── Judul ──────────────────────────────────────────────────────────────
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

        // ── Header kolom ───────────────────────────────────────────────────────
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

        // ── Baris data ─────────────────────────────────────────────────────────
        foreach ($members as $i => $member) {
            $row = $i + 4;

            $sheet->setCellValue("A{$row}", $i + 1);
            $sheet->setCellValue("B{$row}", $member->nama);
            $sheet->setCellValue("C{$row}", $member->email ?? '-');
            $sheet->setCellValue("D{$row}", $member->no_telp);
            $sheet->setCellValue("E{$row}", $member->alamat ?? '-');
            $sheet->setCellValue("F{$row}", $member->user?->nama ?? '-');

            // Zebra striping
            $bg = $i % 2 === 0 ? 'F5F5FF' : 'FFFFFF';
            $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bg]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']]],
            ]);

            // Kolom A & D center
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("F{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->getRowDimension($row)->setRowHeight(20);
        }

        // ── Footer jumlah ──────────────────────────────────────────────────────
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

        // ── Lebar kolom ────────────────────────────────────────────────────────
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(28);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(22);

        // ── Stream download ────────────────────────────────────────────────────
        $filename = 'data-member-' . now()->format('Ymd-His') . '.xlsx';
        $writer   = new Xlsx($spreadsheet);

        return response()->streamDownload(
            fn () => $writer->save('php://output'),
            $filename,
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_telp' => ['required', 'string', 'max:15', 'unique:members,no_telp'],
            'nama'    => ['required', 'string', 'max:255'],
            'email'   => ['nullable', 'email', 'max:255'],
            'alamat'  => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
        ], [
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_telp.unique'   => 'Nomor telepon sudah terdaftar.',
            'no_telp.max'      => 'Nomor telepon maksimal 15 karakter.',
            'nama.required'    => 'Nama wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
            'user_id.required' => 'User wajib dipilih.',
            'user_id.exists'   => 'User tidak ditemukan.',
        ]);

        Member::create($validated);

        return redirect()->route('admin.member.index')
                        ->with('success', 'Member berhasil ditambahkan.');
    }

    public function edit(Member $member)
    {
        $users = User::orderBy('nama')->get();
        return view('admin.member.edit', compact('member', 'users'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'nama'    => ['required', 'string', 'max:255'],
            'email'   => ['nullable', 'email', 'max:255'],
            'alamat'  => ['nullable', 'string'],
            'user_id' => ['required', 'exists:users,id'],
        ], [
            'nama.required'    => 'Nama wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
            'user_id.required' => 'User wajib dipilih.',
            'user_id.exists'   => 'User tidak ditemukan.',
        ]);

        $member->update($validated);

        return redirect()->route('admin.member.index')
                         ->with('success', 'Data member berhasil diperbarui.');
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
}