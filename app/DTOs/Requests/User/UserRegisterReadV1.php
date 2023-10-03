<?php declare(strict_types=1);

namespace App\DTOs\Requests\User;

use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'UserRegisterReadV1', title: 'UserRegisterReadV1')]
final readonly class UserRegisterReadV1
{
    #[OA\Property(property: 'firstname', title: 'Firstname', type: 'string', maxLength: 255, minLength: 3, nullable: false)]
    private ?string $firstname;

    #[OA\Property(property: 'lastname', title: 'Lastname', type: 'string', maxLength: 255, minLength: 3, nullable: false)]
    private ?string $lastname;

    #[OA\Property(property: 'email', title: 'Email', type: 'string', maxLength: 255, minLength: 3, nullable: false)]
    private ?string $email;

    #[OA\Property(property: 'password', title: 'Password', type: 'string', maxLength: 255, minLength: 8, nullable: false)]
    private ?string $password;

    #[OA\Property(property: 'password_confirmation', title: 'Password Confirmation', type: 'string', maxLength: 255, minLength: 8, nullable: false)]
    private ?string $passwordConfirmation;
}
