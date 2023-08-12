<?php

declare(strict_types=1);

namespace App\Services\User;

use App\DTOs\User\UserDTO;
use App\Exceptions\User\InvalidPasswordException;
use App\Exceptions\User\UserAlreadyExistsException;
use App\Exceptions\User\UserNotFoundException;
use App\Models\User\User;
use App\Repositories\User\RoleRepository;
use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

readonly class UserService
{
    private const KEY_ID = 'id';
    private const KEY_FIRST_NAME = 'first_name';
    private const KEY_LAST_NAME = 'last_name';
    private const KEY_EMAIL = 'email';
    private const KEY_PASSWORD = 'password';

    private const KEY_DEFAULT_ROLE = 'user';
    private const KEY_EXCEPTION = 'exception';
    private const KEY_CREATE_USER_TOKEN_NAME = 'userToken';
    private const KEY_TOKEN_DEFAULT_VALUE = null;

    private const KEY_DUPLICATE_USER_MESSAGE = 'Duplicate email found. User creation failed.';
    private const KEY_USER_CREATED_MESSAGE = 'User successfully created in the database.';
    private const KEY_USER_ASSIGNED_DEFAULT_ROLE_MESSAGE = 'Default role ['.self::KEY_DEFAULT_ROLE.'] assigned to the user in the database.';
    private const KEY_USER_NOT_FOUND_MESSAGE = 'User not found. Login failed.';
    private const KEY_WRONG_PASSWORD_MESSAGE = 'Wrong password. Login failed.';

    public function __construct(
        private UserRepository $userRepository,
        private RoleRepository $roleRepository,
    ) {
    }

    /**
     * @throws Exception|UserAlreadyExistsException
     */
    public function createUser(UserDTO $userDTO): UserDTO
    {
        $entry = [
            self::KEY_FIRST_NAME => $userDTO->getFirstname(),
            self::KEY_LAST_NAME => $userDTO->getLastname(),
            self::KEY_EMAIL => $userDTO->getEmail(),
            self::KEY_PASSWORD => Hash::make($userDTO->getPassword()),
        ];

        $user = $this->userRepository->findByEmail($entry[self::KEY_EMAIL]);

        if ($user) {
            Log::error(self::KEY_DUPLICATE_USER_MESSAGE, [
                self::KEY_EMAIL => $entry[self::KEY_EMAIL],
            ]);

            throw new UserAlreadyExistsException();
        }

        try {
            $user = $this->userRepository->create($entry);

            Log::info(self::KEY_USER_CREATED_MESSAGE, [
                self::KEY_ID => $user->id,
            ]);

            $this->assignUserDefaultRole($user); // TODO: return role
            $token = $this->assignUserToken($user, $userDTO->getIsCreatedByAnotherUser());
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [
                self::KEY_EXCEPTION => $exception->getTraceAsString(),
            ]);

            throw $exception;
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

        Log::info(self::KEY_USER_ASSIGNED_DEFAULT_ROLE_MESSAGE, [
            self::KEY_ID => $user->id,
        ]);
    }

    private function assignUserToken(User $user, bool $isCreatedByAnotherUser): string|null
    {
        if ($isCreatedByAnotherUser) {
            return self::KEY_TOKEN_DEFAULT_VALUE;
        }

        $user->tokens()->delete();

        return $user->createToken(self::KEY_CREATE_USER_TOKEN_NAME)->plainTextToken;
    }

    /**
     * @throws Exception|InvalidPasswordException|UserNotFoundException
     */
    public function loginUser(UserDTO $userDTO): UserDTO
    {
        $entry = [
            self::KEY_EMAIL => $userDTO->getEmail(),
            self::KEY_PASSWORD => $userDTO->getPassword(),
        ];

        $user = $this->userRepository->findByEmail($entry[self::KEY_EMAIL]);

        if (!$user) {
            Log::error(self::KEY_USER_NOT_FOUND_MESSAGE, [
                self::KEY_ID => $user->id,
            ]);

            throw new UserNotFoundException();
        }

        $passwordCheck = Hash::check($entry[self::KEY_PASSWORD], $user->password);

        if (!$passwordCheck) {
            Log::error(self::KEY_WRONG_PASSWORD_MESSAGE, [
                self::KEY_ID => $user->id,
            ]);

            throw new InvalidPasswordException();
        }

        try {
            $token = $user->createToken(self::KEY_CREATE_USER_TOKEN_NAME)->plainTextToken;
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [
                self::KEY_EXCEPTION => $exception->getTraceAsString(),
            ]);

            throw $exception;
        }

        return (new UserDTO())
            ->setFirstname($user->first_name)
            ->setLastname($user->last_name)
            ->setEmail($user->email)
            ->setToken($token);
    }
}
