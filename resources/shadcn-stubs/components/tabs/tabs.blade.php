@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->merge([
        'x-data' => '{
            activeTab: "' . $defaultValue . '"
        }',
    ]);
@endphp

<div {{ $attributes }}>
    {{ $slot }}
</div>