@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->merge([
        '@click' => 'open = true',
    ]);
@endphp

<div {{ $attributes }}>
    {{ $slot }}
</div>