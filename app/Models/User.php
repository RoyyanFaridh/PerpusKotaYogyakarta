<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Lokasi;
use App\Models\Member;
use App\Models\BukuPerpus;
use App\Models\BukuTukar;
use App\Models\TransaksiTukar;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function lokasis()
    {
        return $this->hasMany(Lokasi::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function bukuPerpus()
    {
        return $this->hasMany(BukuPerpus::class);
    }

    public function bukuTukars()
    {
        return $this->hasMany(BukuTukar::class);
    }

    public function transaksiTukars()
    {
        return $this->hasMany(TransaksiTukar::class);
    }
}