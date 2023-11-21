<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Services\User\UserService;
use Exception;
use OpenAPI\Client\Kenisty\ExceptionV1;
use OpenAPI\Client\Kenisty\UserDataV1;
use OpenAPI\Client\Kenisty\UserLoginWriteV1;
use OpenAPI\Client\Kenisty\UserRegisterWriteV1;

class AuthControllerV1 extends Controller
{
    private const AUTH_LOGIN_SUCCESS_RESPONSE_MESSAGE = 'auth.login.success.response.message';
    private const AUTH_REGISTER_SUCCESS_RESPONSE_MESSAGE = 'auth.register.success.response.message';
    private const KEY_FIRST_NAME = 'firstname';
    private const KEY_LAST_NAME = 'lastname';
    private const KEY_EMAIL = 'email';
    private const KEY_PASSWORD = 'password';

    public function __construct(private readonly UserService $userService) { }

    public function register(RegisterUserRequest $request): UserRegisterWriteV1|ExceptionV1
    {
        $data = $request->safe([
            self::KEY_FIRST_NAME,
            self::KEY_LAST_NAME,
            self::KEY_EMAIL,
            self::KEY_PASSWORD,
        ]);

        try {
            $createdUserDTO = $this->userService->registerUser($data);
        } catch (Exception $exception) {
            return (new ExceptionV1())
                ->setCode($exception->getCode())
                ->setMessage($exception->getMessage());
        }

        return (new UserRegisterWriteV1())
            ->setMessage(trans(self::AUTH_REGISTER_SUCCESS_RESPONSE_MESSAGE))
            ->setUser(
                (new UserDataV1())
                    ->setToken($createdUserDTO->getToken())
                    ->setFirstName($createdUserDTO->getFirstname())
                    ->setLastName($createdUserDTO->getLastname())
                    ->setEmail($createdUserDTO->getEmail()),
            );
    }

    public function login(LoginUserRequest $request): UserLoginWriteV1|ExceptionV1
    {
        $data = $request->safe([
            self::KEY_EMAIL,
            self::KEY_PASSWORD,
        ]);

        try {
            $loggedInUserDTO = $this->userService->loginUser($data);
        } catch (Exception  $exception) {
            return (new ExceptionV1())
                ->setCode($exception->getCode())
                ->setMessage($exception->getMessage());
        }

         return (new UserLoginWriteV1())
             ->setMessage(trans(self::AUTH_LOGIN_SUCCESS_RESPONSE_MESSAGE))
             ->setUser(
                 (new UserDataV1())
                     ->setToken($loggedInUserDTO->getToken())
                     ->setFirstName($loggedInUserDTO->getFirstname())
                     ->setLastName($loggedInUserDTO->getLastname())
                     ->setEmail($loggedInUserDTO->getEmail()),
             );
    }
}
