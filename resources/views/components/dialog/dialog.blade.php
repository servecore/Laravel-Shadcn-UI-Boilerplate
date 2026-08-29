@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->merge([
        'x-data' => '{ open: ' . json_encode((bool) $open) . ' }',
        'role' => 'dialog',
        'aria-modal' => 'true',
    ]);
@endphp

<div {{ $attributes }}>
    {{ $slot }}
</div>