<div x-data="theme" class="flex items-center gap-2">
    <x-button variant="outline" size="icon" class="relative" @click="cycleTheme()">
        <!-- Sun Icon (Light) -->
        <svg x-show="theme === 'light'" 
             class="h-[1.2rem] w-[1.2rem] transition-all" 
             xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="4"></circle>
            <path d="M12 2v2"></path>
            <path d="M12 20v2"></path>
            <path d="m4.93 4.93 1.41 1.41"></path>
            <path d="m17.66 17.66 1.41 1.41"></path>
            <path d="M2 12h2"></path>
            <path d="M20 12h2"></path>
            <path d="m6.34 17.66-1.41 1.41"></path>
            <path d="m19.07 4.93-1.41 1.41"></path>
        </svg>

        <!-- Moon Icon (Dark) -->
        <svg x-show="theme === 'dark'" x-cloak
             class="absolute h-[1.2rem] w-[1.2rem] transition-all" 
             xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
        </svg>

        <!-- Laptop Icon (System) -->
        <svg x-show="theme === 'system'" x-cloak
             class="absolute h-[1.2rem] w-[1.2rem] transition-all" 
             xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect width="20" height="14" x="2" y="3" rx="2"></rect>
            <line x1="8" x2="16" y1="21" y2="21"></line>
            <line x1="12" x2="12" y1="17" y2="21"></line>
        </svg>
        <span class="sr-only">Toggle theme</span>
    </x-button>
</div>
