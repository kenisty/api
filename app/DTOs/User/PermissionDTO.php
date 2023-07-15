<?php

declare(strict_types=1);

namespace App\DTOs\User;

use Illuminate\Database\Eloquent\Collection;

class PermissionDTO
{
    private string $permission;
    private Collection $roles;
    private Collection $users;

    public function setPermission(string $permission): self
    {
        $this->permission = $permission;
        return $this;
    }

    public function getPermission(): string
    {
        return $this->permission;
    }

    public function setRoles(Collection $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function setUsers(Collection $users): self
    {
        $this->users = $users;
        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }
}
