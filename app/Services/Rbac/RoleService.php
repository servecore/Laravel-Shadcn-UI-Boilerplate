<?php

namespace App\Services\Rbac;

use App\Models\Role;
use App\Services\BaseCrudService;

class RoleService extends BaseCrudService
{
    /**
     * Get the model class for this service.
     */
    protected function model(): string
    {
        return Role::class;
    }

    /**
     * Get the permissions attached to a role.
     *
     * @return array<int, string>
     */
    public function permissionIds(Role $role): array
    {
        return $role->permissions()->pluck('id')->all();
    }

    /**
     * Sync the permissions attached to a role.
     *
     * @param  array<int, string>  $permissionIds
     */
    public function syncPermissions(Role $role, array $permissionIds): void
    {
        $role->syncPermissions($permissionIds);
    }
}
