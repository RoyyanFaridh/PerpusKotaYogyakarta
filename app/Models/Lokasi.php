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
        'tipe',
        'tampil_di_search',
        'aktif',
    ];

    protected $casts = [
        'tampil_di_search' => 'boolean',
        'aktif'            => 'boolean',
    ];

    public function isBankBuku(): bool
    {
        return $this->tipe === 'bank_buku';
    }

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('aktif', true);
    }

    public function scopeTampilDiSearch(Builder $query): Builder
    {
        return $query->where('tampil_di_search', true);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }

    public function getTotalStokAttribute(): int
    {
        return $this->bukus()->sum('stok');
    }

    public function getTotalJudulAttribute(): int
    {
        return $this->bukus()->count();
    }
}