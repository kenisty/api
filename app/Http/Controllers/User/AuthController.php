<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Attributes\ApiVersion;
use App\Enum\ResponseCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\Request;
use OpenAPI\Client\Kenisty\AuthData;
use OpenAPI\Client\Kenisty\Exception as ServerException;
use OpenAPI\Client\Kenisty\UserSuccessfullyLoggedIn;
use OpenAPI\Client\Kenisty\UserSuccessfullyRegistered;

#[ApiVersion(since: 1)]
class AuthController extends Controller
{
    public const AUTH_LOGIN_SUCCESS_RESPONSE_MESSAGE = 'auth.login.success.response.message';
    private const AUTH_REGISTER_SUCCESS_RESPONSE_MESSAGE = 'auth.register.success.response.message';
    private const KEY_FIRST_NAME = 'first_name';
    private const KEY_LAST_NAME = 'last_name';
    private const KEY_EMAIL = 'email';
    private const KEY_PASSWORD = 'password';

    public function __construct(
        private readonly UserService $userService,
        private readonly Request $request,
    ) {
        parent::__construct(self::class, $this->request->getUri());
    }

    /**
     * @throws Exception
     */
    public function register(RegisterUserRequest $request): UserSuccessfullyRegistered|ServerException
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
            return (new ServerException())
                ->setCode(ResponseCode::tryFrom($exception->getCode()))
                ->setMessage($exception->getMessage());
        }

        return (new UserSuccessfullyRegistered())
            ->setMessage(trans(self::AUTH_REGISTER_SUCCESS_RESPONSE_MESSAGE))
            ->setData(
                (new AuthData())
                    ->setToken($createdUserDTO->getToken())
                    ->setFirstName($createdUserDTO->getFirstname())
                    ->setLastName($createdUserDTO->getLastname())
                    ->setEmail($createdUserDTO->getEmail()),
            );
    }

    /**
     * @throws Exception
     */
    public function login(LoginUserRequest $request): UserSuccessfullyLoggedIn|ServerException
    {
        $data = $request->safe([
            self::KEY_EMAIL,
            self::KEY_PASSWORD,
        ]);

        try {
            $loggedInUserDTO = $this->userService->loginUser($data);
        } catch (Exception  $exception) {
            return (new ServerException())
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
