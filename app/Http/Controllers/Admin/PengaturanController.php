<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Models\User;
use App\Models\UserLokasi;
use App\Models\UserPermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class PengaturanController extends Controller
{
    // ─────────────────────────────────────────────
    // INDEX
    // ─────────────────────────────────────────────

    public function index(): View
    {
        $users = User::with(['permissions', 'penugasanAktif.lokasi'])
                     ->orderBy('nama')
                     ->get();

        $allPermissions = UserPermission::allPermissions();
        $lokasis        = Lokasi::where('aktif', true)->orderBy('nama_lokasi')->get();

        return view('admin.pengaturan.index', compact('users', 'allPermissions', 'lokasis'));
    }

    // ─────────────────────────────────────────────
    // PROFIL
    // ─────────────────────────────────────────────

    public function profilPage(): View|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.pengaturan.index');
        }

        return view('admin.pengaturan.profil');
    }

    public function updateProfil(Request $request): RedirectResponse
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

    // ─────────────────────────────────────────────
    // PASSWORD
    // ─────────────────────────────────────────────

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required'         => 'Password baru wajib diisi.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->forceFill(['password' => Hash::make($request->password)])->save();

        return redirect()->route('admin.pengaturan.index')
                         ->with('success', 'Password berhasil diubah.');
    }

    // ─────────────────────────────────────────────
    // MANAJEMEN USER
    // ─────────────────────────────────────────────

    public function createUser(): View
    {
        return view('admin.pengaturan.create');
    }

    public function storeUser(Request $request): RedirectResponse
    {
        /** @var User $authUser */
        $authUser = Auth::user();

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
            'new_role.required'     => 'Role wajib dipilih.',
        ]);

        if ($validated['new_role'] === 'superadmin' && ! $authUser->isSuperAdmin()) {
            abort(403, 'Tidak diizinkan membuat akun superadmin.');
        }

        User::create([
            'nama'     => $validated['new_name'],
            'email'    => $validated['new_email'] ?? null,
            'password' => Hash::make($validated['new_password']),
            'role'     => $validated['new_role'],
        ]);

        return redirect()->route('admin.pengaturan.index')
                         ->with('success', 'Akun baru berhasil dibuat.');
    }

    public function editUser(User $user): View
    {
        return view('admin.pengaturan.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user): RedirectResponse
    {
        /** @var User $authUser */
        $authUser = Auth::user();

        if ($user->isSuperAdmin() && ! $authUser->isSuperAdmin()) {
            abort(403, 'Tidak diizinkan mengedit akun superadmin.');
        }

        $validated = $request->validate([
            'nama'     => ['required', 'string', 'max:255'],
            'email'    => ['nullable', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'no_hp'    => ['nullable', 'string', 'max:15'],
            'role'     => ['sometimes', 'in:superadmin,admin'],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ], [
            'nama.required'      => 'Nama wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $newRole = $validated['role'] ?? $user->role;

        if ($newRole === 'superadmin' && ! $authUser->isSuperAdmin()) {
            abort(403, 'Tidak diizinkan mengubah role ke superadmin.');
        }

        $user->fill([
            'nama'  => $validated['nama'],
            'email' => $validated['email'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
            'role'  => $newRole,
        ]);

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.pengaturan.index')
                         ->with('success', 'User berhasil diperbarui.');
    }

    // ─────────────────────────────────────────────
    // NONAKTIFKAN / AKTIFKAN USER
    // Tidak hard delete — histori transaksi tetap terjaga.
    // ─────────────────────────────────────────────

    public function toggleAktifUser(User $user): RedirectResponse
    {
        /** @var User $authUser */
        $authUser = Auth::user();

        if ($user->id === $authUser->id) {
            return back()->with('error', 'Tidak dapat menonaktifkan akun sendiri.');
        }

        if ($user->isSuperAdmin() && ! $authUser->isSuperAdmin()) {
            return back()->with('error', 'Tidak dapat mengubah status akun superadmin.');
        }

        $user->update(['is_active' => ! $user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.pengaturan.index')
                         ->with('success', "Akun {$user->nama} berhasil {$status}.");
    }

    // ─────────────────────────────────────────────
    // PERMISSIONS
    // ─────────────────────────────────────────────

    public function updatePermissions(Request $request, User $user): RedirectResponse
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

        DB::transaction(function () use ($user, $incoming) {
            $user->permissions()->delete();

            foreach ($incoming as $permission) {
                UserPermission::create([
                    'user_id'    => $user->id,
                    'permission' => $permission,
                ]);
            }
        });

        return redirect()->route('admin.pengaturan.index')
                         ->with('success', "Permission {$user->nama} berhasil diperbarui.");
    }

    // ─────────────────────────────────────────────
    // PENUGASAN LOKASI
    // ─────────────────────────────────────────────

    public function historiLokasi(User $user): \Illuminate\Http\JsonResponse
    {
        $histori = $user->userLokasis()
                        ->with(['lokasi', 'assignedBy'])
                        ->latest('assigned_at')
                        ->get()
                        ->map(fn(UserLokasi $ul) => [
                            'id'               => $ul->id,
                            'lokasi_nama'      => $ul->lokasi?->nama_lokasi,
                            'assigned_at'      => $ul->assigned_at?->timezone('Asia/Jakarta')->format('d M Y, H:i'),
                            'unassigned_at'    => $ul->unassigned_at?->timezone('Asia/Jakarta')->format('d M Y, H:i'),
                            'assigned_by_nama' => $ul->assignedBy?->nama,
                            'aktif'            => $ul->unassigned_at === null,
                        ]);

        return response()->json(['histori' => $histori]);
    }

    public function assignLokasi(Request $request, User $user): RedirectResponse
    {
        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Superadmin tidak perlu ditugaskan ke lokasi.');
        }

        $validated = $request->validate([
            'lokasi_id' => ['required', 'exists:lokasis,id'],
        ], [
            'lokasi_id.required' => 'Lokasi wajib dipilih.',
            'lokasi_id.exists'   => 'Lokasi tidak ditemukan.',
        ]);

        // Guard: tidak bisa assign ke lokasi yang sama kalau masih aktif
        $sudahAktifDiLokasi = UserLokasi::where('user_id', $user->id)
            ->where('lokasi_id', $validated['lokasi_id'])
            ->whereNull('unassigned_at')
            ->exists();

        if ($sudahAktifDiLokasi) {
            return back()->with('error', 'Admin sudah aktif di lokasi ini.');
        }

        UserLokasi::create([
            'user_id'     => $user->id,
            'lokasi_id'   => $validated['lokasi_id'],
            'assigned_by' => Auth::id(),
            'assigned_at' => now(),
        ]);

        return redirect()->route('admin.pengaturan.index')
                         ->with('success', "Penugasan {$user->nama} berhasil ditambahkan.");
    }

    public function unassignLokasi(User $user, UserLokasi $userLokasi): RedirectResponse
    {
        if ($userLokasi->user_id !== $user->id) {
            abort(403, 'Penugasan tidak ditemukan untuk user ini.');
        }

        if ($userLokasi->unassigned_at !== null) {
            return back()->with('error', 'Penugasan ini sudah tidak aktif.');
        }

        $userLokasi->update(['unassigned_at' => now()]);

        return redirect()->route('admin.pengaturan.index')
                         ->with('success', "Penugasan {$user->nama} berhasil dinonaktifkan.");
    }

    public function syncLokasi(Request $request, User $user): RedirectResponse
    {
        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Superadmin tidak perlu ditugaskan ke lokasi.');
        }

        $request->validate([
            'lokasi_ids'   => ['nullable', 'array'],
            'lokasi_ids.*' => ['exists:lokasis,id'],
        ]);

        $lokasiIds = collect($request->lokasi_ids ?? []);

        DB::transaction(function () use ($user, $lokasiIds) {
            // Unassign lokasi yang diuncheck (masih aktif tapi tidak ada di request)
            $user->penugasanAktif()
                ->whereNotIn('lokasi_id', $lokasiIds)
                ->update(['unassigned_at' => now()]);

            // Assign lokasi baru yang belum aktif
            $sudahAktif = $user->penugasanAktif()
                            ->pluck('lokasi_id');

            $lokasiIds->diff($sudahAktif)->each(function ($lokasiId) use ($user) {
                UserLokasi::create([
                    'user_id'     => $user->id,
                    'lokasi_id'   => $lokasiId,
                    'assigned_by' => Auth::id(),
                    'assigned_at' => now(),
                ]);
            });
        });

        return redirect()->route('admin.pengaturan.index')
                        ->with('success', "Penugasan {$user->nama} berhasil diperbarui.");
    }
}