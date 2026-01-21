<?php

namespace App\View\Components\Select;

use Illuminate\View\Component;
use Illuminate\View\View;

class Select extends Component
{
    /**
     * The style theme of the component.
     *
     * @var string
     */
    public string $theme;

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
     * Change the default rendered element for the one passed as a child, merging their props and behavior.
     *
     * @var bool
     */
    public bool $asChild;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $theme = 'default',
        ?string $value = null,
        string $placeholder = 'Select an option',
        bool $disabled = false,
        bool $asChild = false
    ) {
        $this->theme       = $theme;
        $this->value       = $value;
        $this->placeholder = $placeholder;
        $this->disabled    = $disabled;
        $this->asChild     = $asChild;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->view('components.select.select');
    }
}