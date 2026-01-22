<?php

namespace App\View\Components\Card;

use App\View\Concerns\SharesData;
use Illuminate\View\Component;
use Illuminate\View\View;

class Card extends Component
{
    use SharesData;

    /**
     * The style theme of the alert.
     *
     * @var string
     */
    public string $theme;

    /**
     * Change the default rendered element for the one passed as a child, merging their props and behavior.
     *
     * @var bool
     */
    public bool $asChild;

    /**
     * Create a new component instance.
     */
    public function __construct(string $theme = 'default', bool $asChild = false)
    {
        $this->theme   = $theme;
        $this->asChild = $asChild;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        $this->share(
            views   : [
                'components.card.card-content',
                'components.card.card-description',
                'components.card.card-footer',
                'components.card.card-header',
                'components.card.card-title',
            ],
            callback: fn(array $data, View $view) => [
                'theme' => $this->theme,
            ]
        );

        return $this->view('components.card.card');
    }
}
