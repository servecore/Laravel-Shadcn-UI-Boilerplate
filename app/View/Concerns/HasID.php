<?php

namespace App\View\Concerns;

use Illuminate\Support\Str;

/**
 * HasID trait for generating unique IDs for components.
 *
 * This trait provides functionality to generate and manage
 * unique IDs for UI components.
 */
trait HasID
{
    /**
     * The component ID.
     * 
     * @var string|null
     */
    public ?string $id = null;

    /**
     * Generate or get a unique ID for the component.
     *
     * @param string $prefix Optional prefix for the generated ID
     *
     * @return string
     */
    public function id(string $prefix = ''): string
    {
        if ($this->id === null) {
            $this->id = $prefix . '-' . Str::random(8);
        }

        return $this->id;
    }

    /**
     * Generate a unique ID for the component (alias for id()).
     *
     * @param string $prefix Optional prefix for the generated ID
     *
     * @return string
     */
    public function generateId(string $prefix = ''): string
    {
        return $this->id($prefix);
    }

    /**
     * Set the component ID.
     *
     * @param string $id
     *
     * @return $this
     */
    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the component ID.
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }
}
