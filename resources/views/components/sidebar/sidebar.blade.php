@props([
    'collapsible' => '',
    'variant' => 'sidebar',
    'side' => 'left',
])

{{-- MOBILE OVERLAY (Sheet/Drawer) --}}
<div 
    x-show="openMobile"
    x-cloak
    class="fixed inset-0 z-50 md:hidden"
>
    {{-- Backdrop --}}
    <div 
        x-show="openMobile"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="openMobile = false"
        class="fixed inset-0 bg-black/50"
    ></div>
    
    {{-- Mobile Sidebar Panel --}}
    <div 
        x-show="openMobile"
        x-transition:enter="transition ease-in-out duration-300 transform"
        x-transition:enter-start="{{ $side === 'left' ? '-translate-x-full' : 'translate-x-full' }}"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="{{ $side === 'left' ? '-translate-x-full' : 'translate-x-full' }}"
        class="fixed inset-y-0 {{ $side === 'left' ? 'left-0' : 'right-0' }} z-50 w-[280px] bg-sidebar border-r border-sidebar-border"
    >
        {{-- Close button --}}
        <button 
            @click="openMobile = false"
            class="absolute top-4 right-4 p-2 rounded-md hover:bg-sidebar-accent"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
            <span class="sr-only">Close menu</span>
        </button>
        
        {{-- Sidebar content --}}
        <div class="flex h-full w-full flex-col overflow-y-auto pt-14">
            {{ $slot }}
        </div>
    </div>
</div>

{{-- DESKTOP SIDEBAR --}}
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
