@extends('layouts.app')

@section('header', 'Settings')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="space-y-0.5">
        <h2 class="text-2xl font-bold tracking-tight">Settings</h2>
        <p class="text-muted-foreground">Manage your account settings and preferences.</p>
    </div>
    
    <x-separator.separator class="my-6" />

    <div class="flex flex-col space-y-8 lg:flex-row lg:space-x-12 lg:space-y-0">
        {{-- Sidebar Navigation --}}
        <aside class="-mx-4 lg:mx-0 lg:w-1/5">
            <nav class="flex space-x-2 lg:flex-col lg:space-x-0 lg:space-y-1">
                <a href="#" class="inline-flex items-center rounded-md bg-muted px-3 py-2 text-sm font-medium hover:bg-muted">
                    Profile
                </a>
                <a href="#" class="inline-flex items-center rounded-md px-3 py-2 text-sm font-medium hover:bg-transparent hover:underline hover:decoration-primary">
                    Account
                </a>
                <a href="#" class="inline-flex items-center rounded-md px-3 py-2 text-sm font-medium hover:bg-transparent hover:underline hover:decoration-primary">
                    Appearance
                </a>
                <a href="#" class="inline-flex items-center rounded-md px-3 py-2 text-sm font-medium hover:bg-transparent hover:underline hover:decoration-primary">
                    Notifications
                </a>
            </nav>
        </aside>

        {{-- Content --}}
        <div class="flex-1 lg:max-w-2xl">
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-medium">Profile</h3>
                    <p class="text-sm text-muted-foreground">This is how others will see you on the site.</p>
                </div>
                
                <x-separator.separator />

                <form class="space-y-8" method="POST" action="{{ route('users.profile.update') }}">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="space-y-2">
                        <x-label for="name">Name</x-label>
                        <x-input id="name" name="name" placeholder="Your name" value="{{ auth()->user()->name }}" required />
                        @error('name')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
                    </div>

                    {{-- Email --}}
                    <div class="space-y-2">
                        <x-label for="email">Email</x-label>
                        <x-input id="email" name="email" type="email" placeholder="your@email.com" value="{{ auth()->user()->email }}" required />
                        @error('email')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
                    </div>

                    <x-button type="submit">Update profile</x-button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
