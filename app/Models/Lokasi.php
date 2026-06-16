<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\UserLokasi;

class Lokasi extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'lokasis';

    protected $fillable = [
        'nama_lokasi',
        'alamat',
        'no_telp',
        'tampil_di_search',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'tampil_di_search' => 'boolean',
            'aktif'            => 'boolean',
        ];
    }

    // Relationships

    // Semua histori penugasan di lokasi ini
    public function userLokasis()
    {
        return $this->hasMany(UserLokasi::class);
    }

    // Admin yang sedang aktif di lokasi ini
    public function adminAktif()
    {
        return $this->hasMany(UserLokasi::class)->whereNull('unassigned_at');
    }

    public function pakets()
    {
        return $this->hasMany(Paket::class);
    }

    // Scopes

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('aktif', true);
    }

    public function scopeTampilDiSearch(Builder $query): Builder
    {
        return $query->where('tampil_di_search', true);
    }

    // Accessors

    public function getTotalStokAttribute(): int
    {
        return BukuEksemplar::whereHas('paket', fn($q) => $q->where('lokasi_id', $this->id))
            ->sum('stok');
    }

    public function getTotalJudulAttribute(): int
    {
        return BukuEksemplar::whereHas('paket', fn($q) => $q->where('lokasi_id', $this->id))
            ->distinct('buku_id')
            ->count('buku_id');
    }
}