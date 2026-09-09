<?php

namespace App\Services\Rbac;

use App\Models\Permission;
use App\Services\BaseCrudService;

class PermissionService extends BaseCrudService
{
    /**
     * Get the model class for this service.
     */
    protected function model(): string
    {
        return Permission::class;
    }
}
