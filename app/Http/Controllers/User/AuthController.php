<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\DTOs\Exception\ExceptionDTO;
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
            $createdUserDTO = $this->userService->createUser($data);
        } catch (Exception $exception) {
            $exceptionDTO = (new ExceptionDTO())
                ->setCode($exception->getCode())
                ->setMessage($exception->getMessage());

            return (new UserFailedRegistrationResponse())->getResponse($exceptionDTO);
        }

        return (new UserSuccessfulRegistrationResponse())->getResponse($createdUserDTO);
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
            $exceptionDTO = (new ExceptionDTO())
                ->setCode($exception->getCode())
                ->setMessage($exception->getMessage());

            return (new UserFailedLoginResponse())->getResponse($exceptionDTO);
        }

         return (new UserSuccessLoginResponse())->getResponse($loggedInUserDTO);
    }
}
