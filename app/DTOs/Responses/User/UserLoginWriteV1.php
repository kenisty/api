<?php declare(strict_types=1);

namespace App\DTOs\Responses\User;

use App\DTOs\Schemas\User\UserDataV1;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'UserLoginWriteV1', title: 'UserLoginWriteV1', description: 'Response schema for successfully logging in an existing user V1.')]
final readonly class UserLoginWriteV1
{
    #[OA\Property(type: 'string')]
    private ?string $message;

    #[OA\Property(ref: '#/components/schemas/UserDataV1')]
    private ?UserDataV1 $data;
}
