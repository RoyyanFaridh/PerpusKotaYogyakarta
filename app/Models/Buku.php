<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Buku extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'judul',
        'pengarang',
        'penerbit',
        'isbn',
        'tahun_terbit',
        'tempat_terbit',
        'resume',
        'cover',
        'kategori',
        'deskripsi',
        'is_visible',
        'user_id',
    ];

    protected $casts = [
        'tahun_terbit' => 'integer',
        'is_visible'   => 'boolean',
    ];

    public function eksemplars()
    {
        return $this->hasMany(BukuEksemplar::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->whereHas('eksemplars.paket', fn($p) => $p->where('is_aktif', true));
    }

    public function scopeTersedia(Builder $query): Builder
    {
        return $query->whereHas('eksemplars', fn($e) => $e->where('stok', '>', 0));
    }

    public function scopeCari(Builder $query, string $keyword): Builder
    {
        $lower = strtolower($keyword);

        return $query->where(function ($q) use ($lower) {
            $q->whereRaw('LOWER(judul)     LIKE ?', ["%{$lower}%"])
            ->orWhereRaw('LOWER(pengarang) LIKE ?', ["%{$lower}%"])
            ->orWhereRaw('LOWER(isbn)      LIKE ?', ["%{$lower}%"]);
        });
    }

    public function getStokAttribute(): int
    {
        if ($this->relationLoaded('eksemplars')) {
            return $this->eksemplars->sum('stok');
        }

        return $this->eksemplars()->sum('stok');
    }

    public function getStokAktifAttribute(): int
    {
        if ($this->relationLoaded('eksemplars')) {
            return $this->eksemplars
                ->filter(fn($e) => $e->paket?->is_aktif)
                ->sum('stok');
        }

        return $this->eksemplars()
            ->whereHas('paket', fn($p) => $p->where('is_aktif', true))
            ->sum('stok');
    }

    public function getIsTersediaAttribute(): bool
    {
        return $this->stok > 0;
    }
    
    public function getIsVisibleEfektifAttribute(): bool
    {
        if (! $this->is_visible) {
            return false;
        }

        if ($this->relationLoaded('eksemplars')) {
            return $this->eksemplars->contains(
                fn($e) => $e->relationLoaded('paket')
                    ? $e->paket?->is_aktif
                    : optional($e->paket)->is_aktif
            );
        }

        return $this->eksemplars()->whereHas('paket', fn($p) => $p->where('is_aktif', true))->exists();
    }
}