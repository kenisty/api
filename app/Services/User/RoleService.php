<?php declare(strict_types=1);

namespace App\Services\User;

use App\Models\User\User;
use App\Repositories\User\RoleRepository;
use Illuminate\Support\Facades\Log;

readonly class RoleService
{
    private const KEY_ID = 'id';
    private const KEY_DEFAULT_ROLE = 'user';
    private const KEY_USER_ASSIGNED_DEFAULT_ROLE_MESSAGE = 'Default role [' . self::KEY_DEFAULT_ROLE . '] assigned to the user in the database.';

    public function __construct(
        private RoleRepository $roleRepository,
    ) {
    }

    public function assignUserDefaultRole(User $user): void
    {
        $defaultRole = $this->roleRepository->findByRole(self::KEY_DEFAULT_ROLE);

        $user->roles()->attach($defaultRole);

        Log::info(self::KEY_USER_ASSIGNED_DEFAULT_ROLE_MESSAGE, [self::KEY_ID => $user->id]);
    }
}
