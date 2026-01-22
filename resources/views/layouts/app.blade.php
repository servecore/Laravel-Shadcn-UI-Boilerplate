<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Laravel') }}</title>
    <x-theme-script />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-foreground font-sans antialiased">
    <x-sidebar.provider :defaultOpen="true" variant="sidebar" collapsible="icon">
        <x-sidebar.sidebar collapsible="icon">
            <x-sidebar.header>
                <div class="flex items-center gap-2 px-2">
                    <div class="flex size-8 items-center justify-center rounded-lg bg-primary text-primary-foreground shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="flex flex-col gap-0.5 group-data-[collapsible=icon]:hidden">
                        <span class="font-semibold">{{ config('app.name', 'Laravel') }}</span>
                        <span class="text-xs text-muted-foreground">Boilerplate</span>
                    </div>
                </div>
            </x-sidebar.header>

            <x-sidebar.content>
                {{-- Platform Group --}}
                <x-sidebar.group>
                    <x-sidebar.group-label>Platform</x-sidebar.group-label>
                    <x-sidebar.group-content>
                        <x-sidebar.menu>
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
                        </x-sidebar.menu>
                    </x-sidebar.group-content>
                </x-sidebar.group>

                {{-- Settings Group --}}
                <x-sidebar.group>
                    <x-sidebar.group-label>Settings</x-sidebar.group-label>
                    <x-sidebar.group-content>
                        <x-sidebar.menu>
                            <x-sidebar.menu-item>
                                <x-sidebar.menu-button :active="request()->routeIs('demo.profile')" tooltip="Profile" href="{{ route('demo.profile') }}">
                                    <x-slot:icon>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </x-slot:icon>
                                    Profile
                                </x-sidebar.menu-button>
                            </x-sidebar.menu-item>
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
            </x-sidebar.content>

            <x-sidebar.footer>
                <div class="p-1">
                    <x-dropdown.dropdown class="w-full">
                        <x-slot:trigger>
                            <x-sidebar.menu-button tooltip="User">
                                <x-slot:icon>
                                    <x-avatar class="size-6">
                                        <x-avatar-image src="https://github.com/shadcn.png" alt="User" />
                                        <x-avatar-fallback>JD</x-avatar-fallback>
                                    </x-avatar>
                                </x-slot:icon>
                                <span>John Doe</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 ml-auto opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                </svg>
                            </x-sidebar.menu-button>
                        </x-slot:trigger>
                        <div class="w-56">
                            <x-dropdown.label>My Account</x-dropdown.label>
                            <x-dropdown.separator />
                            <x-dropdown.item href="{{ route('demo.profile') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </x-dropdown.item>
                            <x-dropdown.item href="{{ route('demo.settings') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Settings
                            </x-dropdown.item>
                            <x-dropdown.separator />
                            <x-dropdown.item href="{{ route('demo.login') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Log out
                            </x-dropdown.item>
                        </div>
                    </x-dropdown.dropdown>
                </div>
            </x-sidebar.footer>
        </x-sidebar.sidebar>

        <x-sidebar.inset>
            <header class="flex h-16 items-center gap-4 border-b px-6 bg-background/95 backdrop-blur-sm sticky top-0 z-10 supports-backdrop-filter:bg-background/60">
                <x-sidebar.trigger />
                <div class="flex-1">
                    <h1 class="text-lg font-semibold truncate leading-none">@yield('header', 'Dashboard')</h1>
                </div>
                
                <div class="flex items-center gap-2">
                    {{-- Search (Fake) --}}
                    <div class="relative hidden sm:block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-2.5 top-2.5 size-4 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="search" placeholder="Search..." class="h-9 w-64 rounded-md border border-input bg-background pl-9 pr-4 text-sm outline-none placeholder:text-muted-foreground focus:ring-1 focus:ring-ring" />
                    </div>

                    {{-- Theme Toggle --}}
                    <x-theme-toggle />
                </div>
            </header>

            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </x-sidebar.inset>
    </x-sidebar.provider>
</body>
</html>
