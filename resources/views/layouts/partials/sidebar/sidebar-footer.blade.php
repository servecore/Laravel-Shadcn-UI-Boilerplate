{{-- 
    Sidebar Footer with User Dropdown
    Edit this file to customize the user profile section in the sidebar footer
--}}
<div class="p-1">
    <div class="flex w-full items-center gap-1">
        <x-dropdown.dropdown class="flex-1 overflow-visible" side="top" align="start">
            <x-slot:trigger>
                <button
                    type="button"
                    class="flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-left text-sm transition-colors hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sidebar-ring"
                >
                    <x-avatar class="size-8 shrink-0 border border-sidebar-border bg-background shadow-xs">
                        <x-avatar-image src="{{ auth()->user()?->avatar ?? '' }}" alt="{{ auth()->user()->name ?? 'User' }}" />
                        <x-avatar-fallback class="bg-muted text-[0.65rem] font-medium text-foreground">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                        </x-avatar-fallback>
                    </x-avatar>

                    <div class="min-w-0 flex-1">
                        <div class="truncate font-medium leading-none">{{ auth()->user()->name ?? 'User' }}</div>
                        <div class="truncate text-[11px] text-muted-foreground leading-none mt-1">
                            {{ auth()->user()->email ?? 'user@example.com' }}
                        </div>
                    </div>
                </button>
            </x-slot:trigger>
            <div class="w-56">
                <x-dropdown.label>My Account</x-dropdown.label>
                <x-dropdown.separator />
                <x-dropdown.item href="{{ route('users.profile') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profile
                </x-dropdown.item>
                <x-dropdown.item href="{{ route('settings') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Settings
                </x-dropdown.item>
            </div>
        </x-dropdown.dropdown>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                title="Log out"
                aria-label="Log out"
                class="flex shrink-0 items-center justify-center rounded-md p-2 text-muted-foreground transition-colors hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sidebar-ring"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
        </form>
    </div>
</div>