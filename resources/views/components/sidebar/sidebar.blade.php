@props([
    'collapsible' => '',
    'variant' => 'sidebar',
    'side' => 'left',
])

<div 
    data-slot="sidebar"
    x-bind:data-state="state"
    data-collapsible="{{ $collapsible }}"
    data-variant="{{ $variant }}"
    data-side="{{ $side }}"
    class="group peer text-sidebar-foreground hidden md:block"
>
    {{-- CONTAINER --}}
    <div 
        data-slot="sidebar-container"
        class="fixed inset-y-0 z-10 hidden h-svh 
        transition-[left,right,width] duration-200 ease-linear md:flex
        {{ ($side) === 'left' ? 'left-0' : 'right-0' }}
        @if(($variant) === 'floating' || ($variant) === 'inset')
            p-2
        @else
            group-data-[side=left]:border-r group-data-[side=right]:border-l
        @endif"
        x-bind:class="{
            'w-[var(--sidebar-width)]': $data.state === 'expanded',
            'w-[var(--sidebar-width-icon)]': $data.state === 'collapsed' && '{{ $collapsible }}' === 'icon',
            'left-[calc(var(--sidebar-width)*-1)]': '{{ $side }}' === 'left' && '{{ $collapsible }}' === 'offcanvas' && $data.state === 'collapsed',
            'right-[calc(var(--sidebar-width)*-1)]': '{{ $side }}' === 'right' && '{{ $collapsible }}' === 'offcanvas' && $data.state === 'collapsed',
        }"
    >
        <div 
            data-slot="sidebar-inner"
            data-sidebar="sidebar"
            class="bg-sidebar flex h-full w-full flex-col 
              @if(($variant) === 'floating')
                  border-sidebar-border rounded-lg border shadow-sm
              @endif"
        >
            {{ $slot }}
        </div>
    </div>
</div>
