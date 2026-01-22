{{-- 
    Multi-Level Menu Example: Projects (2 Levels)
    
    This is a reference implementation showing how to create
    a collapsible menu with 2 levels using Alpine.js.
    
    Features:
    - Collapsible submenu with smooth animation (x-collapse)
    - Tooltip when sidebar is collapsed
    - Arrow rotation on expand
    
    Copy this file and modify for your own menus.
--}}
<li data-slot="sidebar-menu-item" x-data="{ projectsOpen: false }">
    <div 
        class="relative"
        @mouseenter="$data.state === 'collapsed' && (showTooltip = true)"
        @mouseleave="showTooltip = false"
        x-data="{ showTooltip: false }"
    >
        <button
            type="button"
            @click="projectsOpen = !projectsOpen"
            class="peer/menu-button relative flex w-full items-center gap-2 overflow-visible rounded-md p-2 text-left text-sm outline-hidden ring-sidebar-ring transition hover:bg-sidebar-accent hover:text-sidebar-accent-foreground [&_svg]:size-4 [&_svg]:shrink-0 h-8"
            x-bind:class="{ 'justify-center !p-2': $data.state === 'collapsed' }"
        >
            <span class="shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
            </span>
            <span class="truncate" x-show="$data.state === 'expanded'">Projects</span>
            <svg 
                x-show="$data.state === 'expanded'"
                xmlns="http://www.w3.org/2000/svg" 
                class="size-4 ml-auto transition-transform duration-200" 
                :class="{ 'rotate-90': projectsOpen }"
                fill="none" viewBox="0 0 24 24" stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        
        {{-- Tooltip when collapsed --}}
        <div
            x-show="showTooltip"
            x-transition
            class="absolute left-full top-1/2 -translate-y-1/2 ml-3 z-50 
                   rounded-md bg-popover border border-border px-3 py-1.5 text-sm text-popover-foreground 
                   whitespace-nowrap shadow-md pointer-events-none"
        >
            Projects
        </div>
    </div>
    
    {{-- Submenu Level 2 --}}
    <ul
        x-show="projectsOpen && $data.state === 'expanded'"
        x-collapse
        class="border-sidebar-border mx-3.5 flex min-w-0 translate-x-px flex-col gap-1 border-l px-2.5 py-0.5"
    >
        <li><a href="#" class="flex h-7 min-w-0 items-center gap-2 overflow-hidden rounded-md px-2 text-sidebar-foreground hover:bg-sidebar-accent hover:text-sidebar-accent-foreground text-sm">All Projects</a></li>
        <li><a href="#" class="flex h-7 min-w-0 items-center gap-2 overflow-hidden rounded-md px-2 text-sidebar-foreground hover:bg-sidebar-accent hover:text-sidebar-accent-foreground text-sm">Active</a></li>
        <li><a href="#" class="flex h-7 min-w-0 items-center gap-2 overflow-hidden rounded-md px-2 text-sidebar-foreground hover:bg-sidebar-accent hover:text-sidebar-accent-foreground text-sm">Archived</a></li>
    </ul>
</li>
