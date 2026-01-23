@props([
    'isActive' => false,
    'disabled' => false,
    'size' => 'icon',
    'class' => '',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50';
    
    $variant = $isActive 
        ? 'border border-input bg-primary text-primary-foreground shadow-sm hover:bg-primary/80' 
        : 'hover:bg-accent hover:text-accent-foreground';
    
    $sizes = [
        'default' => 'h-9 px-4 py-2',
        'sm' => 'h-8 px-3 text-xs',
        'lg' => 'h-10 px-8',
        'icon' => 'size-9',
    ];
@endphp

<a
    data-slot="pagination-link"
    aria-current="{{ $isActive ? 'page' : 'false' }}"
    {{ $attributes->merge([
        'class' => $base . ' ' . $variant . ' ' . ($sizes[$size] ?? $sizes['icon']) . ' ' . $class
    ]) }}
>
    {{ $slot }}
</a>
