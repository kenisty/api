<?php

namespace App\Repositories\User;

use App\Models\User\Role;
use App\Repositories\RepositoryAbstractClass;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository extends RepositoryAbstractClass
{
    public function getAll(): Collection
    {
        return Role::all();
    }

    public function find(string $id): Role|null
    {
        return Role::find($id);
    }

    public function findByRole(string $role): Role|null
    {
        return Role::where('role', $role)->first();
    }

    public function create(mixed $entry): Role
    {
        return Role::create($entry);
    }

    public function update(string $id, mixed $entry): Role
    {
        return Role::findOrFail($id)->update($entry);
    }

    public function delete(string $id): void
    {
        Role::findOrFail($id)->delete();
    }
}
