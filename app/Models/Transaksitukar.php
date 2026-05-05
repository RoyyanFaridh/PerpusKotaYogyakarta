<?php

namespace App\Models;

use App\Enums\StatusTransaksi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiTukar extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'member_id',
        'buku_tukar_id',
        'buku_perpus_id',
        'user_id',
        'status',
        'catatan_petugas',
        'tanggal_tukar',
    ];

    protected $casts = [
        'status'       => StatusTransaksi::class,
        'tanggal_tukar'=> 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function bukuTukar()
    {
        return $this->belongsTo(BukuTukar::class);
    }

    public function bukuPerpus()
    {
        return $this->belongsTo(BukuPerpus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', StatusTransaksi::Pending);
    }

    public function scopeDisetujui(Builder $query): Builder
    {
        return $query->where('status', StatusTransaksi::Disetujui);
    }

    public function scopeDitolak(Builder $query): Builder
    {
        return $query->where('status', StatusTransaksi::Ditolak);
    }

    public function scopeByMember(Builder $query, int $memberId): Builder
    {
        return $query->where('member_id', $memberId);
    }

    public function getLokasiAttribute()
    {
        return $this->bukuPerpus?->lokasi;
    }
}