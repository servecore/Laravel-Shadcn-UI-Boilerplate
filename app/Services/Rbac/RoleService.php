<?php

namespace App\Services\Rbac;

use App\Services\BaseCrudService;
use Spatie\Permission\Models\Role;

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
     * @return array<int, int>
     */
    public function permissionIds(Role $role): array
    {
        return $role->permissions()->pluck('id')->map(fn ($id) => (int) $id)->all();
    }
}
