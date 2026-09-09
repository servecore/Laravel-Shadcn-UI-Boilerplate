                    <x-card-content>

                        <div class="space-y-8">

                            @forelse ($permissionGroups as $resource => $resourcePermissions)

                                @php
                                    $permissionMap = $resourcePermissions->keyBy(function ($permission) {
                                        return str($permission->name)->before('-')->toString();
                                    });

                                    $actions = collect(['view', 'create', 'edit', 'delete', 'manage']);
                                @endphp

                                <!-- Permission Group -->
                                <section class="space-y-4">

                                    <!-- Group Header -->
                                    <div>
                                        <h3 class="text-sm font-semibold capitalize">
                                            {{ str($resource)->replace(['-', '_'], ' ') }}
                                        </h3>

                                        <p class="text-sm text-muted-foreground">
                                            Manage {{ str($resource)->replace(['-', '_'], ' ') }} permissions.
                                        </p>
                                    </div>

                                    <!-- Permission Table -->
                                    <div class="overflow-x-auto rounded-lg border">
                                        <div class="min-w-[640px]">

                                            <!-- Table Header -->
                                            <div class="grid items-center gap-4 border-b bg-muted/40 px-4 py-3 text-sm font-medium"
                                                style="grid-template-columns: minmax(180px, 1fr) repeat(5, minmax(80px, 100px));">
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
                                                style="grid-template-columns: minmax(180px, 1fr) repeat(5, minmax(80px, 100px));">

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
                                                                (int) $permission->id,
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