@props([
    'active' => false,
    'class' => '',
])

@php
    $base = 'flex h-7 min-w-0 -translate-x-px items-center gap-2 overflow-hidden rounded-md px-2 text-sidebar-foreground outline-hidden ring-sidebar-ring hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&>svg]:size-4 [&>svg]:shrink-0 [&>svg]:text-sidebar-accent-foreground text-sm';
@endphp

<a
    data-slot="sidebar-menu-sub-button"
    data-sidebar="menu-sub-button"
    data-active="{{ $active ? 'true' : 'false' }}"
    {{ $attributes }}
    class="{{ $base }} {{ $active ? 'bg-sidebar-accent text-sidebar-accent-foreground font-medium' : '' }} {{ $class }}"
>
    {{ $slot }}
</a>
