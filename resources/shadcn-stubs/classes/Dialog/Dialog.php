<?php

namespace App\View\Components\Dialog;

use Illuminate\View\Component;
use Illuminate\View\View;

class Dialog extends Component
{
    /**
     * The style theme of the component.
     *
     * @var string
     */
    public string $theme;

    /**
     * Whether the dialog is open.
     *
     * @var bool
     */
    public bool $open;

    /**
     * Change the default rendered element for the one passed as a child, merging their props and behavior.
     *
     * @var bool
     */
    public bool $asChild;

    /**
     * Create a new component instance.
     */
    public function __construct(string $theme = 'default', bool $open = false, bool $asChild = false)
    {
        $this->theme   = $theme;
        $this->open    = $open;
        $this->asChild = $asChild;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->view('components.dialog.dialog');
    }
}
