<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Transaksi extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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

    public function scopeHariIni(Builder $query): Builder
    {
        return $query->whereDate('tanggal_tukar', today());
    }

    public function scopeMingguIni(Builder $query): Builder
    {
        return $query->whereBetween('tanggal_tukar', [now()->startOfWeek(), now()]);
    }

    public function scopeBulanIni(Builder $query): Builder
    {
        return $query->whereMonth('tanggal_tukar', now()->month);
    }
}