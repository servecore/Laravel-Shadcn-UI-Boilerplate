<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasUuids;

    /**
     * The primary key is a UUID string, mirroring the users table.
     */
    protected $keyType = 'string';

    public $incrementing = false;
}
