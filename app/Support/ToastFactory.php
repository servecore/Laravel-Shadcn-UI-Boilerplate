<?php

namespace App\Support;

class ToastFactory
{
    public function add(
        string $title = '',
        string $description = '',
        string $variant = 'default',
        int $duration = 4000,
    ): static {
        session()->push('toast', [
            'title' => $title,
            'description' => $description,
            'variant' => $variant,
            'duration' => $duration,
        ]);

        return $this;
    }

    public function default(string $description, ?string $title = null, int $duration = 4000): static
    {
        return $this->add($title ?? 'Notification', $description, 'default', $duration);
    }

    public function success(string $description, ?string $title = null, int $duration = 4000): static
    {
        return $this->add($title ?? 'Success', $description, 'success', $duration);
    }

    public function info(string $description, ?string $title = null, int $duration = 4000): static
    {
        return $this->add($title ?? 'Information', $description, 'default', $duration);
    }

    public function warning(string $description, ?string $title = null, int $duration = 5000): static
    {
        return $this->add($title ?? 'Warning', $description, 'warning', $duration);
    }

    public function error(string $description, ?string $title = null, int $duration = 5000): static
    {
        return $this->add($title ?? 'Error', $description, 'destructive', $duration);
    }
}
