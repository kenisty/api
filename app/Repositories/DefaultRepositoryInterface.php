<?php declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface DefaultRepositoryInterface
{
    public function getAll(): Collection;

    public function find(string $id): mixed;

    public function create(mixed $entry): mixed;

    public function update(string $id, mixed $entry): mixed;

    public function delete(string $id): void;
}
