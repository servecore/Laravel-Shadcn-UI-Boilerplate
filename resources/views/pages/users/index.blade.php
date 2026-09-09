@extends('layouts.app')

@section('title', 'Users')
@section('header', 'Users')

@section('content')
    <div class="space-y-6" data-entity="users" data-fetch-url="{{ route('users.index') }}">
        <!-- Page Header -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <x-breadcrumb>
                <x-breadcrumb-list>
                    <x-breadcrumb-item>
                        <x-breadcrumb-link href="{{ route('dashboard') }}">Dashboard</x-breadcrumb-link>
                    </x-breadcrumb-item>
                    <x-breadcrumb-separator />
                    <x-breadcrumb-item>
                        <x-breadcrumb-page>Users</x-breadcrumb-page>
                    </x-breadcrumb-item>
                </x-breadcrumb-list>
            </x-breadcrumb>

            <x-button id="btn-create-user" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add User
            </x-button>
        </div>

        <!-- Filters & Search -->
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-2.5 top-2.5 size-4 text-muted-foreground" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <x-input class="pl-9 w-64" placeholder="Search users..." />
                </div>
                <x-select.select>
                    <x-select.trigger class="w-[150px]">
                        <x-select.value placeholder="Status" />
                    </x-select.trigger>
                    <x-select.content>
                        <x-select.item value="all">All Status</x-select.item>
                        <x-select.item value="active">Active</x-select.item>
                        <x-select.item value="inactive">Inactive</x-select.item>
                    </x-select.content>
                </x-select.select>
            </div>
        </div>

        <!-- Users Table -->
        <x-table.table>
                <x-table.header>
                    <x-table.row>
                        <x-table.head class="text-left">Actions</x-table.head>
                        <x-table.head>User</x-table.head>
                        <x-table.head>Role</x-table.head>
                        <x-table.head>Status</x-table.head>
                        <x-table.head  class="text-left">Joined</x-table.head>
                    </x-table.row>
                </x-table.header>
                <x-table.body id="users-table-body">
                    @forelse($users as $user)
                        <x-table.row class="hover:bg-muted/50 transition-colors">
                            <x-table.cell class="text-left">
                                <span data-action="edit" data-user-id="{{ $user->getRouteKey() }}" class="text-sm text-blue-500 cursor-pointer">
                                    <x-lucide-edit class="size-4 inline-block mr-1" />
                                </span>
                                <span data-action="delete" data-user-id="{{ $user->getRouteKey() }}" class="text-sm text-red-500 cursor-pointer">
                                    <x-lucide-trash class="size-4 inline-block mr-1" />
                                </span>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex items-center gap-3">
                                    <x-avatar class="size-9">
                                        <x-avatar-fallback>{{ substr($user->name, 0, 2) }}</x-avatar-fallback>
                                    </x-avatar>
                                    <div class="grid gap-0.5">
                                        <p class="text-sm font-medium leading-none">{{ $user->name }}</p>
                                        <p class="text-xs text-muted-foreground">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </x-table.cell>
                            <x-table.cell>
                                <x-badge variant="outline">User</x-badge>
                            </x-table.cell>
                            <x-table.cell>
                                @if($user->is_active)
                                    <div class="flex items-center gap-2">
                                        <div class="size-2 rounded-full bg-emerald-500"></div>
                                        <span class="text-sm text-muted-foreground">Active</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2">
                                        <div class="size-2 rounded-full bg-gray-300"></div>
                                        <span class="text-sm text-muted-foreground">Inactive</span>
                                    </div>
                                @endif
                            </x-table.cell>
                            <x-table.cell class="text-muted-foreground">
                                {{ $user->created_at->diffForHumans() }}
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="5" class="h-24 text-center">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-8 text-muted-foreground/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <p class="text-sm text-muted-foreground">No users found.</p>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-table.body>
            </x-table.table>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="flex justify-center">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
