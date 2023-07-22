<?php

namespace App\Repositories\User;

use App\Models\User\Permission;
use App\Repositories\RepositoryAbstractClass;
use Illuminate\Database\Eloquent\Collection;

class PermissionRepository extends RepositoryAbstractClass
{
    public function getAll(): Collection
    {
        return Permission::all();
    }

    public function find(string $id): Permission|null
    {
        return Permission::find($id);
    }

    public function findByPermission(string $permission): Permission|null
    {
        return Permission::where('permission', $permission)->first();
    }

    public function create(mixed $entry): Permission
    {
        return Permission::create($entry);
    }

    public function update(string $id, mixed $entry): Permission
    {
        return Permission::findOrFail($id)->update($entry);
    }

    public function delete(string $id): void
    {
        Permission::findOrFail($id)->delete();
    }
}
