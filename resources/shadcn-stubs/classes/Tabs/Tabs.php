<?php

namespace App\View\Components\Tabs;

use Illuminate\View\Component;
use Illuminate\View\View;

class Tabs extends Component
{
    /**
     * The style theme of the component.
     *
     * @var string
     */
    public string $theme;

    /**
     * The default active tab value.
     *
     * @var string
     */
    public string $defaultValue;

    /**
     * The orientation of the tabs.
     *
     * @var string
     */
    public string $orientation;

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
        string $defaultValue = '',
        string $orientation = 'horizontal',
        bool $asChild = false
    ) {
        $this->theme        = $theme;
        $this->defaultValue = $defaultValue;
        $this->orientation  = $orientation;
        $this->asChild      = $asChild;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->view('components.tabs.tabs');
    }
}
