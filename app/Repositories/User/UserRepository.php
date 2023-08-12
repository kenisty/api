<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User\User;
use App\Repositories\RepositoryAbstractClass;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends RepositoryAbstractClass
{
    protected function getAll(): Collection
    {
        return User::all();
    }

    protected function find(string $id): User|null
    {
        return User::find($id);
    }

    protected function findByEmail(string $email): User|null
    {
        return User::where('email', $email)->first();
    }

    protected function create(mixed $entry): User
    {
        return User::create($entry);
    }

    protected function update(string $id, mixed $entry): User
    {
        return User::findOrFail($id)->update($entry);
    }

    protected function delete(string $id): void
    {
        User::findOrFail($id)->delete();
    }
}
