@props([
    'class' => '',
])

<div
    {{ $attributes->class([
        'flex shrink-0 items-center gap-2',
        $class,
    ]) }}
>
    {{ $slot }}
</div>