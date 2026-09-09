<?php

namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

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

// old
    // public function index()
    // {
    //     $roles = \Spatie\Permission\Models\Role::all();
    //      $permissions = \Spatie\Permission\Models\Permission::query()
    //     ->orderBy('name')
    //     ->get();

    // $permissionGroups = $permissions
    //     ->groupBy(function ($permission) {
    //         return str($permission->name)
    //             ->before('.')
    //             ->toString();
    //     });

    //     return view('pages.rbac.roles.index', compact('roles', 'permissions', 'permissionGroups'));
    // }

    
}
