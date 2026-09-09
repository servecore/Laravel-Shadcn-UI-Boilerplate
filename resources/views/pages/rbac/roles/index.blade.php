@extends('layouts.app')

@section('title', 'Roles')
@section('header', 'Roles')

@section('content')
    <div
        class="space-y-6"
        data-entity="roles"
        data-fetch-url="{{ route('roles.index') }}"
    >
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
                            <x-button
                                id="btn-create-role"
                                type="button"
                                variant="default"
                                size="default"
                                class="w-full justify-center"
                            >
                                <x-lucide-plus class="mr-2 size-4" />
                                Add Role
                            </x-button>
                        </x-card-title>
                    </x-card-header>

                    <x-card-content>
                        <ul class="space-y-2">
                            @foreach ($roles as $role)
                                <li>
                                    <x-item
                                        class="cursor-pointer"
                                        data-role-id="{{ $role->getRouteKey() }}"
                                    >
                                        <span class="min-w-0 flex-1 truncate font-medium">
                                            {{ $role->name }}
                                        </span>

                                        <div class="flex shrink-0 items-center gap-2">
                                            <button
                                                type="button"
                                                data-action="edit"
                                                data-role-id="{{ $role->getRouteKey() }}"
                                                class="text-muted-foreground transition-colors hover:text-foreground"
                                                title="Edit role"
                                            >
                                                <x-lucide-edit class="size-4" />
                                            </button>

                                            <button
                                                type="button"
                                                data-action="delete"
                                                data-role-id="{{ $role->getRouteKey() }}"
                                                class="text-muted-foreground transition-colors hover:text-destructive"
                                                title="Delete role"
                                            >
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

                                <x-button
                                    type="button"
                                    variant="destructive"
                                    size="sm"
                                    data-action="delete"
                                    data-role-id="{{ $selectedRole->getRouteKey() }}"
                                >
                                    <x-lucide-trash-2 class="mr-2 size-4" />
                                    Delete Role
                                </x-button>

                            @endif

                        </div>

                    </x-card-header>


                    <!-- Permission Content -->
                    <x-card-content>

                        <div class="space-y-8">

                            @forelse ($permissionGroups as $groupName => $groupPermissions)

                                @php
                                    /*
                                     * Ambil semua action yang tersedia
                                     * pada group permission ini.
                                     *
                                     * Contoh:
                                     * users.view
                                     * users.create
                                     * users.update
                                     * users.delete
                                     */

                                    $actions = $groupPermissions
                                        ->map(function ($permission) {
                                            return str($permission->name)
                                                ->afterLast('.')
                                                ->toString();
                                        })
                                        ->unique()
                                        ->values();
                                @endphp


                                <!-- Permission Group -->
                                <section class="space-y-4">

                                    <!-- Group Header -->
                                    <div>

                                        <h3 class="text-sm font-semibold capitalize">
                                            {{ str($groupName)->replace(['-', '_'], ' ') }}
                                        </h3>

                                        <p class="text-sm text-muted-foreground">
                                            Manage {{ str($groupName)->replace(['-', '_'], ' ') }} permissions.
                                        </p>

                                    </div>


                                    <!-- Permission Table -->
                                    <div class="overflow-x-auto rounded-lg border">

                                        <div
                                            class="min-w-[640px]"
                                        >

                                            <!-- Table Header -->
                                            <div
                                                class="grid gap-4 border-b bg-muted/40 px-4 py-3 text-sm font-medium"
                                                style="grid-template-columns: minmax(180px, 1fr) repeat({{ $actions->count() }}, minmax(80px, 100px));"
                                            >

                                                <div>
                                                    Permission
                                                </div>

                                                @foreach ($actions as $action)

                                                    <div class="text-center capitalize">
                                                        {{ str($action)->replace(['-', '_'], ' ') }}
                                                    </div>

                                                @endforeach

                                            </div>


                                            <!-- Permission Rows -->
                                            @foreach ($groupPermissions->groupBy(function ($permission) {
                                                return str($permission->name)
                                                    ->beforeLast('.')
                                                    ->toString();
                                            }) as $resource => $resourcePermissions)

                                                @php
                                                    $permissionMap = $resourcePermissions->keyBy(function ($permission) {
                                                        return str($permission->name)
                                                            ->afterLast('.')
                                                            ->toString();
                                                    });
                                                @endphp


                                                <div
                                                    class="grid items-center gap-4 border-b px-4 py-4 last:border-b-0"
                                                    style="grid-template-columns: minmax(180px, 1fr) repeat({{ $actions->count() }}, minmax(80px, 100px));"
                                                >

                                                    <!-- Resource -->
                                                    <div>

                                                        <div class="text-sm font-medium capitalize">
                                                            {{ str($resource)->replace(['-', '_'], ' ') }}
                                                        </div>

                                                        <div class="text-xs text-muted-foreground">
                                                            Manage {{ str($resource)->replace(['-', '_'], ' ') }}
                                                        </div>

                                                    </div>


                                                    <!-- Actions -->
                                                    @foreach ($actions as $action)

                                                        @php
                                                            $permission = $permissionMap->get($action);
                                                        @endphp

                                                        <div class="flex justify-center">

                                                            @if ($permission)

                                                                <x-checkbox
                                                                    name="permissions[]"
                                                                    value="{{ $permission->id }}"
                                                                    data-permission-id="{{ $permission->id }}"
                                                                    data-permission-name="{{ $permission->name }}"
                                                                />

                                                            @else

                                                                <span class="text-muted-foreground">
                                                                    —
                                                                </span>

                                                            @endif

                                                        </div>

                                                    @endforeach

                                                </div>

                                            @endforeach

                                        </div>

                                    </div>

                                </section>

                            @empty

                                <div class="rounded-lg border border-dashed p-8 text-center">

                                    <x-lucide-shield-alert class="mx-auto mb-3 size-8 text-muted-foreground" />

                                    <h3 class="text-sm font-medium">
                                        No permissions found
                                    </h3>

                                    <p class="mt-1 text-sm text-muted-foreground">
                                        There are currently no permissions configured.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </x-card-content>


                    <!-- Actions -->
                    <x-card-footer>

                        <div class="flex w-full flex-col-reverse gap-2 sm:flex-row sm:justify-end">

                            <x-button
                                type="button"
                                variant="outline"
                                data-action="cancel"
                            >
                                Cancel
                            </x-button>

                            <x-button
                                type="button"
                                variant="default"
                                data-action="save-permissions"
                            >
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