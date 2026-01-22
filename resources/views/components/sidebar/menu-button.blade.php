@props([
    'active' => false,
    'variant' => 'default',
    'size' => 'default',
    'tooltip' => null,
    'href' => null,
    'class' => '',
])

@php
    $base =
        'peer/menu-button flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left text-sm outline-hidden ring-sidebar-ring transition hover:bg-sidebar-accent hover:text-sidebar-accent-foreground active:bg-sidebar-accent active:text-sidebar-accent-foreground disabled:pointer-events-none disabled:opacity-50 [&_svg]:size-4 [&_svg]:shrink-0';

    $variants = [
        'default' => '',
        'outline' => 'bg-background shadow-[0_0_0_1px_hsl(var(--sidebar-border))]',
    ];

    $sizes = [
        'default' => 'h-8 text-sm',
        'sm' => 'h-7 text-xs',
        'lg' => 'h-12 text-sm',
    ];

    $classes = $base.' '.($variants[$variant] ?? '').' '.($sizes[$size] ?? '').' '.$class;
    
    $tag = $href ? 'a' : 'button';
@endphp

@if($href)
{{-- Link version when href is provided --}}
<a
    href="{{ $href }}"
    data-slot="sidebar-menu-button"
    data-sidebar="menu-button"
    data-active="{{ $active ? 'true' : 'false' }}"
    x-bind:class="{
        'justify-center !p-2': $data.state === 'collapsed',
    }"
    class="{{ $classes }} {{ $active ? 'bg-sidebar-accent text-sidebar-accent-foreground font-medium' : '' }}"
    @if ($tooltip)
        x-bind:title="$data.state === 'collapsed' ? '{{ e($tooltip) }}' : ''"
    @endif
>
    {{-- Icon slot - always visible --}}
    @isset($icon)
        <span class="shrink-0">{{ $icon }}</span>
    @endisset

    {{-- Label - hidden when collapsed --}}
    <span
        class="truncate"
        x-show="$data.state === 'expanded'"
        x-transition:enter="transition-opacity duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        {{ $slot }}
    </span>
</a>
@else
{{-- Button version when no href --}}
<button
    type="button"
    data-slot="sidebar-menu-button"
    data-sidebar="menu-button"
    data-active="{{ $active ? 'true' : 'false' }}"
    x-bind:class="{
        'justify-center !p-2': $data.state === 'collapsed',
    }"
    class="{{ $classes }} {{ $active ? 'bg-sidebar-accent text-sidebar-accent-foreground font-medium' : '' }}"
    @if ($tooltip)
        x-bind:title="$data.state === 'collapsed' ? '{{ e($tooltip) }}' : ''"
    @endif
>
    {{-- Icon slot - always visible --}}
    @isset($icon)
        <span class="shrink-0">{{ $icon }}</span>
    @endisset

    {{-- Label - hidden when collapsed --}}
    <span
        class="truncate"
        x-show="$data.state === 'expanded'"
        x-transition:enter="transition-opacity duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        {{ $slot }}
    </span>
</button>
@endif
