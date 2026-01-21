@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $percentage = min(100, max(0, ($value / $max) * 100));
    $attributes = $attributes->class([
        'relative h-4 w-full overflow-hidden rounded-full bg-secondary',
    ]);
@endphp

<div {{ $attributes }}>
    <div
        class="h-full w-full flex-1 bg-primary transition-all"
        style="transform: translateX(-{{ 100 - $percentage }}%)"
    ></div>
</div>