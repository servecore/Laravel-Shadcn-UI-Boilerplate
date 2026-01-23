@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->class([
        'inline-flex h-10 items-center justify-center rounded-md bg-muted p-1 text-muted-foreground',
    ]);
@endphp

<div {{ $attributes }}>
    {{ $slot }}
</div>