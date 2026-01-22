@props(['placeholder' => ''])

@php

    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->class([
        'truncate',
    ]);
@endphp

<span {{ $attributes }} x-text="value || placeholder || '{{ $placeholder }}'">
    {{ $slot }}
</span>