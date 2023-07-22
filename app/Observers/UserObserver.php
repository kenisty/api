<?php

namespace App\Observers;

use App\Models\User\User;
use App\Services\Cache\UserCacheService;

readonly class UserObserver
{
    public function __construct(
        private UserCacheService $userCacheService
    ) {}

    public function created(User $user): void
    {
        $this->userCacheService->setUserRolesCache($user);
    }

    public function updated(User $user): void
    {
        $this->userCacheService->removeUserRolesCache($user);
        $this->userCacheService->setUserRolesCache($user);
    }

    public function deleted(User $user): void
    {
        $this->userCacheService->removeUserRolesCache($user);
    }

    public function forceDeleted(User $user): void
    {
        $this->userCacheService->removeUserRolesCache($user);
    }

    public function restored(User $user): void
    {
        $this->userCacheService->removeUserRolesCache($user);
        $this->userCacheService->setUserRolesCache($user);
    }
}
