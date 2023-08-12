<?php

declare(strict_types=1);

namespace App\DTOs\User;

use App\Models\User\Role;
use App\Models\User\User;

class PermissionDTO
{
    private ?string $permission = null;

    /** @var array<Role>|null */
    private ?array $roles = null;

    /** @var array<User>|null */
    private ?array $users = null;

    public function setPermission(?string $permission): self
    {
        $this->permission = $permission;

        return $this;
    }

    public function getPermission(): ?string
    {
        return $this->permission;
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setUsers(?array $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getUsers(): ?array
    {
        return $this->users;
    }
}
