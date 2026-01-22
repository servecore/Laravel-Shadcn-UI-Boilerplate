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
            <div x-data="{ open: false }" class="md:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center rounded-md p-2 hover:bg-muted hover:text-foreground focus:outline-none ring-offset-background focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                    <span class="sr-only">Toggle menu</span>
                </button>
                
                <!-- Mobile Menu Content -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     @click.away="open = false"
                     class="absolute top-16 left-0 right-0 z-50 border-b bg-background p-4 shadow-lg md:hidden">
                    <div class="flex flex-col gap-4">
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
                </div>
            </div>
        </div>
    </div>
</nav>
