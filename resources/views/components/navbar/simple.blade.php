<nav class="border-b bg-background">
    <div class="flex h-16 items-center px-4 md:px-6 container mx-auto">
        <!-- Logo -->
        <a href="/" class="flex items-center gap-2 font-bold text-lg mr-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            <span>Acme Inc</span>
        </a>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center gap-6 text-sm font-medium">
            <a href="#" class="transition-colors hover:text-primary">Features</a>
            <a href="#" class="transition-colors hover:text-primary text-muted-foreground">Pricing</a>
            <a href="#" class="transition-colors hover:text-primary text-muted-foreground">About</a>
            <a href="#" class="transition-colors hover:text-primary text-muted-foreground">Contact</a>
        </div>

        <!-- Right Side Actions -->
        <div class="ml-auto flex items-center gap-4">
            <div class="hidden md:flex items-center gap-4">
                <x-button variant="ghost" size="sm">Log in</x-button>
                <x-button size="sm">Sign up</x-button>
            </div>
            
            <!-- Mobile Menu Trigger -->
            <x-sheet.sheet>
                <x-sheet.trigger class="md:hidden">
                    <x-button variant="ghost" size="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                        <span class="sr-only">Toggle menu</span>
                    </x-button>
                </x-sheet.trigger>
                <x-sheet.content side="right">
                    <x-sheet.header class="text-left">
                        <x-sheet.title>Acme Inc</x-sheet.title>
                        <x-sheet.description>Navigate through our application.</x-sheet.description>
                    </x-sheet.header>
                    <div class="flex flex-col gap-4 mt-8">
                        <a href="#" class="text-lg font-medium hover:text-primary">Features</a>
                        <a href="#" class="text-lg font-medium hover:text-primary text-muted-foreground">Pricing</a>
                        <a href="#" class="text-lg font-medium hover:text-primary text-muted-foreground">About</a>
                        <a href="#" class="text-lg font-medium hover:text-primary text-muted-foreground">Contact</a>
                        <div class="h-px bg-border my-2"></div>
                        <div class="flex gap-4">
                            <x-button variant="ghost" class="w-full justify-center">Log in</x-button>
                            <x-button class="w-full justify-center">Sign up</x-button>
                        </div>
                    </div>
                </x-sheet.content>
            </x-sheet.sheet>
        </div>
    </div>
</nav>
