<?php

namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Services\Rbac\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function __construct(
        private readonly RoleService $roleService,
    ) {}

    /**
     * Display a listing of roles.
     */
    public function index(): View
    {
        $roles = Role::query()
            ->orderBy('name')
            ->withCount('permissions')
            ->get();

        $permissions = Permission::query()
            ->orderBy('name')
            ->get();

        $permissionGroups = $permissions->groupBy(function ($permission) {
            return str($permission->name)
                ->afterLast('-')
                ->toString();
        });

        $selectedRole = $roles->first();

        $selectedPermissionIds = $selectedRole
            ? $selectedRole->permissions->pluck('id')->all()
            : [];

        return view('pages.rbac.roles.index', [
            'roles' => $roles,
            'permissions' => $permissions,
            'permissionGroups' => $permissionGroups,
            'selectedRole' => $selectedRole,
            'selectedPermissionIds' => $selectedPermissionIds,
        ]);
    }

    /**
     * Show the form for creating a new role.
     */
    public function create(): View
    {
        return view('pages.rbac.roles.form', [
            'role' => null,
        ]);
    }

    /**
     * Store a newly created role.
     */
    public function store(StoreRoleRequest $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validated();

        $role = $this->roleService->create([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Role created successfully.',
                'role' => $role,
            ], 201);
        }

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Return role data as JSON for the edit modal.
     */
    public function show(Request $request, Role $role): JsonResponse
    {
        return response()->json([
            'role' => $role->only(['id', 'name', 'guard_name']) + [
                'permissions' => $this->roleService->permissionIds($role),
            ],
        ]);
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Request $request, Role $role): JsonResponse|View
    {
        if ($request->expectsJson()) {
            return $this->show($request, $role);
        }

        return view('pages.rbac.roles.form', [
            'role' => $role,
        ]);
    }

    /**
     * Update the specified role.
     */
    public function update(UpdateRoleRequest $request, Role $role): JsonResponse|RedirectResponse
    {
        $validated = $request->validated();

        $this->roleService->update($role->getKey(), [
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'],
        ]);

        if ($request->has('permissions')) {
            $this->roleService->syncPermissions($role, $validated['permissions'] ?? []);
        }

        $role->refresh();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Role updated successfully.',
                'role' => $role->only(['id', 'name', 'guard_name']) + [
                    'permissions' => $this->roleService->permissionIds($role),
                ],
            ]);
        }

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Request $request, Role $role): JsonResponse|RedirectResponse
    {
        if ($role->name === 'admin') {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The admin role cannot be deleted.',
                ], 422);
            }

            return back()->withErrors([
                'role' => 'The admin role cannot be deleted.',
            ]);
        }

        $this->roleService->delete($role->getKey());

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Role deleted successfully.',
            ]);
        }

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
