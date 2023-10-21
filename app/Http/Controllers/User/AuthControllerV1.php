<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Services\User\UserService;
use Exception;
use OpenApi\Attributes as OA;
use OpenAPI\Client\Kenisty\UserDataV1;
use OpenAPI\Client\Kenisty\UserLoginWriteV1;
use OpenAPI\Client\Kenisty\UserRegisterWriteV1;
use OpenAPI\Client\Kenisty\ValidationExceptionV1;

class AuthControllerV1 extends Controller
{
    public const AUTH_LOGIN_SUCCESS_RESPONSE_MESSAGE = 'auth.login.success.response.message';
    private const AUTH_REGISTER_SUCCESS_RESPONSE_MESSAGE = 'auth.register.success.response.message';
    private const KEY_FIRST_NAME = 'firstname';
    private const KEY_LAST_NAME = 'lastname';
    private const KEY_EMAIL = 'email';
    private const KEY_PASSWORD = 'password';
    private const KEY_PASSWORD_CONFIRMATION = 'password_confirmation';

    public function __construct(private readonly UserService $userService) { }

    #[OA\Post(
        path: '/v1/auth/register',
        description: 'Request for registering new users in. Returns a status code of 201 if the user was able to successfully register attached with an authentication token.',
        summary: 'A request to register a new user.',
        security: [],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                title: 'UserRegisterReadV1',
                description: 'Request schema for registering a new user V1',
                properties: [
                    new OA\Property(property: self::KEY_FIRST_NAME, title: 'Firstname', type: 'string', maxLength: 255, minLength: 3, nullable: false),
                    new OA\Property(property: self::KEY_LAST_NAME, title: 'Lastname', type: 'string', maxLength: 255, minLength: 3, nullable: false),
                    new OA\Property(property: self::KEY_EMAIL, title: 'Email', type: 'string', maxLength: 255, minLength: 3, nullable: false),
                    new OA\Property(property: self::KEY_PASSWORD, title: 'Password', type: 'string', maxLength: 255, minLength: 8, nullable: false),
                    new OA\Property(property: self::KEY_PASSWORD_CONFIRMATION, title: 'Password Confirmation', type: 'string', maxLength: 255, minLength: 8, nullable: false),
                ],
            ),
        ),
        tags: ['Authentication'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully registered a new user.',
                content: new OA\JsonContent(
                    title: 'UserRegisterWriteV1',
                    description: 'Response schema for successfully registering a new user V1.',
                    properties: [
                        new OA\Property(property: 'message', title: 'Message', type: 'string'),
                        new OA\Property(property: 'user', ref: '#/components/schemas/UserDataV1', title: 'User'),
                    ],
                ),
            ),
            new OA\Response(
                response: 422,
                description: 'Failed validation.',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ValidationExceptionV1',
                    title: 'ValidationExceptionV1',
                    description: 'Response schema for failing registering a new user V1.',
                ),
            ),
        ],
    )]
    public function register(RegisterUserRequest $request): UserRegisterWriteV1|ValidationExceptionV1
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
            return (new ValidationExceptionV1())
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

    #[OA\Post(
        path: '/v1/auth/login',
        description: 'Request for logging existing users in. Returns a status code of 200 if the user was able to successfully login in attached with an authentication token.',
        summary: 'A request to login a user.',
        security: [],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                title: 'UserLoginReadV1',
                description: 'Request schema for logging in an existing user V1',
                properties: [
                    new OA\Property(property: self::KEY_EMAIL, title: 'Email', type: 'string', nullable: false),
                    new OA\Property(property: self::KEY_PASSWORD, title: 'Password', type: 'string', nullable: false),
                ],
            ),
        ),
        tags: ['Authentication'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully logged in an existing user.',
                content: new OA\JsonContent(
                    title: 'UserLoginWriteV1',
                    description: 'Response schema for successfully logging in an existing user V1.',
                    properties: [
                        new OA\Property(property: 'message', title: 'Message', type: 'string'),
                        new OA\Property(property: 'user', ref: '#/components/schemas/UserDataV1', title: 'User'),
                    ],
                ),
            ),
            new OA\Response(
                response: 422,
                description: 'Failed validation.',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ValidationExceptionV1',
                    title: 'ValidationExceptionV1',
                    description: 'Response schema for failing logging in an existing user V1.',
                ),
            ),
        ],
    )]
    public function login(LoginUserRequest $request): UserLoginWriteV1|ValidationExceptionV1
    {
        $data = $request->safe([
            self::KEY_EMAIL,
            self::KEY_PASSWORD,
        ]);

        try {
            $loggedInUserDTO = $this->userService->loginUser($data);
        } catch (Exception  $exception) {
            return (new ValidationExceptionV1())
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
