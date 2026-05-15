<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserPermission;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'lokasi_id',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function permissions()
    {
        return $this->hasMany(UserPermission::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
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