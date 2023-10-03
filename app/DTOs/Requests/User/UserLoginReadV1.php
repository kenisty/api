<?php declare(strict_types=1);

namespace App\DTOs\Requests\User;

use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'UserLoginReadV1', title: 'UserLoginReadV1', description: 'Request schema for logging in a user V1.')]
final readonly class UserLoginReadV1
{
    #[OA\Property(property: 'email', title: 'Email', type: 'string', nullable: false)]
    private ?string $email;

    #[OA\Property(property: 'password', title: 'Password', type: 'string', nullable: false)]
    private ?string $password;
}
