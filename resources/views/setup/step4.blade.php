@extends('layouts.setup')

@section('title', 'Create Admin Account')
@section('subtitle', 'Create the administrator account for your application')

@section('content')
<x-card>
    <x-card-header>
        <x-card-title>Admin Account</x-card-title>
        <x-card-description>
            Create the first administrator account. This account will have full access to the application.
        </x-card-description>
    </x-card-header>
    <x-card-content>
        @if ($errors->any())
            <div class="mb-4 p-4 rounded-lg bg-destructive/10 border border-destructive/20 text-destructive text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('setup.complete') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Name --}}
            <div class="space-y-2">
                <x-label for="name">Full Name</x-label>
                <x-input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="John Doe"
                    required
                    autofocus
                />
            </div>

            {{-- Username --}}
            <div class="space-y-2">
                <x-label for="username">Username</x-label>
                <x-input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    placeholder="admin"
                    required
                />
                <p class="text-xs text-muted-foreground">This will be used for login.</p>
            </div>

            {{-- Email --}}
            <div class="space-y-2">
                <x-label for="email">Email Address</x-label>
                <x-input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="admin@example.com"
                    required
                />
            </div>

            {{-- Password --}}
            <div class="space-y-2">
                <x-label for="password">Password</x-label>
                <x-input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    required
                />
                <p class="text-xs text-muted-foreground">Must be at least 8 characters.</p>
            </div>

            {{-- Confirm Password --}}
            <div class="space-y-2">
                <x-label for="password_confirmation">Confirm Password</x-label>
                <x-input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="••••••••"
                    required
                />
            </div>

            {{-- Navigation --}}
            <div class="flex justify-between pt-4">
                <a href="{{ route('setup.step3') }}">
                    <x-button variant="outline" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back
                    </x-button>
                </a>

                <x-button type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Complete Setup
                </x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
