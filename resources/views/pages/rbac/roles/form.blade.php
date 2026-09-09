@extends('layouts.app')

@section('title', $role ? 'Edit Role' : 'Create Role')
@section('header', $role ? 'Edit Role' : 'Create Role')

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
                    <x-breadcrumb-link href="{{ route('roles.index') }}">Roles</x-breadcrumb-link>
                </x-breadcrumb-item>
                <x-breadcrumb-separator />
                <x-breadcrumb-item>
                    <x-breadcrumb-page>{{ $role ? 'Edit' : 'Create' }}</x-breadcrumb-page>
                </x-breadcrumb-item>
            </x-breadcrumb-list>
        </x-breadcrumb>

        <form class="space-y-8" method="POST" action="{{ $role ? route('roles.update', $role) : route('roles.store') }}">
            @csrf
            @if($role)
                @method('PUT')
            @endif

            <x-card>
                <x-card-header>
                    <x-card-title>Role Information</x-card-title>
                    <x-card-description>Basic details about the role.</x-card-description>
                </x-card-header>
                <x-card-content class="space-y-6">
                    <div class="space-y-2">
                        <x-label for="name">Name</x-label>
                        <x-input id="name" name="name" placeholder="e.g. editor" value="{{ old('name', $role->name ?? '') }}" required />
                        @error('name')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
                    </div>
                </x-card-content>
                <x-card-footer class="border-t bg-muted/50 px-6 py-4">
                    <div class="flex items-center justify-end gap-2 w-full">
                        <x-button type="button" variant="ghost" href="{{ route('roles.index') }}">Cancel</x-button>
                        <x-button type="submit">{{ $role ? 'Save Changes' : 'Create Role' }}</x-button>
                    </div>
                </x-card-footer>
            </x-card>
        </form>
    </div>
@endsection
