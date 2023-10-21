<?php

declare(strict_types=1);

namespace App\Services\User;

use App\DTOs\Schemas\User\UserDataV1;
use App\Exceptions\User\InvalidPasswordException;
use App\Exceptions\User\UserAlreadyExistsException;
use App\Exceptions\User\UserNotFoundException;
use App\Repositories\User\UserRepository;
use App\Services\TypeSafe;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use LogicException;

readonly class UserService
{
    private const KEY_ID = 'id';
    private const KEY_FIRST_NAME = 'firstname';
    private const KEY_LAST_NAME = 'lastname';
    private const KEY_EMAIL = 'email';
    private const KEY_PASSWORD = 'password';
    private const KEY_EXCEPTION = 'exception';

    private const KEY_DUPLICATE_USER_MESSAGE = 'Duplicate email found. User creation failed.';
    private const KEY_USER_CREATED_MESSAGE = 'User successfully created in the database.';
    private const KEY_USER_NOT_FOUND_MESSAGE = 'User not found. Login failed.';
    private const KEY_WRONG_PASSWORD_MESSAGE = 'Wrong password. Login failed.';

    public function __construct(
        private UserRepository $userRepository,
        private TokenService $tokenService,
        private PasswordService $passwordService,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws Exception|UserAlreadyExistsException
     */
    public function registerUser(array $data): UserDataV1
    {
        $entry = [
            self::KEY_FIRST_NAME => TypeSafe::getString($data[self::KEY_FIRST_NAME]) ?? throw new LogicException('Firstname cannot be null.'),
            self::KEY_LAST_NAME => TypeSafe::getString($data[self::KEY_LAST_NAME]) ?? throw new LogicException('Lastname cannot be null.'),
            self::KEY_EMAIL => TypeSafe::getString($data[self::KEY_EMAIL]) ?? throw new LogicException('Email cannot be null.'),
            self::KEY_PASSWORD => Hash::make(TypeSafe::getString($data[self::KEY_PASSWORD]) ?? throw new LogicException('Password cannot be null.')),
        ];

        $user = $this->userRepository->findByEmail($entry[self::KEY_EMAIL]);

        if ($user) {
            Log::error(self::KEY_DUPLICATE_USER_MESSAGE, [self::KEY_EMAIL => $entry[self::KEY_EMAIL]]);

            throw new UserAlreadyExistsException;
        }

        try {
            $user = $this->userRepository->create($entry);
            Log::info(self::KEY_USER_CREATED_MESSAGE, [self::KEY_ID => $user->id]);
            $token = $this->tokenService->assignAuthToken($user);
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [self::KEY_EXCEPTION => $exception->getTraceAsString()]);

            throw $exception;
        }

        return (new UserDataV1())
            ->setToken($token)
            ->setFirstname($user->firstname)
            ->setLastname($user->lastname)
            ->setEmail($user->email);
    }

    /**
     * @param array<string, mixed> $data
     *
     * @throws Exception|InvalidPasswordException|UserNotFoundException
     */
    public function loginUser(array $data): UserDataV1
    {
        $entry = [
            self::KEY_EMAIL => TypeSafe::getString($data[self::KEY_EMAIL]) ?? throw new LogicException('Email cannot be null.'),
            self::KEY_PASSWORD => TypeSafe::getString($data[self::KEY_PASSWORD]) ?? throw new LogicException('Password cannot be null.'),
        ];

        $user = $this->userRepository->findByEmail($entry[self::KEY_EMAIL]);

        if (!$user) {
            Log::error(self::KEY_USER_NOT_FOUND_MESSAGE);

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

        return (new UserDataV1())
            ->setFirstname($user->firstname)
            ->setLastname($user->lastname)
            ->setEmail($user->email)
            ->setToken($token);
    }
}
