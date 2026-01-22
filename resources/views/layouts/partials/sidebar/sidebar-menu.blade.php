{{-- 
    Sidebar Navigation Menu
    This file contains all navigation groups and menu items.
    
    Structure:
    - Platform Group: Main navigation (Dashboard, Users, Projects, Reports)
    - Settings Group: Settings navigation (Profile, General)
    
    Multi-level menu examples included for reference.
--}}

{{-- Platform Group --}}
<x-sidebar.group>
    <x-sidebar.group-label>Platform</x-sidebar.group-label>
    <x-sidebar.group-content>
        <x-sidebar.menu>
            {{-- Dashboard --}}
            <x-sidebar.menu-item>
                <x-sidebar.menu-button :active="request()->routeIs('demo.dashboard')" tooltip="Dashboard" href="{{ route('demo.dashboard') }}">
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </x-slot:icon>
                    Dashboard
                </x-sidebar.menu-button>
            </x-sidebar.menu-item>

            {{-- Users --}}
            <x-sidebar.menu-item>
                <x-sidebar.menu-button :active="request()->routeIs('demo.users.*')" tooltip="Users" href="{{ route('demo.users.index') }}">
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </x-slot:icon>
                    Users
                </x-sidebar.menu-button>
            </x-sidebar.menu-item>

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

{{-- Settings Group --}}
<x-sidebar.group>
    <x-sidebar.group-label>Settings</x-sidebar.group-label>
    <x-sidebar.group-content>
        <x-sidebar.menu>
            {{-- Profile --}}
            <x-sidebar.menu-item>
                <x-sidebar.menu-button :active="request()->routeIs('demo.users.profile')" tooltip="Profile" href="{{ route('demo.users.profile') }}">
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </x-slot:icon>
                    Profile
                </x-sidebar.menu-button>
            </x-sidebar.menu-item>

            {{-- General Settings --}}
             <x-sidebar.menu-item>
                <x-sidebar.menu-button :active="request()->routeIs('demo.settings')" tooltip="General" href="{{ route('demo.settings') }}">
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </x-slot:icon>
                    General
                </x-sidebar.menu-button>
            </x-sidebar.menu-item>
        </x-sidebar.menu>
    </x-sidebar.group-content>
</x-sidebar.group>
