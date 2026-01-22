@extends('layouts.app')

@section('title', 'Users')
@section('header', 'Users')

@section('content')
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <x-breadcrumb>
                <x-breadcrumb-list>
                    <x-breadcrumb-item>
                        <x-breadcrumb-link href="{{ route('demo.dashboard') }}">Dashboard</x-breadcrumb-link>
                    </x-breadcrumb-item>
                    <x-breadcrumb-separator />
                    <x-breadcrumb-item>
                        <x-breadcrumb-page>Users</x-breadcrumb-page>
                    </x-breadcrumb-item>
                </x-breadcrumb-list>
            </x-breadcrumb>

            <x-dialog>
                <x-dialog-trigger>
                    <x-button>
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add User
                    </x-button>
                </x-dialog-trigger>
                <x-dialog-content>
                    <x-dialog-header>
                        <x-dialog-title>Add New User</x-dialog-title>
                        <x-dialog-description>
                            Fill in the details below to create a new user account.
                        </x-dialog-description>
                    </x-dialog-header>
                    
                    <form class="space-y-4 py-4">
                        <div class="space-y-2">
                            <x-label for="name">Full Name</x-label>
                            <x-input id="name" placeholder="Enter full name" />
                        </div>
                        
                        <div class="space-y-2">
                            <x-label for="email">Email Address</x-label>
                            <x-input id="email" type="email" placeholder="Enter email address" />
                        </div>
                        
                        <div class="space-y-2">
                            <x-label for="role">Role</x-label>
                            <x-select.select>
                                <x-select.trigger class="w-full">
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
                            <x-label for="password">Password</x-label>
                            <x-input id="password" type="password" placeholder="Enter password" />
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <x-checkbox id="send-email" />
                            <x-label for="send-email" class="text-sm font-normal">Send welcome email to user</x-label>
                        </div>
                    </form>
                    
                    <x-dialog-footer>
                        <x-dialog-close>
                            <x-button variant="outline">Cancel</x-button>
                        </x-dialog-close>
                        <x-button type="submit">Create User</x-button>
                    </x-dialog-footer>
                </x-dialog-content>
            </x-dialog>
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
        <div class="rounded-md border bg-card text-card-foreground shadow-sm">
            <x-table.table>
                <x-table.header>
                    <x-table.row>
                        <x-table.head class="w-[50px]"></x-table.head>
                        <x-table.head>User</x-table.head>
                        <x-table.head>Role</x-table.head>
                        <x-table.head>Status</x-table.head>
                        <x-table.head>Joined</x-table.head>
                        <x-table.head class="text-right">Actions</x-table.head>
                    </x-table.row>
                </x-table.header>
                <x-table.body>
                    @php
                        $users = [
                            [
                                'name' => 'John Doe',
                                'email' => 'john.doe@example.com',
                                'role' => 'Administrator',
                                'status' => 'active',
                                'joined' => 'Jan 22, 2026',
                                'avatar' => 'JD'
                            ],
                            [
                                'name' => 'Alice Smith',
                                'email' => 'alice@company.com',
                                'role' => 'Manager',
                                'status' => 'active',
                                'joined' => 'Dec 15, 2025',
                                'avatar' => 'AS'
                            ],
                            [
                                'name' => 'Bob Johnson',
                                'email' => 'bob.j@example.com',
                                'role' => 'Editor',
                                'status' => 'inactive',
                                'joined' => 'Nov 02, 2025',
                                'avatar' => 'BJ'
                            ],
                             [
                                'name' => 'Charlie Brown',
                                'email' => 'charlie@example.com',
                                'role' => 'Viewer',
                                'status' => 'active',
                                'joined' => 'Oct 10, 2025',
                                'avatar' => 'CB'
                            ],
                        ];
                    @endphp

                    @foreach($users as $user)
                        <x-table.row>
                            <x-table.cell>
                                <x-checkbox />
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex items-center gap-3">
                                    <x-avatar class="size-9">
                                        <x-avatar-fallback>{{ $user['avatar'] }}</x-avatar-fallback>
                                    </x-avatar>
                                    <div class="grid gap-0.5">
                                        <p class="text-sm font-medium leading-none">{{ $user['name'] }}</p>
                                        <p class="text-xs text-muted-foreground">{{ $user['email'] }}</p>
                                    </div>
                                </div>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex items-center">
                                    @if($user['role'] === 'Administrator')
                                        <x-badge variant="default">{{ $user['role'] }}</x-badge>
                                    @else
                                        <x-badge variant="outline">{{ $user['role'] }}</x-badge>
                                    @endif
                                </div>
                            </x-table.cell>
                            <x-table.cell>
                                @if($user['status'] === 'active')
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
                                {{ $user['joined'] }}
                            </x-table.cell>
                            <x-table.cell class="text-right">
                                <x-dropdown.dropdown>
                                    <x-slot:trigger>
                                        <x-button variant="ghost" size="icon" class="size-8">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </x-button>
                                    </x-slot:trigger>
                                    <div class="w-40">
                                        <x-dropdown.item href="{{ route('demo.users.edit', 1) }}">
                                            Edit Details
                                        </x-dropdown.item>
                                        <x-dropdown.item>Change Role</x-dropdown.item>
                                        <x-dropdown.separator />
                                        <x-dropdown.item variant="destructive">
                                            Delete User
                                        </x-dropdown.item>
                                    </div>
                                </x-dropdown.dropdown>
                            </x-table.cell>
                        </x-table.row>
                    @endforeach
                </x-table.body>
            </x-table.table>
        </div>

        <!-- Pagination -->
        <x-pagination.pagination>
             <x-pagination.content>
                <x-pagination.item>
                    <x-pagination.previous href="#" />
                </x-pagination.item>
                <x-pagination.item>
                    <x-pagination.link href="#" :isActive="true">1</x-pagination.link>
                </x-pagination.item>
                <x-pagination.item>
                    <x-pagination.link href="#">2</x-pagination.link>
                </x-pagination.item>
                <x-pagination.item>
                    <x-pagination.item>
                        <x-pagination.ellipsis />
                    </x-pagination.item>
                </x-pagination.item>
                <x-pagination.item>
                    <x-pagination.next href="#" />
                </x-pagination.item>
            </x-pagination.content>
        </x-pagination.pagination>
    </div>
@endsection
