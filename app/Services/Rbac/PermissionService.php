<?php

namespace App\Services\Rbac;

use App\Models\Permission;
use App\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PermissionService extends BaseCrudService
{
    /**
     * Get the model class for this service.
     */
    protected function model(): string
    {
        return Permission::class;
    }

    /**
     * Get a paginated, filterable list of permissions.
     *
     * @param  array<string, string>  $filters
     */
    public function paginateFiltered(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        return Permission::query()
            ->withCount('roles')
            ->when(! empty($filters['search']), function ($query) use ($filters) {
                $query->where('name', 'like', '%'.$filters['search'].'%');
            })
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();
    }
}
