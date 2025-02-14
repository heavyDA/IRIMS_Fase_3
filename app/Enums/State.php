<?php

namespace App\Enums;

enum State: string
{
    case SUCCESS = 'success';
    case ERROR = 'danger';
    case WARNING = 'warning';
    case INFO = 'info';

    public function icon(): string
    {
        return match ($this) {
            self::SUCCESS => 'circle-check',
            self::ERROR => 'alert-hexagon',
            self::WARNING => 'alert-triangle',
            self::INFO => 'alert-circle'
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SUCCESS => 'success',
            self::ERROR => 'danger',
            self::WARNING => 'warning',
            self::INFO => 'info'
        };
    }
}
