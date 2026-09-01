@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->merge([
        'x-ref' => 'fallback',
    ])
    ->class([
        'flex h-full w-full items-center justify-center rounded-full bg-muted text-[0.65rem] font-medium text-foreground ring-1 ring-border/60',
        'hidden' => $delay !== 0,
    ]);
@endphp

@if($asChild)
    <x-compile-as-child :$slot :$attributes />
@else
    <span {{ $attributes }}>
        {{ $slot }}
    </span>
@endif
