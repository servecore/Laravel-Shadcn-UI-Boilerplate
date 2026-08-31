<?php

namespace App\View\Components\Setup;

use Illuminate\View\Component;
use Illuminate\View\View;

class SetupInput extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $label = null,
        public string $name = '',
        public string $type = 'text',
        public ?string $value = null,
        public bool $required = false,
        public ?string $placeholder = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.setup.input');
    }
}
