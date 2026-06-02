<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Paket extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'nama',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('is_aktif', true);
    }

    public function getTotalBukuAttribute(): int
    {
        return $this->bukus()->count();
    }

    public function getTotalStokAttribute(): int
    {
        return $this->bukus()->sum('stok');
    }

    public function aktivasi(): void
    {
        $this->update(['is_aktif' => true]);
    }

    public function nonaktifkan(): void
    {
        $this->update(['is_aktif' => false]);
    }
}