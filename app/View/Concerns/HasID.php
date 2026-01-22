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
    protected ?string $componentId = null;

    /**
     * Generate a unique ID for the component.
     *
     * @param string $prefix
     *
     * @return string
     */
    public function generateId(string $prefix = ''): string
    {
        if ($this->componentId === null) {
            $this->componentId = $prefix . Str::random(8);
        }

        return $this->componentId;
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
        $this->componentId = $id;

        return $this;
    }

    /**
     * Get the component ID.
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->componentId;
    }
}
