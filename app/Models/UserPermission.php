<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $fillable = ['user_id', 'permission'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function allPermissions(): array
    {
        return [
            'buku'      => ['buku.create',      'buku.edit',      'buku.delete'],
            'member'    => ['member.create',    'member.edit',    'member.delete'],
            'lokasi'    => ['lokasi.create',    'lokasi.edit',    'lokasi.delete'],
            'kegiatan'  => ['kegiatan.create',  'kegiatan.edit',  'kegiatan.delete'],
            'transaksi' => ['transaksi.create', 'transaksi.edit', 'transaksi.delete'],
        ];
    }
}