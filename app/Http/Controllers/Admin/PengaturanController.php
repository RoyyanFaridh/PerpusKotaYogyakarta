<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PengaturanController extends Controller
{
    public function index()
    {
        $users          = User::with('permissions')->orderBy('nama')->get();
        $allPermissions = UserPermission::allPermissions();
        $lastBackup     = null;

        return view('admin.pengaturan.index', compact('users', 'allPermissions', 'lastBackup'));
    }

    public function updateProfil(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'nama'  => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'no_hp' => ['nullable', 'string', 'max:15'],
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.email'   => 'Format email tidak valid.',
            'email.unique'  => 'Email sudah digunakan.',
        ]);

        $user->fill($validated)->save();

        return redirect()->route('admin.pengaturan.index')
                         ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required'         => 'Password baru wajib diisi.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
            'password.min'              => 'Password minimal 8 karakter.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->forceFill(['password' => Hash::make($request->password)])->save();

        return redirect()->route('admin.pengaturan.index')
                         ->with('success', 'Password berhasil diubah.');
    }

    public function createUser()
    {
        return view('admin.pengaturan.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'new_name'     => ['required', 'string', 'max:255'],
            'new_email'    => ['nullable', 'email', 'unique:users,email'],
            'new_password' => ['required', Password::min(8)],
            'new_role'     => ['required', 'in:superadmin,admin'],
        ], [
            'new_name.required'     => 'Nama wajib diisi.',
            'new_email.email'       => 'Format email tidak valid.',
            'new_email.unique'      => 'Email sudah digunakan.',
            'new_password.required' => 'Password wajib diisi.',
            'new_password.min'      => 'Password minimal 8 karakter.',
            'new_role.required'     => 'Role wajib dipilih.',
        ]);

        User::create([
            'nama'     => $validated['new_name'],
            'email'    => $validated['new_email'] ?? null,
            'password' => Hash::make($validated['new_password']),
            'role'     => $validated['new_role'],
        ]);

        return redirect()->route('admin.pengaturan.index')
                         ->with('success', 'Akun baru berhasil dibuat.');
    }

    public function editUser(User $user)
    {
        return view('admin.pengaturan.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama'  => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'no_hp' => ['nullable', 'string', 'max:15'],
            'role'  => ['sometimes', 'in:superadmin,admin'],
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.email'   => 'Format email tidak valid.',
            'email.unique'  => 'Email sudah digunakan.',
        ]);

        $user->fill($validated)->save();

        return redirect()->route('admin.pengaturan.edit', $user)
                         ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updateUserPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'password.required'  => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 8 karakter.',
        ]);

        $user->forceFill(['password' => Hash::make($request->password)])->save();

        return redirect()->route('admin.pengaturan.edit', $user)
                         ->with('success', 'Password berhasil diubah.');
    }

    public function updatePermissions(Request $request, User $user)
    {
        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Superadmin memiliki semua akses secara otomatis.');
        }

        $request->validate([
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['string'],
        ]);

        $validPermissions = collect(UserPermission::allPermissions())->flatten()->toArray();

        $incoming = collect($request->permissions ?? [])
            ->filter(fn($p) => in_array($p, $validPermissions))
            ->values()
            ->toArray();

        $user->permissions()->delete();

        foreach ($incoming as $permission) {
            UserPermission::create([
                'user_id'    => $user->id,
                'permission' => $permission,
            ]);
        }

        return redirect()->route('admin.pengaturan.index')
                         ->with('success', "Permission {$user->nama} berhasil diperbarui.");
    }

    public function confirmDestroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.pengaturan.index')
                             ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        return view('admin.pengaturan.destroy', compact('user'));
    }

    public function destroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.pengaturan.index')
                         ->with('success', 'User berhasil dihapus.');
    }

    public function backup()
    {
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');
        $dbHost = config('database.connections.mysql.host');

        $filename = 'backup_' . $dbName . '_' . now()->format('Ymd_His') . '.sql';
        $filePath = storage_path('app/' . $filename);

        $command = sprintf(
            'mysqldump --host=%s --user=%s --password=%s %s > %s',
            escapeshellarg($dbHost),
            escapeshellarg($dbUser),
            escapeshellarg($dbPass),
            escapeshellarg($dbName),
            escapeshellarg($filePath)
        );

        exec($command, $output, $returnCode);

        if ($returnCode !== 0 || !file_exists($filePath)) {
            return back()->with('error', 'Backup gagal. Pastikan mysqldump tersedia di server.');
        }

        return response()->download($filePath, $filename)->deleteFileAfterSend(true);
    }
}