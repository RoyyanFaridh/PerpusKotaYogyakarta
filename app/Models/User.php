<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserPermission;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\UserLokasi;

class User extends Authenticatable implements Auditable
{
    use HasFactory, Notifiable;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    protected $auditExclude = [
        'password',
        'remember_token',
    ];

    // Semua histori penugasan
    public function userLokasis()
    {
        return $this->hasMany(UserLokasi::class);
    }

    // Penugasan aktif saat ini (bisa lebih dari satu lokasi)
    public function penugasanAktif()
    {
        return $this->hasMany(UserLokasi::class)->whereNull('unassigned_at');
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function permissions()
    {
        return $this->hasMany(UserPermission::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->isSuperAdmin()) return true;

        return $this->permissions()
                    ->where('permission', $permission)
                    ->exists();
    }

    public function getPermissionList(): array
    {
        if ($this->isSuperAdmin()) return ['*'];

        return $this->permissions()->pluck('permission')->toArray();
    }
}