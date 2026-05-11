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
        'jam_pelaksanaan',
        'jam_selesai',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
    ];

    public function getStatusOtomatisAttribute(): string
    {
        $now   = Carbon::now();
        $mulai = Carbon::parse($this->tanggal_mulai->format('Y-m-d')
            . ($this->jam_pelaksanaan ? ' ' . $this->jam_pelaksanaan : ' 00:00:00'));
        $selesai = $this->jam_selesai
            ? Carbon::parse($this->tanggal_mulai->format('Y-m-d') . ' ' . $this->jam_selesai)
            : $mulai->copy()->endOfDay();

        if ($now->lt($mulai)) {
            return 'akan_berlangsung';
        } elseif ($now->between($mulai, $selesai)) {
            return 'sedang_berlangsung';
        } else {
            return 'selesai';
        }
    }
}