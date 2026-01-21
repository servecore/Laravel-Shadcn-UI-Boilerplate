@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->class([
        'text-lg font-semibold leading-none tracking-tight',
    ]);
@endphp

<h2 {{ $attributes }}>
    {{ $slot }}
</h2>