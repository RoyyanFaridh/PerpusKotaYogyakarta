<?php

namespace App\Enums;

enum KondisiBuku: string
{
    case Baik  = 'baik';
    case Cukup = 'cukup';
    case Rusak = 'rusak';

    public function label(): string
    {
        return match($this) {
            self::Baik  => 'Baik',
            self::Cukup => 'Cukup',
            self::Rusak => 'Rusak',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::Baik  => 'kondisi-baik',
            self::Cukup => 'kondisi-cukup',
            self::Rusak => 'kondisi-rusak',
        };
    }
}