<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Lokasi extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'lokasis';

    protected $fillable = [
        'nama_lokasi',
        'alamat',
        'no_telp',
        'user_id',
        'tampil_di_search',
        'aktif',
    ];

    protected $casts = [
        'tampil_di_search' => 'boolean',
        'aktif'            => 'boolean',
    ];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
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