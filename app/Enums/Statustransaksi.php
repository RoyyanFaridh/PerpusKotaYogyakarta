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

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [
                $case->value => $case->label()
            ])
            ->toArray();
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function isFinal(): bool
    {
        return in_array($this, [
            self::Disetujui,
            self::Ditolak
        ]);
    }
}