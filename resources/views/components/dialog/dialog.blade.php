@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->merge([
        'x-data' => '{ open: ' . ($open ? 'true' : 'false') . ' }',
        'x-show' => 'open',
        'x-transition:enter' => 'ease-out duration-300',
        'x-transition:enter-start' => 'opacity-0',
        'x-transition:enter-end' => 'opacity-100',
        'x-transition:leave' => 'ease-in duration-200',
        'x-transition:leave-start' => 'opacity-100',
        'x-transition:leave-end' => 'opacity-0',
        'role' => 'dialog',
        'aria-modal' => 'true',
        'style' => 'display: none;',
    ]);
@endphp

<div {{ $attributes }}>
    <div class="fixed inset-0 z-50 bg-black/80" x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false"></div>
    <div class="fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-background p-6 shadow-lg duration-200 sm:rounded-lg" x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
        {{ $slot }}
    </div>
</div>