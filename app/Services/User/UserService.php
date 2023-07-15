<?php

declare(strict_types=1);

namespace App\Services\User;

use App\DTOs\User\UserDTO;
use App\Exceptions\User\UserAlreadyExistsException;
use App\Repositories\User\RoleRepository;
use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly RoleRepository $roleRepository
    ) {}

    /**
     * @throws Exception
     */
    public function createUser(UserDTO $userDTO): UserDTO
    {
        $entry = [
            'first_name' => $userDTO->firstname,
            'last_name' => $userDTO->lastname,
            'email' => $userDTO->email,
            'password' => Hash::make($userDTO->password)
        ];

        $user = $this->userRepository->findByEmail($entry['email']);

        if ($user) {
            Log::error('Duplicate email found. User creation failed.', ['email' => $user->email]);
            throw new UserAlreadyExistsException;
        }

        try {
            $user = $this->userRepository->create($entry);
            Log::info('User successfully created in the database.', ['id' => $user->id]);

            $defaultRole = $this->roleRepository->findByName('user');
            $user->roles()->attach($defaultRole);
            Log::info('Default role [user] assigned to the user in the database.', ['id' => $user->id]);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }

        return (new UserDTO())
            ->setFirstname($user->first_name)
            ->setLastname($user->last_name)
            ->setEmail($user->email)
            ->setRoles($user->roles);
    }
}
