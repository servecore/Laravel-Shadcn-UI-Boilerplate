@props(['side' => 'right'])

@php
    $sideClasses = [
        'top' => 'inset-x-0 top-0 border-b',
        'bottom' => 'inset-x-0 bottom-0 border-t',
        'left' => 'inset-y-0 left-0 h-full w-3/4 border-r sm:max-w-sm',
        'right' => 'inset-y-0 right-0 h-full w-3/4 border-l sm:max-w-sm',
    ];
    
    $transitionEnterStart = match($side) {
        'right' => 'translate-x-full',
        'left' => '-translate-x-full',
        'top' => '-translate-y-full',
        'bottom' => 'translate-y-full',
        default => 'translate-x-full',
    };
    
    $transitionLeaveEnd = match($side) {
        'right' => 'translate-x-full',
        'left' => '-translate-x-full',
        'top' => '-translate-y-full',
        'bottom' => 'translate-y-full',
        default => 'translate-x-full',
    };

    $baseClass = $sideClasses[$side] ?? $sideClasses['right'];
@endphp

<template x-teleport="body">
    <div class="sheet-teleport-wrapper">
        <!-- Overlay -->
        <div x-show="open" 
             style="display: none;" 
             class="fixed inset-0 z-50 bg-black/80"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="open = false"
        ></div>

        <!-- Sheet Content -->
        <div x-show="open" 
             style="display: none;" 
             {{ $attributes->merge(['class' => 'fixed z-50 gap-4 bg-background p-6 shadow-lg transition ease-in-out duration-300 ' . $baseClass]) }}
             x-transition:enter="transition ease-in-out duration-500 transform"
             x-transition:enter-start="{{ $transitionEnterStart }}"
             x-transition:enter-end="translate-x-0 translate-y-0"
             x-transition:leave="transition ease-in-out duration-500 transform"
             x-transition:leave-start="translate-x-0 translate-y-0"
             x-transition:leave-end="{{ $transitionLeaveEnd }}"
        >
            <div class="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none data-[state=open]:bg-secondary">
                <button @click="open = false" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            
            {{ $slot }}
        </div>
    </div>
</template>
