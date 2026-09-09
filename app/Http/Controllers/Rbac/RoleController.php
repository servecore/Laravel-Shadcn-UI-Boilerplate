<?php

namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;


class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::query()
            ->orderBy('name')
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

        return view('pages.rbac.roles.index', compact(
            'roles',
            'permissions',
            'permissionGroups',
            'selectedRole',
            'selectedPermissionIds',
        ));
    }

    public function partials()
    {

        $permissions = Permission::query()
            ->orderBy('name')
            ->get();

        $permissionGroups = $permissions->groupBy(function ($permission) {
            return str($permission->name)
                ->afterLast('-')
                ->toString();
        });

        // $selectedRole = $roles->first();
        $selectedRole = Auth::user()->roles->first();

        $selectedPermissionIds = $selectedRole
            ? $selectedRole->permissions->pluck('id')->all()
            : [];

        return view('pages.rbac.roles.partials.permissions', compact(
            'permissions',
            'permissionGroups',
            'selectedRole',
            'selectedPermissionIds',
        ));
    }

   public function create() : View
    {
        return view('pages.rbac.roles.form', [
            'role' => null,
        ]);
    }

    public function store(StoreRoleRequest $request): JsonResponse|RedirectResponse
    {
        // Logic for storing a new role
    }

   public function edit(Request $request, Role $user, $id) : JsonResponse|View
    {
        if ($request->expectsJson()) {
            return $this->show($request, $user);
        }
        // Logic for editing a role
        return view('pages.rbac.roles.form', [
            'role' => Role::findOrFail($id),
        ]);
    }

    public function update(UpdateRoleRequest $request, $id):  JsonResponse|RedirectResponse
    {
        // Logic for updating a role
    }

    public function destroy($id)
    {
        // Logic for deleting a role
    }

}
