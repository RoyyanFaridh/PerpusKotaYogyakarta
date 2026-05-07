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

    protected $primaryKey = 'no_telp';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_telp',
        'nama',
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
        return $this->hasMany(BukuTukar::class, 'member_no_telp', 'no_telp');
    }

    public function transaksiTukars()
    {
        return $this->hasMany(TransaksiTukar::class, 'member_no_telp', 'no_telp');
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