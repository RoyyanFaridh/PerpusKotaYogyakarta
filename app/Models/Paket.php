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
        'lokasi_id',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function eksemplars()
    {
        return $this->hasMany(BukuEksemplar::class);
    }

    public function kegiatans()
    {
        return $this->belongsToMany(Kegiatan::class, 'kegiatan_paket');
    }

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('is_aktif', true);
    }

    public function getTotalEksemplarAttribute(): int
    {
        return $this->eksemplars()->count();
    }

    public function getTotalStokAttribute(): int
    {
        return $this->eksemplars()->sum('stok');
    }

    public function aktivasi(): void
    {
        $this->update(['is_aktif' => true]);
    }

    public function nonaktifkan(): void
    {
        $this->update(['is_aktif' => false]);
    }

    public function getTotalJudulAttribute(): int
    {
        return $this->eksemplars()->distinct('buku_id')->count('buku_id');
    }
}