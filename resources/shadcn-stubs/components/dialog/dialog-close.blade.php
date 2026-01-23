@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->merge([
        '@click' => 'open = false',
    ]);
@endphp

<div {{ $attributes }}>
    {{ $slot }}
</div>