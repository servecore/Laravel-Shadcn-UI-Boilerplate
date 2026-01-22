{{-- Shortcut component for keyboard shortcuts in dropdown items --}}
@props(['class' => ''])

<span 
    data-slot="dropdown-menu-shortcut" 
    {{ $attributes->merge(['class' => 'ml-auto text-xs tracking-widest text-muted-foreground ' . $class]) }}
>
    {{ $slot }}
</span>
