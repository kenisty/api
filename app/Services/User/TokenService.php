<?php declare(strict_types=1);

namespace App\Services\User;

use App\Models\User\User;

readonly class TokenService
{
    private const KEY_CREATE_USER_TOKEN_NAME = 'userToken';

    public function assignAuthToken(User $user): string|null
    {
        $user->tokens()->delete();

        return $user->createToken(self::KEY_CREATE_USER_TOKEN_NAME)->plainTextToken;
    }
}
