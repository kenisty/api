<?php declare(strict_types=1);

namespace App\Services\User;

use Illuminate\Support\Facades\Hash;

readonly class PasswordService
{
    public function checkPassword(string $enteredPassword, $userPasswordInDatabase): bool
    {
        return Hash::check($enteredPassword, $userPasswordInDatabase);
    }
}
