{{--
    Access Control (2 levels)
    Groups Users, Roles, and Permissions under a collapsible parent menu.
    Items are permission-gated; the parent auto-opens when a child route is active.
--}}
@canany(['manage-users', 'manage-roles', 'manage-permissions'])
    <li data-slot="sidebar-menu-item" x-data="{ accessOpen: {{ request()->routeIs(['users.*', 'roles.*', 'permissions.*']) ? 'true' : 'false' }} }">
        <div
            class="relative"
            @mouseenter="$data.state === 'collapsed' && (showTooltip = true)"
            @mouseleave="showTooltip = false"
            x-data="{ showTooltip: false }"
        >
            <button
                type="button"
                @click="accessOpen = !accessOpen"
                class="peer/menu-button relative flex w-full items-center gap-2 overflow-visible rounded-md p-2 text-left text-sm outline-hidden ring-sidebar-ring transition hover:bg-sidebar-accent hover:text-sidebar-accent-foreground [&_svg]:size-4 [&_svg]:shrink-0 h-8"
                x-bind:class="{ 'justify-center p-2!': $data.state === 'collapsed' }"
            >
                <span class="shrink-0">
                    <x-lucide-shield class="size-4" />
                </span>
                <span class="truncate" x-show="$data.state === 'expanded'">Access Control</span>
                <svg
                    x-show="$data.state === 'expanded'"
                    xmlns="http://www.w3.org/2000/svg"
                    class="size-4 ml-auto transition-transform duration-200"
                    :class="{ 'rotate-90': accessOpen }"
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
                Access Control
            </div>
        </div>

        {{-- Submenu Level 2 --}}
        <ul
            x-show="accessOpen && $data.state === 'expanded'"
            x-collapse
            class="border-sidebar-border mx-3.5 flex min-w-0 translate-x-px flex-col gap-1 border-l px-2.5 py-0.5"
        >
            @can('manage-users')
                <li>
                    <x-sidebar.menu-sub-button :active="request()->routeIs('users.*')" href="{{ route('users.index') }}">
                        Users
                    </x-sidebar.menu-sub-button>
                </li>
            @endcan

            @can('manage-roles')
                <li>
                    <x-sidebar.menu-sub-button :active="request()->routeIs('roles.*')" href="{{ route('roles.index') }}">
                        Roles
                    </x-sidebar.menu-sub-button>
                </li>
            @endcan

            @can('manage-permissions')
                <li>
                    <x-sidebar.menu-sub-button :active="request()->routeIs('permissions.*')" href="{{ route('permissions.index') }}">
                        Permissions
                    </x-sidebar.menu-sub-button>
                </li>
            @endcan
        </ul>
    </li>
@endcanany