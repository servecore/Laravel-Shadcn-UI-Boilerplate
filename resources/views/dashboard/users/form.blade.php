@extends('layouts.app')

@section('title', request()->routeIs('demo.users.create') ? 'Create User' : 'Edit User')
@section('header', request()->routeIs('demo.users.create') ? 'Create User' : 'Edit User')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Breadcrumbs -->
        <x-breadcrumb>
            <x-breadcrumb-list>
                <x-breadcrumb-item>
                    <x-breadcrumb-link href="{{ route('demo.dashboard') }}">Dashboard</x-breadcrumb-link>
                </x-breadcrumb-item>
                <x-breadcrumb-separator />
                <x-breadcrumb-item>
                    <x-breadcrumb-link href="{{ route('demo.users.index') }}">Users</x-breadcrumb-link>
                </x-breadcrumb-item>
                <x-breadcrumb-separator />
                <x-breadcrumb-item>
                    <x-breadcrumb-page>{{ request()->routeIs('demo.users.create') ? 'Create' : 'Edit' }}</x-breadcrumb-page>
                </x-breadcrumb-item>
            </x-breadcrumb-list>
        </x-breadcrumb>

        <form class="space-y-8">
            <x-card>
                <x-card-header>
                    <x-card-title>User Information</x-card-title>
                    <x-card-description>Basic details about the user.</x-card-description>
                </x-card-header>
                <x-card-content class="space-y-6">
                    <!-- Avatar Upload -->
                    <div class="flex items-center gap-6">
                        <x-avatar class="size-20">
                            <x-avatar-image src="https://github.com/shadcn.png" alt="Avatar" />
                            <x-avatar-fallback>JD</x-avatar-fallback>
                        </x-avatar>
                        <div class="space-y-2">
                            <x-label>Profile Picture</x-label>
                            <div class="flex gap-2">
                                <x-button type="button" variant="outline" size="sm">Change</x-button>
                                <x-button type="button" variant="ghost" size="sm" class="text-destructive">Remove</x-button>
                            </div>
                            <p class="text-xs text-muted-foreground">JPG, GIF or PNG. 1MB Max.</p>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="space-y-2">
                            <x-label for="first_name">First Name</x-label>
                            <x-input id="first_name" placeholder="John" value="{{ request()->routeIs('demo.users.edit') ? 'John' : '' }}" />
                        </div>
                        <div class="space-y-2">
                            <x-label for="last_name">Last Name</x-label>
                            <x-input id="last_name" placeholder="Doe" value="{{ request()->routeIs('demo.users.edit') ? 'Doe' : '' }}" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <x-label for="email">Email Address</x-label>
                        <x-input id="email" type="email" placeholder="john.doe@example.com" value="{{ request()->routeIs('demo.users.edit') ? 'john.doe@example.com' : '' }}" />
                    </div>
                </x-card-content>
            </x-card>

            <x-card>
                <x-card-header>
                    <x-card-title>Role & Permissions</x-card-title>
                    <x-card-description>Assign roles and manage access status.</x-card-description>
                </x-card-header>
                <x-card-content class="space-y-6">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="space-y-2">
                            <x-label>Role</x-label>
                            <x-select.select>
                                <x-select.trigger>
                                    <x-select.value placeholder="Select a role" />
                                </x-select.trigger>
                                <x-select.content>
                                    <x-select.item value="admin">Administrator</x-select.item>
                                    <x-select.item value="manager">Manager</x-select.item>
                                    <x-select.item value="editor">Editor</x-select.item>
                                    <x-select.item value="viewer">Viewer</x-select.item>
                                </x-select.content>
                            </x-select.select>
                        </div>
                        <div class="space-y-2">
                            <x-label>Status</x-label>
                            <x-select.select>
                                <x-select.trigger>
                                    <x-select.value placeholder="Select status" />
                                </x-select.trigger>
                                <x-select.content>
                                    <x-select.item value="active">Active</x-select.item>
                                    <x-select.item value="inactive">Inactive</x-select.item>
                                    <x-select.item value="suspended">Suspended</x-select.item>
                                </x-select.content>
                            </x-select.select>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <x-switch.switch id="mfa" />
                        <x-label for="mfa">Require Two-Factor Authentication</x-label>
                    </div>
                </x-card-content>
                <x-card-footer class="border-t bg-muted/50 px-6 py-4">
                    <div class="flex items-center justify-end gap-2 w-full">
                        <x-button type="button" variant="ghost" href="{{ route('demo.users.index') }}">Cancel</x-button>
                        <x-button type="submit">Save Changes</x-button>
                    </div>
                </x-card-footer>
            </x-card>
        </form>
    </div>
@endsection
