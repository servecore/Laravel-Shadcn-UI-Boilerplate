@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->class([
        'flex flex-col space-y-1.5 text-center sm:text-left',
    ]);
@endphp

<div {{ $attributes }}>
    {{ $slot }}
</div>