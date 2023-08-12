<?php

namespace App\Services\User;

use App\DTOs\User\UserDTO;
use App\Models\User\Permission;
use Illuminate\Database\Eloquent\Collection;

class RoleService
{
    public function checkUserPermission(UserDTO $user, string $action): bool
    {
        /** @var Collection<array-key, Permission> $permissions */
        $permissions = $user->getPermissions();

        if (count($permissions) === 0) {
            return false;
        }

        $permissions = array_filter(
            $permissions->toArray(),
            static fn (Permission $permission): bool => $permission->permission === $action
        );

        return count($permissions) > 0;
    }
}
