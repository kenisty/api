<?php declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @template T as Model
 */
interface DefaultRepositoryInterface
{
    /**
     * @return Collection<int, T>
     */
    public function getAll(): Collection;

    public function find(string $id): mixed;

    /**
     * @param array<string, mixed> $entry
     *
     * @return T
     */
    public function create(array $entry): mixed;

    /**
     * @param array<string, mixed> $entry
     */
    public function update(string $id, array $entry): bool;

    public function delete(string $id): void;
}
