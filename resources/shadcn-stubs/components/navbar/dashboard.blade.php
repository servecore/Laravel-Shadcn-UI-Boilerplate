<nav class="border-b bg-background">
    <div class="flex h-16 items-center px-4 gap-4 container mx-auto">
        <!-- Dashboard Logo / Title -->
        <div class="hidden md:flex md:w-[200px]">
            <a href="/" class="font-bold flex items-center gap-2">
                <div class="size-8 rounded-full bg-primary flex items-center justify-center text-primary-foreground">
                    D
                </div>
                <span>Dashboard</span>
            </a>
        </div>
        
        <!-- Mobile Toggle (Placeholder - since dashboard usually has sidebar) -->
        <div class="md:hidden">
             <a href="/" class="font-bold flex items-center gap-2">
                <div class="size-8 rounded-full bg-primary flex items-center justify-center text-primary-foreground">
                    D
                </div>
            </a>
        </div>

        <!-- Search Bar -->
        <div class="flex-1 max-w-md mx-auto hidden md:block">
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-2.5 top-2.5 size-4 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" placeholder="Search..." class="w-full h-9 rounded-md border border-input bg-transparent px-3 py-1 pl-9 text-sm shadow-sm transition-colors focus-visible:outline-hidden focus-visible:ring-1 focus-visible:ring-ring" />
            </div>
        </div>
        
        <!-- Right Icons -->
        <div class="ml-auto flex items-center gap-4">
            <x-button variant="ghost" size="icon" class="rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </x-button>
            
            <x-dropdown.dropdown align="end">
                <x-slot:trigger>
                     <div class="size-8 rounded-full bg-muted overflow-hidden border cursor-pointer hover:ring-2 hover:ring-ring hover:ring-offset-2 transition-all">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" alt="Avatar" class="h-full w-full object-cover" />
                     </div>
                </x-slot:trigger>

                <div class="w-56">
                    <x-dropdown.label class="font-normal">
                        <div class="flex flex-col space-y-1">
                            <p class="text-sm font-medium leading-none">Felix</p>
                            <p class="text-xs leading-none text-muted-foreground">felix@example.com</p>
                        </div>
                    </x-dropdown.label>
                    <x-dropdown.separator />
                    <div class="flex flex-col gap-1">
                        <x-dropdown.item>Profile</x-dropdown.item>
                        <x-dropdown.item>Billing</x-dropdown.item>
                        <x-dropdown.item>Settings</x-dropdown.item>
                    </div>
                    <x-dropdown.separator />
                    <x-dropdown.item>Log out</x-dropdown.item>
                </div>
            </x-dropdown.dropdown>
        </div>
    </div>
</nav>
