<?php

namespace App\Http\Responses\User;

use App\DTOs\User\UserDTO;
use App\Enum\ENV;
use App\Enum\ResponseCode;
use App\Enum\ResponseStatus;
use App\Http\Responses\AbstractResponse;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class RegisterUserResponse extends AbstractResponse
{
    use ResponseTrait;

    // TODO: implement localization
    private const USER_REGISTERED_MESSAGE = 'User registered successfully';

    private const KEY_USER = 'user';
    private const KEY_FIRST_NAME = 'first_name';
    private const KEY_LAST_NAME = 'last_name';
    private const KEY_EMAIL = 'email';
    private const KEY_TOKEN = 'token';

    /**
     * @param UserDTO $dto
     * @return array<string, mixed>
     */
    protected function schema(mixed $dto): array
    {
        return [
            self::KEY_TOKEN => $dto->getToken(),
            self::KEY_USER => [
                self::KEY_FIRST_NAME => $dto->getFirstname(),
                self::KEY_LAST_NAME => $dto->getLastname(),
                self::KEY_EMAIL => $dto->getEmail(),
            ],
        ];
    }

    public function success(UserDTO $userDTO): JsonResponse
    {
        return $this->successResponse(
            ResponseStatus::CREATED,
            ResponseCode::ACCEPTED_AND_CREATED_CODE,
            self::USER_REGISTERED_MESSAGE,
            $this->schema($userDTO)
        );
    }

    public function fail(Exception $exception): JsonResponse
    {
        return $this->failResponse(
            ResponseStatus::RESOURCE_CREATION_FAILED,
            ResponseCode::BAD_REQUEST_CODE,
            $exception->getMessage(),
            config('app.env') === ENV::DEV->value
                ? $exception->getTrace()
                : $exception->getMessage()
        );
    }
}
