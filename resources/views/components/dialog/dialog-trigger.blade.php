@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->merge([
        '@click' => 'open = true',
    ]);
@endphp

<button {{ $attributes }}>
    {{ $slot }}
</button>