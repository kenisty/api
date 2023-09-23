<?php declare(strict_types=1);

namespace App\DTOs;

interface DefaultDTOInterface
{
    public function toArray(): array;

    public function fromArray(array $data): mixed;
}
