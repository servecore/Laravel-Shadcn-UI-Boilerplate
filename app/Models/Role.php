<?php

namespace App\Models;

use App\Traits\HasEncryptedRouteKey;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasEncryptedRouteKey, HasUuids;

    /**
     * The primary key is a UUID string, mirroring the users table.
     */
    protected $keyType = 'string';

    public $incrementing = false;
}
