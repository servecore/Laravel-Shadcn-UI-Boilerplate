@props([
    'asChild' => false,
    'class' => '',
])

<div 
    class="bg-muted flex items-center gap-2 rounded-md border px-4 text-sm font-medium shadow-xs 
           [&_svg]:pointer-events-none 
           [&_svg:not([class*='size-'])]:size-4 {{ $class }}"
>
    {{ $slot }}
</div>
