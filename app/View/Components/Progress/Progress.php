<?php

namespace App\View\Components\Progress;

use Illuminate\View\Component;
use Illuminate\View\View;

class Progress extends Component
{
    /**
     * The style theme of the component.
     *
     * @var string
     */
    public string $theme;

    /**
     * The progress value (0-100).
     *
     * @var float
     */
    public float $value;

    /**
     * The maximum value.
     *
     * @var float
     */
    public float $max;

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
        float $value = 0,
        float $max = 100,
        bool $asChild = false
    ) {
        $this->theme   = $theme;
        $this->value   = $value;
        $this->max     = $max;
        $this->asChild = $asChild;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->view('components.progress.progress');
    }
}
