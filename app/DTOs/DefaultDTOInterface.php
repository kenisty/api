<?php

namespace App\DTOs;

interface DefaultDTOInterface
{
    public function toArray(): array;
    public function fromArray(array $data): mixed;
}
