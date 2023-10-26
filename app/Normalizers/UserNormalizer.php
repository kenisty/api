<?php declare(strict_types=1);

namespace App\Normalizers;

use App\DTOs\User\UserDataV1;
use App\Models\User\User;

class UserNormalizer extends AbstractNormalizer
{
    public const KEY_MODEL_NAME = 'api_user';

    /**
     * @param User $model
     */
    protected function normalizeData(mixed $model): UserDataV1
    {
        return (new UserDataV1())
            ->setFirstname($model->firstname)
            ->setLastname($model->lastname)
            ->setEmail($model->email);
    }

    protected function getModelName(): string
    {
        return self::KEY_MODEL_NAME;
    }
}
