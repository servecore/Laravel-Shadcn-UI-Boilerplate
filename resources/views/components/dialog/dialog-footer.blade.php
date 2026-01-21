@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->class([
        'flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2',
    ]);
@endphp

<div {{ $attributes }}>
    {{ $slot }}
</div>