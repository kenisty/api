<?php

namespace App\DTOs\Exception;

use App\DTOs\DefaultDTOInterface;

final readonly class ExceptionDTO implements DefaultDTOInterface
{
    private const KEY_CODE = 'code';
    private const KEY_MESSAGE = 'message';

    private ?int $code;
    private ?string $message;

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return [
            self::KEY_CODE => $this->getCode(),
            self::KEY_MESSAGE => $this->getMessage(),
        ];
    }

    public function fromArray(array $data): ExceptionDTO
    {
        return (new self())
            ->setCode($data[self::KEY_CODE] ?? null)
            ->setMessage($data[self::KEY_MESSAGE] ?? null);
    }

    public function setCode(?int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }
}