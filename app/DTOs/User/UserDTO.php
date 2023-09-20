<?php

declare(strict_types=1);

namespace App\DTOs\User;

use App\DTOs\DefaultDTOInterface;

final readonly class UserDTO implements DefaultDTOInterface
{
    private const KEY_TOKEN = 'token';
    private const KEY_FIRST_NAME = 'firstName';
    private const KEY_LAST_NAME = 'lastName';
    private const KEY_EMAIL = 'email';

    private ?string $token;

    private ?string $firstname;

    private ?string $lastname;

    private ?string $email;

    public function toArray(): array
    {
        return [
            self::KEY_TOKEN => $this->getToken(),
            self::KEY_FIRST_NAME => $this->getFirstname(),
            self::KEY_LAST_NAME => $this->getLastname(),
            self::KEY_EMAIL => $this->getEmail(),
        ];
    }

    public function fromArray(array $data): self
    {
        return (new self())
            ->setToken($data[self::KEY_TOKEN] ?? null)
            ->setFirstname($data[self::KEY_FIRST_NAME] ?? null)
            ->setLastname($data[self::KEY_LAST_NAME] ?? null)
            ->setEmail($data[self::KEY_EMAIL] ?? null);
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

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
}
