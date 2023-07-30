<?php

namespace App\Services\Cache;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class UserCacheService
{
    public function setUserRolesCache(User $user): Collection
    {
        return Cache::remember("user-{$user->id}-roles", config('cache.time_to_live'), fn() => $user->roles);
    }

    public function removeUserRolesCache(User $user): void
    {
        Cache::forget("user-{$user->id}-roles");
    }

    public function setUserPermissionsCache(User $user): Collection
    {
        return Cache::remember("user-{$user->id}-permissions", config('cache.time_to_live'), function () use ($user) {
            $permissions = new Collection();

            foreach ($user->roles as $role) {
                $permissions->add($role->permissions);
            }

            return $permissions;
        });
    }

    public function removeUserPermissionsCache(User $user): void
    {
        Cache::forget("user-{$user->id}-permissions");
    }
}
