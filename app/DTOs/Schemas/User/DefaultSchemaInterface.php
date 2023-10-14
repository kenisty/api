<?php declare(strict_types=1);

namespace App\DTOs\Schemas\User;

interface DefaultSchemaInterface
{
    public function toArray(): array;

    public function fromArray(array $data): mixed;
}
