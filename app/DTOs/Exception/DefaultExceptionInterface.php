<?php declare(strict_types=1);

namespace App\DTOs\Schemas\Exception;

interface DefaultExceptionInterface
{
    public function setCode(?int $code = null): self;

    public function getCode(): ?int;

    public function setMessage(?string $message = null): self;

    public function getMessage(): ?string;
}
