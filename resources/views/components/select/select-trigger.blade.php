@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->class([
        'flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50',
    ])->merge([
        '@click' => 'open = !open',
        ':class' => '{ "ring-2 ring-ring ring-offset-2": open }',
        'x-bind:disabled' => 'disabled',
    ]);
@endphp

<button type="button" {{ $attributes }}>
    {{ $slot }}
    <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M7 9l5 5 5-5"/>
    </svg>
</button>