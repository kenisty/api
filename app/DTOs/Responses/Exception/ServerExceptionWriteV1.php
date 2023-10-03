<?php declare(strict_types=1);

namespace App\DTOs\Responses\Exception;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'ServerExceptionWriteV1', title: 'ServerExceptionWriteV1', description: 'Response schema for a generic server error V1.')]
class ServerExceptionWriteV1
{
    #[OA\Property(type: 'integer')]
    private ?int $code;

    #[OA\Property(type: 'string')]
    private ?string $message;
}
