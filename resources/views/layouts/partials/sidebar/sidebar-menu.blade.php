{{-- 
    Sidebar Navigation Menu
    This file contains all navigation groups and menu items.
    
    Structure:
    - Platform Group: Dashboard, Access Control (Users, Roles, Permissions),
      and multi-level menu examples (Projects, Reports).
    
    Account actions (Profile, Settings, Logout) live in the user dropdown
    in sidebar-footer.blade.php, so nav stays clean.
--}}

{{-- Platform Group --}}
<x-sidebar.group>
    <x-sidebar.group-label>Platform</x-sidebar.group-label>
    <x-sidebar.group-content>
        <x-sidebar.menu>
            {{-- Dashboard --}}
            <x-sidebar.menu-item>
                <x-sidebar.menu-button :active="request()->routeIs('dashboard')" tooltip="Dashboard" href="{{ route('dashboard') }}">
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </x-slot:icon>
                    Dashboard
                </x-sidebar.menu-button>
            </x-sidebar.menu-item>

            {{-- Access Control (Users, Roles, Permissions) --}}
            @include('layouts.partials.sidebar.sidebar-menu-access-control')

            {{-- ============================================
                 MULTI-LEVEL MENU EXAMPLES
                 Copy and modify these for your own menus
            ============================================= --}}

            {{-- Example: Projects (2 levels) --}}
            @include('layouts.partials.sidebar.sidebar-menu-projects')

            {{-- Example: Reports (3 levels with nested submenu) --}}
            @include('layouts.partials.sidebar.sidebar-menu-reports')

        </x-sidebar.menu>
    </x-sidebar.group-content>
</x-sidebar.group>
