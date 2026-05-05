<?php

namespace App\Models;

use App\Enums\KondisiBuku;
use App\Enums\StatusBukuTukar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTukar extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'judul',
        'pengarang',
        'penerbit',
        'kondisi',
        'deskripsi',
        'status',
        'member_id',
        'user_id',
    ];

    protected $casts = [
        'kondisi' => KondisiBuku::class,
        'status'  => StatusBukuTukar::class,
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaksiTukar()
    {
        return $this->hasOne(TransaksiTukar::class);
    }

    public function scopeMenunggu(Builder $query): Builder
    {
        return $query->where('status', StatusBukuTukar::Menunggu);
    }

    public function scopeDiterima(Builder $query): Builder
    {
        return $query->where('status', StatusBukuTukar::Diterima);
    }

    public function getSudahDitukarAttribute(): bool
    {
        return $this->status === StatusBukuTukar::SudahDitukar;
    }
}