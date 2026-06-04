<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Kegiatan extends Model
{
    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_pelaksanaan',
        'jam_selesai',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function pakets()
    {
        return $this->belongsToMany(Paket::class, 'kegiatan_paket');
    }

    public function getStatusOtomatisAttribute(): string
    {
        $now = Carbon::now();

        $mulai = Carbon::parse(
            $this->tanggal_mulai->format('Y-m-d') .
            ($this->jam_pelaksanaan ? ' ' . $this->jam_pelaksanaan : ' 00:00:00')
        );

        $tanggalSelesai = $this->tanggal_selesai ?? $this->tanggal_mulai;
        $selesai = $this->jam_selesai
            ? Carbon::parse($tanggalSelesai->format('Y-m-d') . ' ' . $this->jam_selesai)
            : Carbon::parse($tanggalSelesai->format('Y-m-d'))->endOfDay();

        if ($now->lt($mulai)) {
            return 'akan_berlangsung';
        } elseif ($now->between($mulai, $selesai)) {
            return 'sedang_berlangsung';
        } else {
            return 'selesai';
        }
    }
}