@props(['class' => ''])

<div 
    data-slot="sidebar-group-label"
    data-sidebar="group-label"
    class="text-sidebar-foreground/70 ring-sidebar-ring flex h-8 shrink-0 items-center 
    rounded-md px-2 text-xs font-medium uppercase tracking-wider outline-hidden transition-[margin,opacity] duration-200 
    ease-linear focus-visible:ring-2 [&>svg]:size-4 [&>svg]:shrink-0 {{ $class }}"
    x-show="$data.state === 'expanded'"
    x-transition:enter="transition-opacity duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    {{ $slot }}
</div>
