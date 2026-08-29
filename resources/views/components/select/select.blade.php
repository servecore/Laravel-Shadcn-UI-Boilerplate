@props([
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'disabled' => false,
])
@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->merge([
        'x-data' => '{
            open: false,
            value: ' . json_encode((string) ($value ?? '')) . ',
            placeholder: ' . json_encode((string) $placeholder) . ',
            disabled: ' . json_encode((bool) $disabled) . '
        }',
    ]);
@endphp

<div {{ $attributes }} class="relative">
    <input type="hidden" name="{{ $name }}" x-model="value" />
    {{ $slot }}
</div>