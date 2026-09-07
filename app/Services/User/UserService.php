<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\BaseCrudService;

class UserService extends BaseCrudService
{
    /**
     * Get the model class for this service.
     */
    protected function model(): string
    {
        return User::class;
    }

    /**
     * Assign a role to a user.
     */
    public function assignRole(User $user, string $role): User
    {
        $user->assignRole($role);

        return $user->fresh();
    }

    /**
     * Sync roles for a user.
     *
     * @param  array<int|string>  $roles
     */
    public function syncRoles(User $user, array $roles): User
    {
        $user->syncRoles($roles);

        return $user->fresh();
    }

    /**
     * Check if a user has a specific permission.
     */
    public function hasPermission(User $user, string $permission): bool
    {
        return $user->hasPermissionTo($permission);
    }

    /**
     * Check if a user has a specific role.
     */
    public function hasRole(User $user, string $role): bool
    {
        return $user->hasRole($role);
    }

    /**
     * Find a user by email.
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Find a user by username.
     */
    public function findByUsername(string $username): ?User
    {
        return User::where('username', $username)->first();
    }
}
