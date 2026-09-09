<x-card-content>

                        <div class="space-y-6" id="permission-panel">

                            @php
                                $actions = isset($actionColumns) && ! empty($actionColumns)
                                    ? $actionColumns
                                    : ['view', 'create', 'edit', 'delete', 'manage'];

                                $columnCount = max(1, count($actions));
                                $gridStyle = 'grid-template-columns: minmax(180px, 1fr) repeat('.$columnCount.', minmax(80px, 100px));';
                                $minWidth = 640 + ($columnCount * 80);
                            @endphp

                            <!-- Search -->
                            <div class="relative">
                                <x-lucide-search class="absolute left-2.5 top-2.5 size-4 text-muted-foreground" />
                                <x-input id="permission-search" type="search" class="w-full pl-9"
                                    placeholder="Search permissions..." />
                            </div>

                            @forelse ($permissionGroups as $resource => $resourcePermissions)

                                @php
                                    $permissionMap = $resourcePermissions->keyBy(function ($permission) {
                                        return str($permission->name)->before('-')->toString();
                                    });
                                @endphp

                                <!-- Permission Group -->
                                <section class="permission-group space-y-4" data-resource="{{ $resource }}">

                                    <!-- Group Header -->
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <h3 class="text-sm font-semibold capitalize">
                                                {{ str($resource)->replace(['-', '_'], ' ') }}
                                            </h3>

                                            <p class="text-sm text-muted-foreground">
                                                Manage {{ str($resource)->replace(['-', '_'], ' ') }} permissions.
                                            </p>
                                        </div>

                                        <div class="flex shrink-0 items-center gap-3 text-xs">
                                            <button type="button" data-action="select-resource-all"
                                                class="text-muted-foreground transition-colors hover:text-foreground">
                                                Check all
                                            </button>

                                            <button type="button" data-action="select-resource-none"
                                                class="text-muted-foreground transition-colors hover:text-foreground">
                                                Clear
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Permission Table -->
                                    <div class="overflow-x-auto rounded-lg border">
                                        <div style="min-width: {{ $minWidth }}px">

                                            <!-- Table Header -->
                                            <div class="grid items-center gap-4 border-b bg-muted/40 px-4 py-3 text-sm font-medium"
                                                style="{{ $gridStyle }}">
                                                <div>
                                                    Permission
                                                </div>

                                                @foreach ($actions as $action)
                                                    <div class="text-center capitalize">
                                                        {{ $action }}
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Permission Row -->
                                            <div class="grid items-center gap-4 px-4 py-4"
                                                style="{{ $gridStyle }}">

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

                                                        $isChecked = $permission
                                                            ? in_array(
                                                                (string) $permission->id,
                                                                $selectedPermissionIds ?? [],
                                                                true,
                                                            )
                                                            : false;
                                                    @endphp

                                                    <div class="flex justify-center">

                                                        @if ($permission)
                                                            <x-checkbox name="permissions[]" value="{{ $permission->id }}"
                                                                data-permission-id="{{ $permission->id }}"
                                                                data-permission-name="{{ $permission->name }}"
                                                                :checked="$isChecked" />
                                                        @else
                                                            <span class="text-muted-foreground">
                                                                —
                                                            </span>
                                                        @endif

                                                    </div>
                                                @endforeach

                                            </div>

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