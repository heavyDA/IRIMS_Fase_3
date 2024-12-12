<?php

namespace App\View\Components\Elements;

use App\Enums\State;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public ?State $state;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type = 'success',
        public ?string $message,
        public bool $withIcon = true,
        public bool $dismissable = false,
    )
    {
        //
        $this->state = State::tryFrom($type);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.elements.alert');
    }
}
