<?php
namespace App\Enums;

enum KRIThreshold: string
{
    case SAFE = 'safe';
    case CAUTION = 'caution';
    case DANGER = 'danger';

    public static function fromID(string $s) : self {
        $t = self::SAFE;

        switch($s) {
            case 'kuning';
                $t = self::CAUTION;
                break;
            case 'merah';
                $t = self::DANGER;
                break;
            default:
                break;
        };

        return $t;
    }

    public function color(): string
    {
        return match($this) {
            self::SAFE => 'success',
            self::CAUTION => 'warning',
            self::DANGER => 'danger',
        };
    }
}