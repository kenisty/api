<?php

namespace App\DTOs\User;

use App\Models\User\User;

class RoleDTO
{
    private ?string $role = null;

    /** @var array<User>|null $users */
    private ?array $users = null;

    public function setRole(?string $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param array<User>|null $users
     */
    public function setUsers(?array $users): self
    {
        $this->users = $users;
        return $this;
    }

    /**
     * @return array<User>|null
     */
    public function getUsers(): ?array
    {
        return $this->users;
    }
}
