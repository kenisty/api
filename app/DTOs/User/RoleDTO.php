<?php

namespace App\DTOs\User;

use Illuminate\Database\Eloquent\Collection;

class RoleDTO
{
    private string $role;
    private Collection $users;
    private Collection $roles;

    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
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

    public function setRoles(Collection $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getRoles(): Collection
    {
        return $this->roles;
    }
}
