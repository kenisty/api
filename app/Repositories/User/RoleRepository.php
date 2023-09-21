<?php declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User\Role;
use App\Repositories\DefaultRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository implements DefaultRepositoryInterface
{
    public function getAll(): Collection
    {
        return Role::all();
    }

    public function find(string $id): mixed
    {
        return Role::find($id);
    }

    public function findByRole(string $role): mixed
    {
        return Role::where('role', $role)->first();
    }

    public function create(mixed $entry): mixed
    {
        return Role::create($entry);
    }

    public function update(string $id, mixed $entry): mixed
    {
        return Role::findOrFail($id)->update($entry);
    }

    public function delete(string $id): void
    {
        Role::findOrFail($id)->delete();
    }
}
