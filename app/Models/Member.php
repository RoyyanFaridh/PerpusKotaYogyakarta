<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TransaksiTukar;
use App\Models\BukuTukar;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'nama',
        'no_telp',
        'alamat',
        'email',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bukuTukars()
    {
        return $this->hasMany(BukuTukar::class);
    }

    public function transaksiTukars()
    {
        return $this->hasMany(TransaksiTukar::class);
    }

    public function scopeByNik(Builder $query, string $nik): Builder
    {
        return $query->where('nik', $nik);
    }

    public function scopeCari(Builder $query, string $keyword): Builder
    {
        return $query->where('nama', 'like', "%{$keyword}%")
                     ->orWhere('nik', 'like', "%{$keyword}%");
    }

    public function getTotalTukarAttribute(): int
    {
        return $this->transaksiTukars()
            ->where('status', 'disetujui')
            ->count();
    }
}