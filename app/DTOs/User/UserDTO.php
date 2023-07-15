<?php

declare(strict_types=1);

namespace App\DTOs\User;

use Illuminate\Database\Eloquent\Collection;

class UserDTO
{
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $password;
    private Collection $roles;
    private Collection $permissions;

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
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

    public function setPermissions(Collection $permissions): self
    {
        $this->permissions = $permissions;
        return $this;
    }

    public function getPermissions(): Collection
    {
        return $this->permissions;
    }
}
