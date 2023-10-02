<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Enum\ResponseCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Services\User\UserService;
use Exception;
use OpenApi\Attributes as OA;
use OpenAPI\Client\Kenisty\ServerExceptionWriteV1;
use OpenAPI\Client\Kenisty\UserDataV1;
use OpenAPI\Client\Kenisty\UserRegisterWriteV1;

class AuthControllerV1 extends Controller
{
    public const AUTH_LOGIN_SUCCESS_RESPONSE_MESSAGE = 'auth.login.success.response.message';
    private const AUTH_REGISTER_SUCCESS_RESPONSE_MESSAGE = 'auth.register.success.response.message';
    private const KEY_FIRST_NAME = 'firstname';
    private const KEY_LAST_NAME = 'lastname';
    private const KEY_EMAIL = 'email';
    private const KEY_PASSWORD = 'password';

    public function __construct(private readonly UserService $userService) { }

    #[OA\Post(
        path: '/v1/auth/register',
        requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: '#/components/schemas/UserRegisterReadV1')),
        responses: [
            new OA\Response(response: 201, description: 'Successfully logged in an existing user.', content: new OA\JsonContent(ref: '#/components/schemas/UserRegisterWriteV1')),
            new OA\Response(response: 422, description: 'Failed validation.'),
        ],
    )]
    public function register(RegisterUserRequest $request): UserRegisterWriteV1|ServerExceptionWriteV1
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
            return (new ServerExceptionWriteV1())
                ->setCode($exception->getCode())
                ->setMessage($exception->getMessage());
        }

        return (new UserRegisterWriteV1())
            ->setMessage(trans(self::AUTH_REGISTER_SUCCESS_RESPONSE_MESSAGE))
            ->setData(
                (new UserDataV1())
                    ->setToken($createdUserDTO->getToken())
                    ->setFirstName($createdUserDTO->getFirstname())
                    ->setLastName($createdUserDTO->getLastname())
                    ->setEmail($createdUserDTO->getEmail()),
            );
    }

    /**
     * @throws Exception
     */
    public function login(LoginUserRequest $request): UserSuccessfullyLoggedIn|ServerExceptionWriteV1
    {
        $data = $request->safe([
            self::KEY_EMAIL,
            self::KEY_PASSWORD,
        ]);

        try {
            $loggedInUserDTO = $this->userService->loginUser($data);
        } catch (Exception  $exception) {
            return (new ServerExceptionWriteV1())
                ->setCode(ResponseCode::tryFrom($exception->getCode()))
                ->setMessage($exception->getMessage());
        }

         return (new UserSuccessfullyLoggedIn())
             ->setMessage(trans(self::AUTH_LOGIN_SUCCESS_RESPONSE_MESSAGE))
             ->setData(
                 (new AuthData())
                     ->setToken($loggedInUserDTO->getToken())
                     ->setFirstName($loggedInUserDTO->getFirstname())
                     ->setLastName($loggedInUserDTO->getLastname())
                     ->setEmail($loggedInUserDTO->getEmail()),
             );
    }
}
