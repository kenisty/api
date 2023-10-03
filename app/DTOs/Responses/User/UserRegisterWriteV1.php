<?php declare(strict_types=1);

namespace App\DTOs\Responses\User;

use App\DTOs\Schemas\User\UserDataV1;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'UserRegisterWriteV1', title: 'UserRegisterWriteV1', description: 'Response schema for successfully registering a new user V1.')]
final readonly class UserRegisterWriteV1
{
    #[OA\Property(type: 'string')]
    private ?string $message;

    #[OA\Property(ref: '#/components/schemas/UserDataV1')]
    private ?UserDataV1 $data;
}
