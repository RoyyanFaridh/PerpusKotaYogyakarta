<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BukuEksemplar extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'buku_id',
        'paket_id',
        'stok',
    ];

    protected $casts = [
        'stok' => 'integer',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function transaksiMasuk()
    {
        return $this->hasMany(Transaksi::class, 'buku_masuk_id');
    }

    public function transaksiKeluar()
    {
        return $this->hasMany(Transaksi::class, 'buku_keluar_id');
    }

    // Scopes

    public function scopeTersedia(Builder $query): Builder
    {
        return $query->where('stok', '>', 0);
    }

    public function scopeDiPaketAktif(Builder $query): Builder
    {
        return $query->whereHas('paket', fn($p) => $p->where('is_aktif', true));
    }

    // Static Methods

    public static function totalStokAktif(): int
    {
        return static::tersedia()
            ->diPaketAktif()
            ->whereHas('buku', fn($b) => $b->where('is_visible', true))
            ->sum('stok');
    }

    // Attributes

    public function getIsTersediaAttribute(): bool
    {
        return $this->stok > 0;
    }

    public function kurangiStok(): void
    {
        $fresh = BukuEksemplar::lockForUpdate()->findOrFail($this->id);

        if ($fresh->stok <= 0) {
            throw new \Exception("Stok buku '{$this->buku->judul}' di paket ini sudah habis.");
        }
        $fresh->decrement('stok');
    }

    public function tambahStok(): void
    {
        $this->increment('stok');
    }
}