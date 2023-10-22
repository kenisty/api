<?php declare(strict_types=1);

namespace App\DTOs\Exception;

use App\DTOs\DefaultDtoInterface;
use App\Services\TypeSafe;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'ValidationExceptionV1', title: 'ValidationExceptionV1', description: 'Response schema for a generic validation error V1.')]
final class ValidationExceptionV1 implements DefaultDtoInterface, DefaultExceptionInterface
{
    private const KEY_CODE = 'code';
    private const KEY_MESSAGE = 'message';

    #[OA\Property(property: self::KEY_CODE, title: 'Error code', type: 'string')]
    private ?int $code = 422;

    #[OA\Property(property: self::KEY_MESSAGE, title: 'Message', type: 'string')]
    private ?string $message = null;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            self::KEY_CODE => $this->getCode(),
            self::KEY_MESSAGE => $this->getMessage(),
        ];
    }

    /**
     * @param array<string, int|string|null> $data
     */
    public static function fromArray(array $data): self
    {
        return (new self())
            ->setCode(TypeSafe::getInt($data[self::KEY_CODE] ?? null))
            ->setMessage(TypeSafe::getString($data[self::KEY_MESSAGE] ?? null));
    }

    public function setCode(?int $code = null): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setMessage(?string $message = null): self
    {
        $this->message = $message;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }
}
