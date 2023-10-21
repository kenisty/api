<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User\User;
use App\Repositories\DefaultRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * @implements DefaultRepositoryInterface<User>
 */
class UserRepository implements DefaultRepositoryInterface
{
    /**
     * @return Collection<int, User>
     */
    public function getAll(): Collection
    {
        return User::all();
    }

    public function find(string $id): User|null
    {
        return User::find($id);
    }

    public function findByEmail(string $email): User|null
    {
        return User::where('email', $email)->first();
    }

    public function create(array $entry): User
    {
        return User::create($entry);
    }

    public function update(string $id, array $entry): bool
    {
        return User::findOrFail($id)->update($entry);
    }

    public function delete(string $id): void
    {
        User::findOrFail($id)->delete();
    }
}
