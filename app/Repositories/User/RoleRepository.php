<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User\Role;
use App\Repositories\RepositoryAbstractClass;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository extends RepositoryAbstractClass
{
    protected function getAll(): Collection
    {
        return Role::all();
    }

    protected function find(string $id): Role|null
    {
        return Role::find($id);
    }

    protected function findByRole(string $role): Role|null
    {
        return Role::where('role', $role)->first();
    }

    protected function create(mixed $entry): Role
    {
        return Role::create($entry);
    }

    protected function update(string $id, mixed $entry): Role
    {
        return Role::findOrFail($id)->update($entry);
    }

    protected function delete(string $id): void
    {
        Role::findOrFail($id)->delete();
    }
}
