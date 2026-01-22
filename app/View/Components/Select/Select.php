<?php

namespace App\View\Components\Select;

use Illuminate\View\Component;
use Illuminate\View\View;

class Select extends Component
{

    /**
     * The value of the select.
     *
     * @var string|null
     */
    public ?string $value;

    /**
     * The placeholder text.
     *
     * @var string
     */
    public string $placeholder;

    /**
     * Whether the select is disabled.
     *
     * @var bool
     */
    public bool $disabled;

    /**
     * The name attribute for the input.
     *
     * @var string|null
     */
    public ?string $name;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $placeholder = '',
        ?string $value = null,
        bool $disabled = false,
        ?string $name = null
    ) {
        $this->placeholder = $placeholder;
        $this->value       = $value;
        $this->disabled    = $disabled;
        $this->name        = $name;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select.select');
    }
}
