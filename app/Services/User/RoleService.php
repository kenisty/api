<?php

namespace App\Services\User;

use App\DTOs\User\UserDTO;
use App\Models\User\Permission;

class RoleService
{
    public function checkUserPermission(UserDTO $user, string $action): bool
    {
        $permissions = array_filter($user->getPermissions(), fn (Permission $permission) => $permission->permission === $action);
        return count($permissions) > 0;
    }
}
