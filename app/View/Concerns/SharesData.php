<?php

namespace App\View\Concerns;

/**
 * SharesData trait for sharing data between parent and child components.
 * 
 * This trait provides functionality to share data from a parent component
 * to its child components through the view.
 */
trait SharesData
{
    /**
     * Share data with child components.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     */
    public function share(string $key, mixed $value): static
    {
        view()->share($key, $value);

        return $this;
    }

    /**
     * Get shared data by key.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function getShared(string $key, mixed $default = null): mixed
    {
        return view()->shared($key, $default);
    }
}
