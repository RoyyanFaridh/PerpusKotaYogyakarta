<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'member_id',
        'buku_diserahkan_id',
        'buku_diterima_id',
        'user_id',
        'catatan_petugas',
        'tanggal_tukar',
    ];

    protected $casts = [
        'tanggal_tukar' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function bukuDiserahkan()
    {
        return $this->belongsTo(Buku::class, 'buku_diserahkan_id');
    }

    public function bukuDiterima()
    {
        return $this->belongsTo(Buku::class, 'buku_diterima_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByMember(Builder $query, int $memberId): Builder
    {
        return $query->where('member_id', $memberId);
    }
}