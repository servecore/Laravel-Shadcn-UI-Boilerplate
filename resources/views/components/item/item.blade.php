@props([
    'variant' => 'default',
])

@php
    $classes = [
        'flex w-full items-center gap-4 rounded-lg border p-4',
        'transition-colors hover:bg-muted/50' => $variant === 'default',
        'bg-muted/50' => $variant === 'muted',
        'border-input' => $variant === 'outline',
    ];
@endphp

<div {{ $attributes->class($classes) }}>
    {{ $slot }}
</div>