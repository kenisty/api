<?php declare(strict_types=1);

namespace App\DTOs\Responses;

use App\DTOs\Schemas\UserDataV1;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'UserRegisterWriteV1', title: 'UserRegisterWriteV1')]
final readonly class UserRegisterWriteV1
{
    #[OA\Property(type: 'string')]
    private ?string $message;

    #[OA\Property(ref: '#/components/schemas/UserDataV1')]
    private ?UserDataV1 $data;

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setData(?UserDataV1 $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getData(): ?UserDataV1
    {
        return $this->data;
    }
}
