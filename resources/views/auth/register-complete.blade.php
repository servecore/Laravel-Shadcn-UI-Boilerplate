@extends('layouts.guest')

@section('title', 'Complete Registration')

@section('content')
<div class="space-y-6">
    {{-- Logo & Title --}}
    <div class="text-center space-y-2">
        <div class="flex justify-center">
            <div class="flex size-12 items-center justify-center rounded-xl bg-primary text-primary-foreground shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
        </div>
        <h1 class="text-2xl font-bold tracking-tight">Set up your account</h1>
        <p class="text-muted-foreground break-all">
            <span class="text-primary font-medium">{{ $email }}</span>
        </p>
    </div>

    {{-- Complete Registration Form Card --}}
    <x-card>
        <x-card-content class="pt-6">
            <form class="space-y-4" action="{{ route('register.complete.store', $token) }}" method="POST">
                @csrf

                @if ($errors->any())
                    <x-alert variant="destructive">
                        <x-alert-title>Unable to continue</x-alert-title>
                        <x-alert-description>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </x-alert-description>
                    </x-alert>
                @endif

                {{-- Name --}}
                <div class="space-y-2">
                    <x-label for="name">Full Name</x-label>
                    <x-input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="John Doe"
                        :value="old('name')"
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
                        placeholder="johndoe"
                        :value="old('username')"
                        required
                    />
                </div>

                {{-- Password --}}
                <div class="space-y-2">
                    <x-label for="password">Password</x-label>
                    <div class="relative" x-data="{ show: false }">
                        <x-input
                            class="pr-10"
                            type="password"
                            x-bind:type="show ? 'text' : 'password'"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            required
                        />
                        <button
                            type="button"
                            x-on:click="show = !show"
                            :aria-label="show ? 'Hide password' : 'Show password'"
                            x-bind:aria-pressed="show"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-muted-foreground hover:text-foreground focus:outline-none"
                        >
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <svg x-show="show" x-cloak xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49" />
                                <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242" />
                                <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143" />
                                <path d="m2 2 20 20" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-muted-foreground">Must be at least 8 characters</p>
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

                {{-- Submit --}}
                <x-button type="submit" class="w-full">
                    Create account
                </x-button>
            </form>
        </x-card-content>
    </x-card>
</div>
@endsection
