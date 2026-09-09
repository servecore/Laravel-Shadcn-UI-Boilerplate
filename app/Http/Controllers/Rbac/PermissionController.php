<?php

namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Models\Permission;
use App\Services\Rbac\PermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermissionController extends Controller
{
    public function __construct(
        private readonly PermissionService $permissionService,
    ) {}

    /**
     * Display a listing of permissions.
     */
    public function index(Request $request): View
    {
        $permissions = $this->permissionService->paginateFiltered(
            filters: $request->only(['search']),
            perPage: 10,
        );

        return view('pages.rbac.permissions.index', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created permission.
     */
    public function store(StorePermissionRequest $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validated();

        $permission = $this->permissionService->create([
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Permission created successfully.',
                'permission' => $permission,
            ], 201);
        }

        return redirect()->route('permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    /**
     * Return permission data as JSON for the edit modal.
     */
    public function show(Request $request, Permission $permission): JsonResponse
    {
        return response()->json([
            'permission' => $permission->only(['id', 'name', 'guard_name']),
        ]);
    }

    /**
     * Update the specified permission.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission): JsonResponse|RedirectResponse
    {
        $validated = $request->validated();

        $this->permissionService->update($permission->getKey(), [
            'name' => $validated['name'],
            'guard_name' => $validated['guard_name'],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Permission updated successfully.',
                'permission' => $permission->refresh()->only(['id', 'name', 'guard_name']),
            ]);
        }

        return redirect()->route('permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified permission.
     */
    public function destroy(Request $request, Permission $permission): JsonResponse|RedirectResponse
    {
        if ($permission->name === 'manage-permissions') {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The manage-permissions permission cannot be deleted.',
                ], 422);
            }

            return back()->withErrors([
                'permission' => 'The manage-permissions permission cannot be deleted.',
            ]);
        }

        $this->permissionService->delete($permission->getKey());

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Permission deleted successfully.',
            ]);
        }

        return redirect()->route('permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }
}
