<?php

namespace App\View\Concerns;

use Closure;
use Illuminate\View\View;

/**
 * SharesData trait for sharing data between parent and child components.
 *
 * This trait provides functionality to share data from a parent component
 * to its child components through view composers.
 */
trait SharesData
{
    /**
     * Share data with specific views using a callback.
     *
     * @param  array  $views  Array of view names to share data with
     * @param  Closure  $callback  Callback that receives $data and $view, returns array of data to share
     * @return $this
     */
    public function share(array $views, Closure $callback): static
    {
        view()->composer($views, function (View $view) use ($callback) {
            $data = $view->getData();
            $shared = $callback($data, $view);

            foreach ($shared as $key => $value) {
                $view->with($key, $value);
            }
        });

        return $this;
    }

    /**
     * Get shared data by key from view.
     */
    public function getShared(string $key, mixed $default = null): mixed
    {
        return view()->shared($key, $default);
    }
}
