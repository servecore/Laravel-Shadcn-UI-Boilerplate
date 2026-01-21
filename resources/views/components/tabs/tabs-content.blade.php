@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->class([
        'mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2',
    ])->merge([
        'x-show' => 'activeTab === "' . $value . '"',
        'x-transition:enter' => 'transition ease-out duration-300',
        'x-transition:enter-start' => 'opacity-0',
        'x-transition:enter-end' => 'opacity-100',
        'x-transition:leave' => 'transition ease-in duration-200',
        'x-transition:leave-start' => 'opacity-100',
        'x-transition:leave-end' => 'opacity-0',
        'style' => 'display: none;',
    ]);
@endphp

<div {{ $attributes }}>
    {{ $slot }}
</div>