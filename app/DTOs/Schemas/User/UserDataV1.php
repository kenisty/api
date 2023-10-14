<?php

declare(strict_types=1);

namespace App\DTOs\Schemas\User;

use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'UserDataV1', title: 'UserDataV1', description: 'A schema containing all the user data, that should be sent as a response.')]
final readonly class UserDataV1 implements DefaultSchemaInterface
{
    private const KEY_TOKEN = 'token';
    private const KEY_FIRST_NAME = 'firstname';
    private const KEY_LAST_NAME = 'lastname';
    private const KEY_EMAIL = 'email';

    #[OA\Property(type: 'string')]
    private ?string $token;

    #[OA\Property(type: 'string')]
    private ?string $firstname;

    #[OA\Property(type: 'string')]
    private ?string $lastname;

    #[OA\Property(type: 'string')]
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
