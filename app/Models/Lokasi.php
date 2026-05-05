<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lokasi',
        'alamat',
        'no_telp',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bukuPerpus()
    {
        return $this->hasMany(BukuPerpus::class);
    }

    public function getTotalStokAttribute(): int
    {
        return $this->bukuPerpus()->sum('stok');
    }

    public function getTotalJudulAttribute(): int
    {
        return $this->bukuPerpus()->count();
    }
}