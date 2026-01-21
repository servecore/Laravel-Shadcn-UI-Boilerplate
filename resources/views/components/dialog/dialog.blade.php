@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->merge([
        'x-data' => '{ open: ' . ($open ? 'true' : 'false') . ' }',
        'role' => 'dialog',
        'aria-modal' => 'true',
    ]);
@endphp

<div {{ $attributes }}>
    {{ $slot }}
</div>