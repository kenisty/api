<?php

namespace App\Http\Responses;

abstract class AbstractResponse
{
    /**
     * @return array<string, mixed>
     */
    abstract protected function schema(mixed $dto): array;
}
