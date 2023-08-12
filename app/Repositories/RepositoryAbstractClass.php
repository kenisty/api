<?php

declare(strict_types = 1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

abstract class RepositoryAbstractClass
{
    abstract protected function getAll(): Collection;

    abstract protected function find(string $id): mixed;

    abstract protected function create(mixed $entry): mixed;

    abstract protected function update(string $id, mixed $entry): mixed;

    abstract protected function delete(string $id): void;
}
