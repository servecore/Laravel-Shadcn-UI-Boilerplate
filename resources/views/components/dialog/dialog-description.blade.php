@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->class([
        'text-sm text-muted-foreground',
    ]);
@endphp

<p {{ $attributes }}>
    {{ $slot }}
</p>