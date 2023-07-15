<?php

namespace App\DTOs\User;

use Illuminate\Database\Eloquent\Collection;

class RoleDTO
{
    public string $name;
    public Collection $users;

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
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
