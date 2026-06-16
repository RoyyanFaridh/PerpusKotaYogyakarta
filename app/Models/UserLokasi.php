<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLokasi extends Model
{
    protected $table = 'user_lokasi';
    protected $fillable = [
        'user_id',
        'lokasi_id',
        'assigned_by',
        'assigned_at',
        'unassigned_at',
    ];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'unassigned_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    // Scope untuk filter yang masih aktif
    public function scopeAktif($query)
    {
        return $query->whereNull('unassigned_at');
    }

    // Scope untuk histori
    public function scopeHistori($query)
    {
        return $query->whereNotNull('unassigned_at');
    }
}