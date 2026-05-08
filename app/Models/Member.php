<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_telp',
        'nama',
        'alamat',
        'email',
        'user_id',
    ];

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCari(Builder $query, string $keyword): Builder
    {
        return $query->where('nama', 'like', "%{$keyword}%")
                     ->orWhere('no_telp', 'like', "%{$keyword}%");
    }

    public function getTotalTukarAttribute(): int
    {
        return $this->transaksiTukars()
            ->where('status', 'disetujui')
            ->count();
    }
}