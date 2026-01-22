<?php

namespace App\View\Components\Tabs;

use Illuminate\View\Component;
use Illuminate\View\View;

class TabsTrigger extends Component
{
    /**
     * The value of the tab trigger.
     *
     * @var string
     */
    public string $value;

    /**
     * Change the default rendered element for the one passed as a child, merging their props and behavior.
     *
     * @var bool
     */
    public bool $asChild;

    /**
     * Create a new component instance.
     */
    public function __construct(string $value, bool $asChild = false)
    {
        $this->value   = $value;
        $this->asChild = $asChild;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->view('components.tabs.tabs-trigger');
    }
}
