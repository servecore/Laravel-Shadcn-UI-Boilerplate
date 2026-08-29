@extends('layouts.app')

@section('header', 'Dashboard')

@section('content')
<div class="space-y-6">
    {{-- Welcome Banner --}}
    <x-card>
        <x-card-header>
            <x-card-title>Welcome back, {{ auth()->user()->name ?? 'User' }}!</x-card-title>
            <x-card-description>Here's what's happening with your application today.</x-card-description>
        </x-card-header>
    </x-card>

    {{-- Stats Cards --}}
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
        <x-card>
            <x-card-header class="flex flex-row items-center justify-between space-y-0 pb-2">
                <x-card-title class="text-sm font-medium">Total Users</x-card-title>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </x-card-header>
            <x-card-content>
                <div class="text-2xl font-bold">{{ \App\Models\User::count() }}</div>
                <p class="text-xs text-muted-foreground">Registered users</p>
            </x-card-content>
        </x-card>

        <x-card>
            <x-card-header class="flex flex-row items-center justify-between space-y-0 pb-2">
                <x-card-title class="text-sm font-medium">Active Sessions</x-card-title>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </x-card-header>
            <x-card-content>
                <div class="text-2xl font-bold">1</div>
                <p class="text-xs text-muted-foreground">Current session</p>
            </x-card-content>
        </x-card>

        <x-card>
            <x-card-header class="flex flex-row items-center justify-between space-y-0 pb-2">
                <x-card-title class="text-sm font-medium">Application</x-card-title>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </x-card-header>
            <x-card-content>
                <div class="text-2xl font-bold">{{ config('app.name', 'Laravel') }}</div>
                <p class="text-xs text-muted-foreground">Laravel {{ app()->version() }}</p>
            </x-card-content>
        </x-card>

        <x-card>
            <x-card-header class="flex flex-row items-center justify-between space-y-0 pb-2">
                <x-card-title class="text-sm font-medium">Environment</x-card-title>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </x-card-header>
            <x-card-content>
                <div class="text-2xl font-bold capitalize">{{ config('app.env', 'production') }}</div>
                <p class="text-xs text-muted-foreground">Current environment</p>
            </x-card-content>
        </x-card>
    </div>

    {{-- Quick Actions --}}
    <x-card>
        <x-card-header>
            <x-card-title>Quick Actions</x-card-title>
            <x-card-description>Get started with your application.</x-card-description>
        </x-card-header>
        <x-card-content>
            <div class="flex flex-wrap gap-3">
                <x-button variant="outline" href="{{ route('demo.users.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Manage Users
                </x-button>
                <x-button variant="outline" href="{{ route('demo.users.profile') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    </svg>
                    Edit Profile
                </x-button>
                <x-button variant="outline" href="{{ route('demo.settings') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Settings
                </x-button>
            </div>
        </x-card-content>
    </x-card>
</div>
@endsection
