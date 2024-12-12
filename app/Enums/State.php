<?php
namespace App\Enums;

enum State: string {
    case SUCCESS = 'success';
    case ERROR = 'danger';
    case WARNING = 'warning';
    case INFO = 'info';
    
    public function icon(): string {
        return match($this) {
            State::SUCCESS => 'circle-check',
            State::ERROR => 'alert-hexagon',
            State::WARNING => 'alert-triangle',
            State::INFO => 'alert-circle'
        };
    }
}
