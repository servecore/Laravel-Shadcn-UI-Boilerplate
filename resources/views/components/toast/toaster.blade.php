@props([
    'position' => 'bottom-right', 
    'expand' => false, 
    'duration' => 4000
])

@php
    $positions = [
        'top-left' => 'top-0 left-0',
        'top-center' => 'top-0 left-1/2 -translate-x-1/2',
        'top-right' => 'top-0 right-0',
        'bottom-left' => 'bottom-0 left-0',
        'bottom-center' => 'bottom-0 left-1/2 -translate-x-1/2',
        'bottom-right' => 'bottom-0 right-0',
    ];

    $positionClasses = $positions[$position] ?? $positions['bottom-right'];
@endphp

<div
    x-data="{ 
        toasts: [],
        add(event) {
            const toast = {
                id: Date.now(),
                title: event.detail.title || 'Notification',
                description: event.detail.description || event.detail.message || '',
                variant: event.detail.variant || 'default', // default, destructive, success, warning
                duration: event.detail.duration || {{ $duration }},
            };
            this.toasts.push(toast);
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
    }"
    @notify.window="add($event)"
    class="fixed z-[100] flex max-h-screen w-full flex-col-reverse p-4 sm:right-0 sm:flex-col md:max-w-[420px] {{ $positionClasses }}"
    style="pointer-events: none;"
>
    <!-- Toasts container -->
    <template x-for="toast in toasts" :key="toast.id">
        <div class="pointer-events-auto mt-2">
            <x-toast.item />
        </div>
    </template>
</div>
