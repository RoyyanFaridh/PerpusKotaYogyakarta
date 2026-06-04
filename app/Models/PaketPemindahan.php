<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PaketPemindahan extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'paket_id',
        'lokasi_asal_id',
        'lokasi_tujuan_id',
        'catatan',
        'user_id',
        'dipindah_pada',
    ];

    protected $casts = [
        'dipindah_pada' => 'datetime',
    ];

    // Relationships

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function lokasiAsal()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_asal_id');
    }

    public function lokasiTujuan()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_tujuan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}