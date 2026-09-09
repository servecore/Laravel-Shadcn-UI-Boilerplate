@extends('layouts.app')

@section('title', 'Permissions')
@section('header', 'Permissions')

@section('content')
    <div class="space-y-6" data-entity="permissions" data-fetch-url="{{ route('permissions.index') }}">
        <!-- Page Header -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <x-breadcrumb>
                <x-breadcrumb-list>
                    <x-breadcrumb-item>
                        <x-breadcrumb-link href="{{ route('dashboard') }}">Dashboard</x-breadcrumb-link>
                    </x-breadcrumb-item>
                    <x-breadcrumb-separator />
                    <x-breadcrumb-item>
                        <x-breadcrumb-page>Permissions</x-breadcrumb-page>
                    </x-breadcrumb-item>
                </x-breadcrumb-list>
            </x-breadcrumb>

            <x-button id="btn-create-permission" type="button">
                <x-lucide-plus class="mr-2 size-4" />
                Add Permission
            </x-button>
        </div>

        <!-- Permissions Table -->
        <x-table.table>
            <x-table.header>
                <x-table.row>
                    <x-table.head class="text-left">Actions</x-table.head>
                    <x-table.head class="text-left">Permission</x-table.head>
                    <x-table.head>Guard</x-table.head>
                    <x-table.head>Used by Roles</x-table.head>
                    <x-table.head class="text-left">Created</x-table.head>
                </x-table.row>
            </x-table.header>
            <x-table.body id="permissions-table-body">
                @forelse($permissions as $permission)
                    <x-table.row class="transition-colors hover:bg-muted/50">
                        <x-table.cell class="text-left">
                            <span data-action="edit" data-permission-id="{{ $permission->getRouteKey() }}" class="cursor-pointer text-sm text-blue-500">
                                <x-lucide-edit class="mr-1 inline-block size-4" />
                            </span>
                            <span data-action="delete" data-permission-id="{{ $permission->getRouteKey() }}" class="cursor-pointer text-sm text-red-500">
                                <x-lucide-trash class="mr-1 inline-block size-4" />
                            </span>
                        </x-table.cell>
                        <x-table.cell class="text-left">
                            <div class="flex items-center gap-3">
                                <x-lucide-shield-check class="size-4 text-muted-foreground" />
                                <div class="grid gap-0.5">
                                    <p class="text-sm font-medium leading-none">{{ $permission->name }}</p>
                                </div>
                            </div>
                        </x-table.cell>
                        <x-table.cell>
                            <x-badge variant="outline">{{ $permission->guard_name }}</x-badge>
                        </x-table.cell>
                        <x-table.cell>
                            <span class="text-sm text-muted-foreground">{{ $permission->roles_count }}</span>
                        </x-table.cell>
                        <x-table.cell class="text-left text-muted-foreground">
                            {{ $permission->created_at?->diffForHumans() ?? '—' }}
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="5" class="h-24 text-center">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <x-lucide-shield-check class="size-8 text-muted-foreground/50" />
                                <p class="text-sm text-muted-foreground">No permissions found.</p>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @endforelse
            </x-table.body>
        </x-table.table>

        <!-- Pagination -->
        @if ($permissions->hasPages())
            <div id="permissions-pagination">
                {{ $permissions->links() }}
            </div>
        @endif
    </div>
@endsection