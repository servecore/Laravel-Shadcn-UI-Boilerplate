@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->merge([
        'x-data' => '{
            activeTab: ' . json_encode((string) $defaultValue) . '
        }',
    ]);
@endphp

<div {{ $attributes }}>
    {{ $slot }}
</div>