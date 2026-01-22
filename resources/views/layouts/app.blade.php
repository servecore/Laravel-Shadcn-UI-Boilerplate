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
            {{-- 
                Sidebar Header (Brand/Logo)
                Edit: layouts/partials/sidebar-header.blade.php
            --}}
            <x-sidebar.header>
                @include('layouts.partials.sidebar.sidebar-header')
            </x-sidebar.header>

            {{-- 
                Sidebar Content (Navigation Menu)
                Edit: layouts/partials/sidebar-menu.blade.php
                
                Multi-level menu examples:
                - layouts/partials/sidebar-menu-projects.blade.php (2 levels)
                - layouts/partials/sidebar-menu-reports.blade.php (3 levels)
            --}}
            <x-sidebar.content>
                @include('layouts.partials.sidebar.sidebar-menu')
            </x-sidebar.content>

            {{-- 
                Sidebar Footer (User Profile Dropdown)
                Edit: layouts/partials/sidebar-footer.blade.php
            --}}
            <x-sidebar.footer>
                @include('layouts.partials.sidebar.sidebar-footer')
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

            <footer class="border-t p-4">
                <p class="text-sm text-muted-foreground text-left">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
                </p>
            </footer>
        </x-sidebar.inset>
    </x-sidebar.provider>
</body>
</html>
