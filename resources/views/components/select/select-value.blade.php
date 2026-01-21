@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->class([
        'truncate',
    ]);
@endphp

<span {{ $attributes }}>
    {{ $slot }}
</span>