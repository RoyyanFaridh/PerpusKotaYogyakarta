<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;

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

        return view('admin.member.index', compact('members', 'totalMember'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('admin.member.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_telp' => ['required', 'string', 'max:15', 'unique:members,no_telp'],
            'nama'    => ['required', 'string', 'max:255'],
            'email'   => ['nullable', 'email', 'max:255'],
            'alamat'  => ['nullable', 'string'],
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

    public function show(string $id)
    {
        //
    }

    public function edit(Member $member)
    {
        $users = User::orderBy('name')->get();
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

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('admin.member.index')
                         ->with('success', 'Member berhasil dihapus.');
    }
}