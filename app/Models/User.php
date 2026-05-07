<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
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

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}