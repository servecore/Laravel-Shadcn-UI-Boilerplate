<div
    x-data="{ open: false }"
    x-on:mouseenter="open = true"
    x-on:mouseleave="open = false"
    class="relative"
>
    <div
        data-slot="dropdown-menu-sub-trigger"
        class="flex items-center gap-2 px-2 py-1.5 text-sm rounded-sm cursor-pointer
               focus:bg-accent focus:text-accent-foreground"
    >
        {{ $slot }}
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-auto size-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
    </div>
    
    <div
        x-show="open"
        x-transition
        x-cloak
        class="absolute left-full top-0 ml-1 min-w-[8rem] rounded-md border bg-popover p-1 shadow-lg"
        data-slot="dropdown-menu-sub-content"
    >
        {{ $submenu }}
    </div>
</div>
