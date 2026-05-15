<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

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
        'sumber',
        'kondisi',
        'deskripsi',
        'lokasi_id',
        'member_id',
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

    public function scopePerpus(Builder $query): Builder
    {
        return $query->where('sumber', 'perpus');
    }

    public function scopeTukar(Builder $query): Builder
    {
        return $query->where('sumber', 'tukar');
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

    public function getIsTersediaAttribute(): bool
    {
        return $this->stok > 0;
    }

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