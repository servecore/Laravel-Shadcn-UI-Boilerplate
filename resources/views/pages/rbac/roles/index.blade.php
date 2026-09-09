@extends('layouts.app')

@section('title', 'Roles')
@section('header', 'Roles')

@section('content')
    <div class="space-y-6" data-entity="roles" data-fetch-url="{{ route('roles.index') }}">
        <!-- Page Header -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <x-breadcrumb>
                <x-breadcrumb-list>
                    <x-breadcrumb-item>
                        <x-breadcrumb-link href="{{ route('dashboard') }}">
                            Dashboard
                        </x-breadcrumb-link>
                    </x-breadcrumb-item>

                    <x-breadcrumb-separator />

                    <x-breadcrumb-item>
                        <x-breadcrumb-page>
                            Roles
                        </x-breadcrumb-page>
                    </x-breadcrumb-item>
                </x-breadcrumb-list>
            </x-breadcrumb>
        </div>

        <!-- Roles & Permissions Workspace -->
        <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">

            <!-- ========================================== -->
            <!-- LEFT : ROLES -->
            <!-- ========================================== -->
            <div class="space-y-6">
                <x-card>
                    <x-card-header>
                        <x-card-title>
                            <x-button id="btn-create-role" type="button" variant="default" size="default"
                                class="w-full justify-center">
                                <x-lucide-plus class="mr-2 size-4" />
                                Add Role
                            </x-button>
                        </x-card-title>
                    </x-card-header>

                    <x-card-content>
                        <ul class="space-y-2" id="list-roles">
                            @foreach ($roles as $role)
                                <li>
                                    <x-item class="cursor-pointer" data-role-id="{{ $role->getRouteKey() }}">
                                        <span class="min-w-0 flex-1 truncate font-medium">
                                            {{ $role->name }}
                                        </span>

                                        <div class="flex shrink-0 items-center gap-2">
                                            <button type="button" data-action="edit"
                                                data-role-id="{{ $role->getRouteKey() }}"
                                                class="text-muted-foreground transition-colors hover:text-foreground"
                                                title="Edit role">
                                                <x-lucide-edit class="size-4" />
                                            </button>

                                            <button type="button" data-action="delete"
                                                data-role-id="{{ $role->getRouteKey() }}"
                                                class="text-muted-foreground transition-colors hover:text-destructive"
                                                title="Delete role">
                                                <x-lucide-trash-2 class="size-4" />
                                            </button>
                                        </div>
                                    </x-item>
                                </li>
                            @endforeach
                        </ul>
                    </x-card-content>
                </x-card>
            </div>

            <!-- ========================================= -->
            <!-- RIGHT : PERMISSIONS -->
            <!-- ========================================= -->
            <div class="lg:col-span-2">

                <x-card>

                    <!-- Role Header -->
                    <x-card-header>

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                            <div class="space-y-1">

                                <x-card-title>
                                    {{ $selectedRole->name ?? 'Administrator' }}
                                </x-card-title>

                                <x-card-description>
                                    Manage permissions for this role.
                                </x-card-description>

                            </div>

                            @if (isset($selectedRole))
                                <x-button type="button" variant="destructive" size="sm" data-action="delete"
                                    data-role-id="{{ $selectedRole->getRouteKey() }}">
                                    <x-lucide-trash-2 class="mr-2 size-4" />
                                    Delete Role
                                </x-button>
                            @endif

                        </div>

                    </x-card-header>

                    <!-- Permission Content -->
                    @include('pages.rbac.roles.partials.permissions')

                    <!-- Actions -->
                    <x-card-footer>

                        <div class="flex w-full flex-col-reverse gap-2 sm:flex-row sm:justify-end">

                            <x-button type="button" variant="outline" data-action="cancel">
                                Cancel
                            </x-button>

                            <x-button type="button" variant="default" data-action="save-permissions">
                                <x-lucide-save class="mr-2 size-4" />
                                Save Changes
                            </x-button>

                        </div>

                    </x-card-footer>

                </x-card>

            </div>

        </div>


        <!-- Pagination -->
        {{-- 
        @if ($roles->hasPages())
            <div class="flex justify-center">
                {{ $roles->links() }}
            </div>
        @endif
        --}}

    </div>
@endsection
