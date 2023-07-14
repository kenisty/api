<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

abstract class RepositoryAbstractClass
{
    abstract public function getAll(): Collection;
    abstract public function find(string $id): mixed;
    abstract public function create(mixed $entry): mixed;
    abstract public function update(string $id, mixed $entry): mixed;
    abstract public function delete(string $id);
}
