<?php

namespace App\Enums;

enum StatusBukuTukar: string
{
    case Menunggu    = 'menunggu';
    case Diterima    = 'diterima';
    case Ditolak     = 'ditolak';
    case SudahDitukar = 'sudah_ditukar';

    public function label(): string
    {
        return match($this) {
            self::Menunggu     => 'Menunggu',
            self::Diterima     => 'Diterima',
            self::Ditolak      => 'Ditolak',
            self::SudahDitukar => 'Sudah Ditukar',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::Menunggu     => 'pill-amber',
            self::Diterima     => 'pill-green',
            self::Ditolak      => 'pill-red',
            self::SudahDitukar => 'pill-blue',
        };
    }
}