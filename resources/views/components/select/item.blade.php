@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->class([
        'relative flex w-full cursor-default select-none items-center rounded-sm py-1.5 pl-8 pr-2 text-sm outline-none focus:bg-accent focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50',
    ])->merge([
        '@click' => "value = '{$value}'; open = false",
        'role' => 'option',
    ]);
@endphp

<div {{ $attributes }}>
    <span class="absolute left-2 flex h-3.5 w-3.5 items-center justify-center">
        <svg x-show="value === '{{ $value }}'" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 6L9 17l-5-5"/>
        </svg>
    </span>
    {{ $slot }}
</div>