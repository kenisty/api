<?php

namespace App\Services\User;

use App\DTOs\User\UserDTO;

class RoleService
{
    public function checkUserPermission(UserDTO $user, string $action): bool
    {
        foreach ($user->getPermissions() as $permission) {
            if ($permission->permission === $action) {
                return true;
            }
        }

        return false;
    }
}
