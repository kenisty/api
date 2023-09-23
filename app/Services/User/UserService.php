<?php

declare(strict_types=1);

namespace App\Services\User;

use App\DTOs\User\UserDTO;
use App\Exceptions\User\InvalidPasswordException;
use App\Exceptions\User\UserAlreadyExistsException;
use App\Exceptions\User\UserNotFoundException;
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
    private const KEY_EXCEPTION = 'exception';

    private const KEY_DUPLICATE_USER_MESSAGE = 'Duplicate email found. User creation failed.';
    private const KEY_USER_CREATED_MESSAGE = 'User successfully created in the database.';
    private const KEY_USER_NOT_FOUND_MESSAGE = 'User not found. Login failed.';
    private const KEY_WRONG_PASSWORD_MESSAGE = 'Wrong password. Login failed.';

    public function __construct(
        private UserRepository $userRepository,
        private RoleService $roleService,
        private TokenService $tokenService,
        private PasswordService $passwordService,
    ) {
    }

    /**
     * @throws Exception|UserAlreadyExistsException
     */
    public function registerUser(array $data): UserDTO
    {
        $entry = [
            self::KEY_FIRST_NAME => $data[self::KEY_FIRST_NAME],
            self::KEY_LAST_NAME => $data[self::KEY_LAST_NAME],
            self::KEY_EMAIL => $data[self::KEY_EMAIL],
            self::KEY_PASSWORD => Hash::make($data[self::KEY_PASSWORD]),
        ];

        $user = $this->userRepository->findByEmail($entry[self::KEY_EMAIL]);

        if ($user) {
            Log::error(self::KEY_DUPLICATE_USER_MESSAGE, [self::KEY_EMAIL => $entry[self::KEY_EMAIL]]);

            throw new UserAlreadyExistsException;
        }

        try {
            $user = $this->userRepository->create($entry);
            Log::info(self::KEY_USER_CREATED_MESSAGE, [self::KEY_ID => $user->id]);
            $this->roleService->assignUserDefaultRole($user);
            $token = $this->tokenService->assignAuthToken($user);
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [self::KEY_EXCEPTION => $exception->getTraceAsString()]);

            throw $exception;
        }

        return (new UserDTO())
            ->setFirstname($user->first_name)
            ->setLastname($user->last_name)
            ->setEmail($user->email)
            ->setToken($token);
    }

    /**
     * @throws Exception|InvalidPasswordException|UserNotFoundException
     */
    public function loginUser(array $data): UserDTO
    {
        $entry = [
            self::KEY_EMAIL => $data[self::KEY_EMAIL],
            self::KEY_PASSWORD => $data[self::KEY_PASSWORD],
        ];

        $user = $this->userRepository->findByEmail($entry[self::KEY_EMAIL]);

        if (!$user) {
            Log::error(self::KEY_USER_NOT_FOUND_MESSAGE, [self::KEY_ID => $user->id]);

            throw new UserNotFoundException;
        }

        $passwordCheck = $this->passwordService->checkPassword($entry[self::KEY_PASSWORD], $user->password);

        if (!$passwordCheck) {
            Log::error(self::KEY_WRONG_PASSWORD_MESSAGE, [self::KEY_ID => $user->id]);

            throw new InvalidPasswordException;
        }

        try {
            $token = $this->tokenService->assignAuthToken($user);
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [self::KEY_EXCEPTION => $exception->getTraceAsString()]);

            throw $exception;
        }

        return (new UserDTO())
            ->setFirstname($user->first_name)
            ->setLastname($user->last_name)
            ->setEmail($user->email)
            ->setToken($token);
    }
}
