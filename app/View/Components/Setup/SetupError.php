<?php

namespace App\View\Components\Setup;

use Illuminate\View\Component;
use Illuminate\View\View;

class SetupError extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $for = '',
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.setup.error');
    }
}
