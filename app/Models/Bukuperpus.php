<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuPerpus extends Model
{
    use HasFactory;

    protected $table = 'buku_perpus';

    protected $fillable = [
        'judul',
        'pengarang',
        'penerbit',
        'isbn',
        'tahun_terbit',
        'tempat_terbit',
        'resume',
        'stok',
        'kategori',
        'lokasi_id',
        'user_id',
    ];

    protected $casts = [
        'stok'         => 'integer',
        'tahun_terbit' => 'integer',
    ];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaksiTukars()
    {
        return $this->hasMany(TransaksiTukar::class);
    }

    public function scopeTersedia(Builder $query): Builder
    {
        return $query->where('stok', '>', 0);
    }

    public function scopeCari(Builder $query, string $keyword): Builder
    {
        return $query->where('judul', 'like', "%{$keyword}%")
                     ->orWhere('pengarang', 'like', "%{$keyword}%")
                     ->orWhere('isbn', 'like', "%{$keyword}%");
    }

    public function scopeKategori(Builder $query, string $kategori): Builder
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeLokasi(Builder $query, int $lokasiId): Builder
    {
        return $query->where('lokasi_id', $lokasiId);
    }

    public function getIsTersediaAttribute(): bool
    {
        return $this->stok > 0;
    }

    public function kurangiStok(): void
    {
        if ($this->stok <= 0) {
            throw new \Exception("Stok buku '{$this->judul}' sudah habis.");
        }

        $this->decrement('stok');
    }

    public function tambahStok(): void
    {
        $this->increment('stok');
    }
}