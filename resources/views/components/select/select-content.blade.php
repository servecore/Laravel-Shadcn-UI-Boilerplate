@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->class([
        'relative z-50 min-w-[8rem] overflow-hidden rounded-md border bg-popover text-popover-foreground shadow-md',
    ])->merge([
        'x-show' => 'open',
        'x-transition:enter' => 'transition ease-out duration-100',
        'x-transition:enter-start' => 'transform opacity-0 scale-95',
        'x-transition:enter-end' => 'transform opacity-100 scale-100',
        'x-transition:leave' => 'transition ease-in duration-75',
        'x-transition:leave-start' => 'transform opacity-100 scale-100',
        'x-transition:leave-end' => 'transform opacity-0 scale-95',
        '@click.away' => 'open = false',
        'style' => 'display: none;',
    ]);
@endphp

<div {{ $attributes }}>
    {{ $slot }}
</div>