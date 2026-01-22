@props([
    'orientation' => 'horizontal',
    'class' => '',
])

<div
    data-slot="separator"
    {{ $attributes->merge([
        'class' => 'shrink-0 bg-border ' . 
           ($orientation === 'horizontal' ? 'h-[1px] w-full' : 'h-full w-[1px]') . 
           ' ' . $class
    ]) }}
></div>
