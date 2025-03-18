<?php

namespace App\Enums;

enum UnitSourceType: string
{
    case SYSTEM = 'system';
    case EOFFICE = 'e-office';

    public function badge(): string
    {
        return match ($this) {
            self::SYSTEM => 'badge-info',
            self::EOFFICE => 'badge-secondary',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::SYSTEM => 'System',
            self::EOFFICE => 'E-Office',
        };
    }
}
