<?php

namespace App\View\Components\Toast;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Toaster extends Component
{
    public array $initialToasts;
    public string $positionClasses;
    public string $position;

    private const POSITIONS = [
        'top-left'      => 'top-0 left-0',
        'top-center'    => 'top-0 left-1/2 -translate-x-1/2',
        'top-right'     => 'top-0 right-0',
        'bottom-left'   => 'bottom-0 left-0',
        'bottom-center' => 'bottom-0 left-1/2 -translate-x-1/2',
        'bottom-right'  => 'bottom-0 right-0',
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(
        ?string $position = null,
        public bool $expand = false,
        public int $duration = 4000,
    ) {
        $this->initialToasts = session()->pull('toast', []);

        $this->position = $position
            ?? \App\Models\Setting::get('toast.position', 'top-right');

        $this->positionClasses = self::POSITIONS[$this->position]
            ?? self::POSITIONS['top-right'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.toast.toaster');
    }
}