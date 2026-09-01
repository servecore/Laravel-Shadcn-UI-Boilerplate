@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->merge([
        'x-ref' => 'image',
        'hidden' => ''
    ])
    ->class(['aspect-square h-full w-full object-cover']);
@endphp

@if($asChild)
    <x-compile-as-child root="img" :$slot :$attributes />
@else
    <img {{ $attributes }}>
@endif

