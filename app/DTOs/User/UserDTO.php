<?php

declare(strict_types=1);

namespace App\DTOs\User;

use App\Models\User\Permission;
use App\Models\User\Role;

class UserDTO
{
    private ?string $firstname;

    private ?string $lastname;

    private ?string $email;

    private ?string $password;

    /** @var array<Role> $roles */
    private ?array $roles;

    /** @var array<Permission> $permissions */
    private ?array $permissions;

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param array<Role> $roles
     */
    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return array<Role>|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @param array<Permission> $permissions
     */
    public function setPermissions(?array $permissions): self
    {
        $this->permissions = $permissions;
        return $this;
    }

    /**
     * @return array<Permission>|null
     */
    public function getPermissions(): ?array
    {
        return $this->permissions;
    }
}
