<?php

namespace App\Response\User;

use App\DTOs\User\UserDTO;
use App\Enum\ENV;
use App\Enum\ResponseCode;
use App\Enum\ResponseStatus;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class RegisterUserResponse
{
    use ResponseTrait;

    // TODO: implement localization
    private const USER_REGISTERED_MESSAGE = 'User registered successfully';

    private const KEY_USER = 'user';
    private const KEY_FIRST_NAME = 'first_name';
    private const KEY_LAST_NAME = 'last_name';
    private const KEY_EMAIL = 'email';
    private const KEY_PASSWORD = 'password';
    private const KEY_TOKEN = 'token';

    public function fail(Exception $exception): JsonResponse
    {
        return $this->failResponse(
            ResponseStatus::RESOURCE_CREATION_FAILED,
            ResponseCode::BAD_REQUEST_CODE,
            $exception->getMessage(),
            config('env') === ENV::DEV->value
                ? $exception->getTrace()
                : $exception->getMessage()
        );
    }

    public function success(UserDTO $userDTO): JsonResponse
    {
        $data = [
            self::KEY_TOKEN => $userDTO->getToken(),
            self::KEY_USER => [
                self::KEY_FIRST_NAME => $userDTO->getFirstname(),
                self::KEY_LAST_NAME => $userDTO->getLastname(),
                self::KEY_EMAIL => $userDTO->getEmail(),
                self::KEY_TOKEN => $userDTO->getToken(),
            ],
        ];

        return $this->successResponse(
            ResponseStatus::CREATED,
            ResponseCode::ACCEPTED_AND_CREATED_CODE,
            self::USER_REGISTERED_MESSAGE,
            $data
        );
    }
}
