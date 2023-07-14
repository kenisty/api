<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User\User;
use App\Repositories\RepositoryAbstractClass;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class UserRepository extends RepositoryAbstractClass
{
    /**
     * @return Collection<User>
     */
    public function getAll(): Collection
    {
        return User::all();
    }

    /**
     * @param string $id
     * @return User
     */
    public function find(string $id): User
    {
        return User::find($id);
    }

    /**
     * @param mixed $entry
     * @return User
     */
    public function create(mixed $entry): User
    {
        $user = User::create($entry);
        Log::info('Created a user in the database.', ['id' => $user->id]);
        return $user;
    }

    /**
     * @param string $id
     * @param mixed $entry
     * @return User
     */
    public function update(string $id, mixed $entry): User
    {
        return User::where($id)->update($entry);
    }

    /**
     * @param string $id
     * @return void
     */
    public function delete(string $id): void
    {
        User::where($id)->delete();
    }
}
