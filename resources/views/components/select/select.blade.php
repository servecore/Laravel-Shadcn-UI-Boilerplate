@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->merge([
        'x-data' => '{
            open: false,
            value: "' . ($value ?? '') . '",
            placeholder: "' . $placeholder . '",
            disabled: ' . ($disabled ? 'true' : 'false') . '
        }',
    ]);
@endphp

<div {{ $attributes }} class="relative">
    <input type="hidden" name="{{ $name }}" x-model="value" />
    {{ $slot }}
</div>