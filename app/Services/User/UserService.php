<?php

declare(strict_types=1);

namespace App\Services\User;

use App\DTOs\User\UserDTO;
use App\Exceptions\User\UserAlreadyExistsException;
use App\Models\User\User;
use App\Repositories\User\RoleRepository;
use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

readonly class UserService
{
    private const KEY_DEFAULT_ROLE = 'user';
    private const KEY_CREATE_USER_TOKEN_NAME = 'userToken';

    public function __construct(
        private UserRepository $userRepository,
        private RoleRepository $roleRepository,
    ) {}

    /**
     * @throws UserAlreadyExistsException|Exception
     */
    public function createUser(UserDTO $userDTO): UserDTO
    {
        $entry = [
            'first_name' => $userDTO->getFirstname(),
            'last_name' => $userDTO->getLastname(),
            'email' => $userDTO->getEmail(),
            'password' => Hash::make($userDTO->getPassword()),
        ];

        $user = $this->userRepository->findByEmail($entry['email']);

        if ($user) {
            Log::error('Duplicate email found. User creation failed.', ['email' => $entry['email']]);
            throw new UserAlreadyExistsException;
        }

        try {
            $user = $this->userRepository->create($entry);
            Log::info('User successfully created in the database.', ['id' => $user->id]);
            $this->assignUserDefaultRole($user);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }

        $token = null;

        if ($userDTO->getIsRegistering()) {
            $token = $user->createToken(self::KEY_CREATE_USER_TOKEN_NAME)->plainTextToken;
        }

        return (new UserDTO())
            ->setFirstname($user->first_name)
            ->setLastname($user->last_name)
            ->setEmail($user->email)
            ->setToken($token);
    }

    private function assignUserDefaultRole(User $user): void
    {
        $defaultRole = $this->roleRepository->findByRole(self::KEY_DEFAULT_ROLE);
        $user->roles()->attach($defaultRole);
        Log::info("Default role [" . self::KEY_DEFAULT_ROLE . "] assigned to the user in the database.", ['id' => $user->id]);
    }
}
