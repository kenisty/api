<?php

declare(strict_types=1);

namespace App\DTOs\User;

class UserDTO
{
    public string $firstname;
    public string $lastname;
    public string $email;
    public readonly string $password;

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

    public function getPassword(): string
    {
        return $this->password;
    }
}
