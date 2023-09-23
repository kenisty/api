<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\DTOs\Exception\ExceptionDTO;
use App\Enum\ResponseCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Responses\User\UserFailedLoginResponse;
use App\Http\Responses\User\UserFailedRegistrationResponse;
use App\Http\Responses\User\UserSuccessfulRegistrationResponse;
use App\Http\Responses\User\UserSuccessLoginResponse;
use App\Services\User\UserService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    private const KEY_FIRST_NAME = 'first_name';
    private const KEY_LAST_NAME = 'last_name';
    private const KEY_EMAIL = 'email';
    private const KEY_PASSWORD = 'password';

    public function __construct(
        private readonly UserService $userService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function register(RegisterUserRequest $request): JsonResponse
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
            return (new UserFailedRegistrationResponse())
                ->setDto(
                    (new ExceptionDTO())
                        ->setCode(ResponseCode::tryFrom($exception->getCode()))
                        ->setMessage($exception->getMessage()),
                )->getResponse();
        }

        return (new UserSuccessfulRegistrationResponse())
            ->setResponseCode(ResponseCode::ACCEPTED_AND_CREATED)
            ->setDto($createdUserDTO)
            ->getResponse();
    }

    /**
     * @throws Exception
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $data = $request->safe([
            self::KEY_EMAIL,
            self::KEY_PASSWORD,
        ]);

        try {
            $loggedInUserDTO = $this->userService->loginUser($data);
        } catch (Exception  $exception) {
            return (new UserFailedLoginResponse())
                ->setDto(
                    (new ExceptionDTO())
                        ->setCode(ResponseCode::tryFrom($exception->getCode()))
                        ->setMessage($exception->getMessage()),
                )->getResponse();
        }

         return (new UserSuccessLoginResponse())
             ->setResponseCode(ResponseCode::ACCEPTED)
             ->setDto($loggedInUserDTO)
             ->getResponse();
    }
}
