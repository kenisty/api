<?php

declare(strict_types=1);

namespace App\Services\User;

use App\DTOs\User\UserDTO;
use App\Repositories\User\UserRepository;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    public function createUser(UserDTO $userDTO): UserDTO
    {
        $entry = [
            'first_name' => $userDTO->firstname,
            'last_name' => $userDTO->lastname,
            'email' => $userDTO->email,
            'password' => $userDTO->password
        ];

        $user = $this->userRepository->create($entry);

        return (new UserDTO())
            ->setFirstname($user->first_name)
            ->setLastname($user->last_name)
            ->setEmail($user->email);
    }
}
