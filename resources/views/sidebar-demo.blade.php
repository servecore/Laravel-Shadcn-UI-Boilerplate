<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Demo - ShadCN UI</title>
    <x-theme-script />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-foreground">
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
                        <span class="font-semibold">Acme Corp</span>
                        <span class="text-xs text-muted-foreground">Enterprise</span>
                    </div>
                </div>
            </x-sidebar.header>

            <x-sidebar.content>
                <x-sidebar.group>
                    <x-sidebar.group-label>Platform</x-sidebar.group-label>
                    <x-sidebar.group-content>
                        <x-sidebar.menu>
                            <x-sidebar.menu-item>
                                <x-sidebar.menu-button :active="true" tooltip="Dashboard">
                                    <x-slot:icon>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </x-slot:icon>
                                    Dashboard
                                </x-sidebar.menu-button>
                            </x-sidebar.menu-item>

                            {{-- Multi-level Menu: Projects --}}
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
                                    {{-- Tooltip --}}
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
                                
                                {{-- Submenu --}}
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

                            {{-- Multi-level Menu: Reports --}}
                            <li data-slot="sidebar-menu-item" x-data="{ reportsOpen: false }">
                                <div 
                                    class="relative"
                                    @mouseenter="$data.state === 'collapsed' && (showTooltip = true)"
                                    @mouseleave="showTooltip = false"
                                    x-data="{ showTooltip: false }"
                                >
                                    <button
                                        type="button"
                                        @click="reportsOpen = !reportsOpen"
                                        class="peer/menu-button relative flex w-full items-center gap-2 overflow-visible rounded-md p-2 text-left text-sm outline-hidden ring-sidebar-ring transition hover:bg-sidebar-accent hover:text-sidebar-accent-foreground [&_svg]:size-4 [&_svg]:shrink-0 h-8"
                                        x-bind:class="{ 'justify-center !p-2': $data.state === 'collapsed' }"
                                    >
                                        <span class="shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                        </span>
                                        <span class="truncate" x-show="$data.state === 'expanded'">Reports</span>
                                        <svg 
                                            x-show="$data.state === 'expanded'"
                                            xmlns="http://www.w3.org/2000/svg" 
                                            class="size-4 ml-auto transition-transform duration-200" 
                                            :class="{ 'rotate-90': reportsOpen }"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                    {{-- Tooltip --}}
                                    <div
                                        x-show="showTooltip"
                                        x-transition
                                        class="absolute left-full top-1/2 -translate-y-1/2 ml-3 z-50 
                                               rounded-md bg-popover border border-border px-3 py-1.5 text-sm text-popover-foreground 
                                               whitespace-nowrap shadow-md pointer-events-none"
                                    >
                                        Reports
                                    </div>
                                </div>
                                
                                {{-- Submenu --}}
                                <ul
                                    x-show="reportsOpen && $data.state === 'expanded'"
                                    x-collapse
                                    class="border-sidebar-border mx-3.5 flex min-w-0 translate-x-px flex-col gap-1 border-l px-2.5 py-0.5"
                                >
                                    <li><a href="#" class="flex h-7 min-w-0 items-center gap-2 overflow-hidden rounded-md px-2 text-sidebar-foreground hover:bg-sidebar-accent hover:text-sidebar-accent-foreground text-sm">Sales Report</a></li>
                                    <li><a href="#" class="flex h-7 min-w-0 items-center gap-2 overflow-hidden rounded-md px-2 text-sidebar-foreground hover:bg-sidebar-accent bg-sidebar-accent font-medium text-sm">Analytics</a></li>
                                    <li><a href="#" class="flex h-7 min-w-0 items-center gap-2 overflow-hidden rounded-md px-2 text-sidebar-foreground hover:bg-sidebar-accent hover:text-sidebar-accent-foreground text-sm">Finance</a></li>
                                    <li><a href="#" class="flex h-7 min-w-0 items-center gap-2 overflow-hidden rounded-md px-2 text-sidebar-foreground hover:bg-sidebar-accent hover:text-sidebar-accent-foreground text-sm">Inventory</a></li>
                                </ul>
                            </li>

                            <x-sidebar.menu-item>
                                <x-sidebar.menu-button tooltip="Team">
                                    <x-slot:icon>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </x-slot:icon>
                                    Team
                                </x-sidebar.menu-button>
                            </x-sidebar.menu-item>
                        </x-sidebar.menu>
                    </x-sidebar.group-content>
                </x-sidebar.group>

                <x-sidebar.group>
                    <x-sidebar.group-label>Settings</x-sidebar.group-label>
                    <x-sidebar.group-content>
                        <x-sidebar.menu>
                            <x-sidebar.menu-item>
                                <x-sidebar.menu-button tooltip="General">
                                    <x-slot:icon>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </x-slot:icon>
                                    General
                                </x-sidebar.menu-button>
                            </x-sidebar.menu-item>

                            <x-sidebar.menu-item>
                                <x-sidebar.menu-button tooltip="Security">
                                    <x-slot:icon>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </x-slot:icon>
                                    Security
                                </x-sidebar.menu-button>
                            </x-sidebar.menu-item>
                        </x-sidebar.menu>
                    </x-sidebar.group-content>
                </x-sidebar.group>
            </x-sidebar.content>

            <x-sidebar.footer>
                <x-sidebar.menu>
                    <x-sidebar.menu-item>
                        <x-sidebar.menu-button tooltip="John Doe">
                            <x-slot:icon>
                                <x-avatar class="size-6">
                                    <x-avatar-image src="https://github.com/shadcn.png" alt="User" />
                                    <x-avatar-fallback>JD</x-avatar-fallback>
                                </x-avatar>
                            </x-slot:icon>
                            John Doe
                        </x-sidebar.menu-button>
                    </x-sidebar.menu-item>
                </x-sidebar.menu>
            </x-sidebar.footer>
        </x-sidebar.sidebar>

        <x-sidebar.inset>
            <header class="flex h-16 items-center gap-4 border-b px-6">
                <x-sidebar.trigger />
                <div class="flex-1">
                    <h1 class="text-lg font-semibold">Dashboard</h1>
                </div>
                <x-theme-toggle />
            </header>

            <main class="flex-1 p-6">
                <div class="space-y-6">
                    <x-card>
                        <x-card-header>
                            <x-card-title>Sidebar Demo</x-card-title>
                            <x-card-description>
                                This is a demo of the Sidebar component from rustam76/shadcn-blade.
                            </x-card-description>
                        </x-card-header>
                        <x-card-content>
                            <div class="space-y-4">
                                <p>Features:</p>
                                <ul class="list-disc list-inside space-y-1 text-muted-foreground">
                                    <li>Collapsible sidebar (click the trigger button)</li>
                                    <li>Keyboard shortcut: <kbd class="px-2 py-0.5 bg-muted rounded text-xs">⌘ + B</kbd> or <kbd class="px-2 py-0.5 bg-muted rounded text-xs">Ctrl + B</kbd></li>
                                    <li>Cookie persistence to remember state</li>
                                    <li>Mobile responsive (offcanvas)</li>
                                    <li>Active state highlighting</li>
                                    <li>Tooltip on hover when collapsed</li>
                                    <li><strong>Multi-level navigation</strong> (click Projects or Reports)</li>
                                </ul>
                            </div>
                        </x-card-content>
                    </x-card>

                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                        @foreach(['Total Revenue', 'Subscriptions', 'Sales', 'Active Now'] as $i => $title)
                        <x-card>
                            <x-card-header class="flex flex-row items-center justify-between space-y-0 pb-2">
                                <x-card-title class="text-sm font-medium">{{ $title }}</x-card-title>
                            </x-card-header>
                            <x-card-content>
                                <div class="text-2xl font-bold">+{{ ($i + 1) * 1234 }}</div>
                                <p class="text-xs text-muted-foreground">+{{ 10 + $i * 5 }}% from last month</p>
                            </x-card-content>
                        </x-card>
                        @endforeach
                    </div>
                </div>
            </main>
        </x-sidebar.inset>
    </x-sidebar.provider>
</body>
</html>
