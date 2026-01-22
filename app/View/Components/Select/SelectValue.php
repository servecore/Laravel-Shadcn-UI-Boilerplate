<?php

namespace App\View\Components\Select;

use Illuminate\View\Component;
use Illuminate\View\View;

class SelectValue extends Component
{
    /**
     * The placeholder text.
     *
     * @var string
     */
    public string $placeholder;

    /**
     * Change the default rendered element for the one passed as a child, merging their props and behavior.
     *
     * @var bool
     */
    public bool $asChild;

    /**
     * Create a new component instance.
     */
    public function __construct(string $placeholder = '', bool $asChild = false)
    {
        $this->placeholder = $placeholder;
        $this->asChild     = $asChild;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select.value');
    }
}
