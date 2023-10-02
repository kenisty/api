<?php

namespace App\DTOs\Responses;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'ServerExceptionWriteV1', title: 'ServerExceptionWriteV1')]
class ServerExceptionWriteV1
{
    #[OA\Property(type: 'integer')]
    private ?int $code;
    #[OA\Property(type: 'string')]
    private ?string $message;
}
