@php
    /* @var Illuminate\View\ComponentAttributeBag $attributes */
    $attributes = $attributes->class([
        'inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50',
        'bg-background text-foreground shadow-sm' => 'activeTab === "' . $value . '"',
        'hover:text-foreground/80' => 'activeTab !== "' . $value . '"',
    ])->merge([
        '@click' => 'activeTab = "' . $value . '"',
        ':class' => 'activeTab === "' . $value . '" ? "bg-background text-foreground shadow-sm" : "hover:text-foreground/80"',
        'type' => 'button',
    ]);
@endphp

<button {{ $attributes }}>
    {{ $slot }}
</button>