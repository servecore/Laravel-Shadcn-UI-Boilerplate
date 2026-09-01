@props([
    'sideOffset' => 4,
    'side' => 'bottom',
    'align' => 'start',
])

<div
    x-data="{
        open: false,
        toggle() { this.open = !this.open; },
        close() { this.open = false; }
    }"
    @click.away="close()"
    @keydown.escape.prevent.stop="close()"
    class="relative inline-block w-full text-left"
    {{ $attributes }}
>
    <div
        x-on:click="toggle()"
        x-ref="trigger"
        data-slot="dropdown-menu-trigger"
        class="w-full"
    >
        {{ $trigger }}
    </div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        x-cloak
        x-ref="content"
        data-slot="dropdown-menu-content"
        data-side="{{ $side }}"
        data-align="{{ $align }}"
        class="absolute z-50 min-w-[10rem] rounded-md border bg-popover text-popover-foreground shadow-md p-1 origin-top
               data-[side=bottom]:top-full data-[side=bottom]:mt-2
               data-[side=top]:bottom-full data-[side=top]:mb-2
               data-[side=left]:right-full data-[side=left]:mr-2
               data-[side=right]:left-full data-[side=right]:ml-2
               data-[align=start]:left-0
               data-[align=end]:right-0
               data-[align=center]:left-1/2 data-[align=center]:-translate-x-1/2"
    >
        {{ $slot }}
    </div>
</div>
