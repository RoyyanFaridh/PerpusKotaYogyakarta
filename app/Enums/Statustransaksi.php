<?php

namespace App\Enums;

enum StatusTransaksi: string
{
    case Pending   = 'pending';
    case Disetujui = 'disetujui';
    case Ditolak   = 'ditolak';

    public function label(): string
    {
        return match($this) {
            self::Pending   => 'Pending',
            self::Disetujui => 'Disetujui',
            self::Ditolak   => 'Ditolak',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::Pending   => 'pill-amber',
            self::Disetujui => 'pill-green',
            self::Ditolak   => 'pill-red',
        };
    }
}