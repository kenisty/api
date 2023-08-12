<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User\Permission;
use App\Repositories\RepositoryAbstractClass;
use Illuminate\Database\Eloquent\Collection;

class PermissionRepository extends RepositoryAbstractClass
{
    /** @return Collection<array-key, Permission> */
    protected function getAll(): Collection
    {
        return Permission::all();
    }

    protected function find(string $id): Permission|null
    {
        return Permission::find($id);
    }

    protected function findByPermission(string $permission): Permission|null
    {
        return Permission::where('permission', $permission)->first();
    }

    protected function create(mixed $entry): Permission
    {
        return Permission::create($entry);
    }

    protected function update(string $id, mixed $entry): Permission
    {
        return Permission::findOrFail($id)->update($entry);
    }

    protected function delete(string $id): void
    {
        Permission::findOrFail($id)->delete();
    }
}
