@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->merge([
        '@click' => 'open = false',
    ]);
@endphp

<button {{ $attributes }}>
    {{ $slot }}
</button>