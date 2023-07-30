<?php

namespace App\Http\Controllers\User;

use App\DTOs\User\UserDTO;
use App\Enum\ResponseCode;
use App\Enum\ResponseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterUserRequest;
use App\Response\User\RegisterUserResponse;
use App\Services\User\UserService;
use App\Traits\ResponseTrait;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    use ResponseTrait;

    private const KEY_FIRST_NAME = 'first_name';
    private const KEY_LAST_NAME = 'last_name';
    private const KEY_EMAIL = 'email';
    private const KEY_PASSWORD = 'password';

    public function __construct(
        private readonly UserService $userService,
    ) {}

    public function register(RegisterUserRequest $request): JsonResponse
    {
        $data = $request->safe([
            self::KEY_FIRST_NAME,
            self::KEY_LAST_NAME,
            self::KEY_EMAIL,
            self::KEY_PASSWORD,
        ]);

        $userDTO = (new UserDTO())
            ->setFirstname($data[self::KEY_FIRST_NAME])
            ->setLastname($data[self::KEY_LAST_NAME])
            ->setEmail($data[self::KEY_EMAIL])
            ->setPassword($data[self::KEY_PASSWORD]);

        try {
            $createdUserDTO = $this->userService->createUser($userDTO);
        } catch (Exception $exception) {
            return (new RegisterUserResponse())->fail($exception);
        }

        return (new RegisterUserResponse())->success($createdUserDTO);
    }
}
