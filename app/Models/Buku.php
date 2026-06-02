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
        'cover',        // ← tambahkan ini
        'stok',
        'kategori',
        'deskripsi',
        'is_visible',
        'paket_id',
        'lokasi_id',
        'member_id',
        'user_id',
    ];

    protected $casts = [
        'stok'         => 'integer',
        'tahun_terbit' => 'integer',
        'is_visible'   => 'boolean',
    ];

    // Relationships

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaksiDiserahkan()
    {
        return $this->hasMany(Transaksi::class, 'buku_diserahkan_id');
    }

    public function transaksiDiterima()
    {
        return $this->hasMany(Transaksi::class, 'buku_diterima_id');
    }

    // Scopes

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->whereNull('paket_id')
              ->where('is_visible', true)
              ->orWhereHas('paket', fn ($p) => $p->where('is_aktif', true));
        });
    }

    public function scopeTersedia(Builder $query): Builder
    {
        return $query->where('stok', '>', 0);
    }

    public function scopeCari(Builder $query, string $keyword): Builder
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('judul', 'like', "%{$keyword}%")
              ->orWhere('pengarang', 'like', "%{$keyword}%")
              ->orWhere('isbn', 'like', "%{$keyword}%");
        });
    }

    // Accessors

    public function getIsTersediaAttribute(): bool
    {
        return $this->stok > 0;
    }

    public function getIsVisibleEfektifAttribute(): bool
    {
        if ($this->paket_id !== null) {
            return $this->paket?->is_aktif ?? false;
        }
        return $this->is_visible;
    }

    // Methods

    public function kurangiStok(): void
    {
        $fresh = Buku::lockForUpdate()->findOrFail($this->id);

        if ($fresh->stok <= 0) {
            throw new \Exception("Stok buku '{$this->judul}' sudah habis.");
        }
        $fresh->decrement('stok');
    }

    public function tambahStok(): void
    {
        $this->increment('stok');
    }
}