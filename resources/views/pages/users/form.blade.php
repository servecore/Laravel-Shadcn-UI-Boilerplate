@extends('layouts.app')

@section('title', $user ? 'Edit User' : 'Create User')
@section('header', $user ? 'Edit User' : 'Create User')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Breadcrumbs -->
        <x-breadcrumb>
            <x-breadcrumb-list>
                <x-breadcrumb-item>
                    <x-breadcrumb-link href="{{ route('dashboard') }}">Dashboard</x-breadcrumb-link>
                </x-breadcrumb-item>
                <x-breadcrumb-separator />
                <x-breadcrumb-item>
                    <x-breadcrumb-link href="{{ route('users.index') }}">Users</x-breadcrumb-link>
                </x-breadcrumb-item>
                <x-breadcrumb-separator />
                <x-breadcrumb-item>
                    <x-breadcrumb-page>{{ $user ? 'Edit' : 'Create' }}</x-breadcrumb-page>
                </x-breadcrumb-item>
            </x-breadcrumb-list>
        </x-breadcrumb>

        <form class="space-y-8" method="POST" action="{{ $user ? route('users.update', $user) : route('users.store') }}">
            @csrf
            @if($user)
                @method('PUT')
            @endif

            <x-card>
                <x-card-header>
                    <x-card-title>User Information</x-card-title>
                    <x-card-description>Basic details about the user.</x-card-description>
                </x-card-header>
                <x-card-content class="space-y-6">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="space-y-2">
                            <x-label for="name">Name</x-label>
                            <x-input id="name" name="name" placeholder="John" value="{{ old('name', $user->name ?? '') }}" required />
                            @error('name')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <x-label for="username">Username</x-label>
                            <x-input id="username" name="username" placeholder="johndoe" value="{{ old('username', $user->username ?? '') }}" required />
                            @error('username')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <x-label for="email">Email Address</x-label>
                        <x-input id="email" name="email" type="email" placeholder="john.doe@example.com" value="{{ old('email', $user->email ?? '') }}" required />
                        @error('email')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
                    </div>

                    @if(! $user)
                        <div class="space-y-2">
                            <x-label for="password">Password</x-label>
                            <x-input id="password" name="password" type="password" placeholder="Enter password" required />
                            @error('password')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
                        </div>

                        <div class="space-y-2">
                            <x-label for="password_confirmation">Confirm Password</x-label>
                            <x-input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm password" required />
                        </div>
                    @endif
                </x-card-content>
                <x-card-footer class="border-t bg-muted/50 px-6 py-4">
                    <div class="flex items-center justify-end gap-2 w-full">
                        <x-button type="button" variant="ghost" href="{{ route('users.index') }}">Cancel</x-button>
                        <x-button type="submit">{{ $user ? 'Save Changes' : 'Create User' }}</x-button>
                    </div>
                </x-card-footer>
            </x-card>
        </form>
    </div>
@endsection
