<?php declare(strict_types=1);

namespace App\Normalizers;

use App\DTOs\User\UserDataV1;
use App\Models\User\User;

/**
 * @implements DefaultNormalizerInterface<UserNormalizer>
 */
class UserNormalizer implements DefaultNormalizerInterface
{
    /**
     * @param User $model
     */
    public static function normalize(mixed $model): UserDataV1
    {
        return (new UserDataV1())
            ->setFirstname($model->firstname)
            ->setLastname($model->lastname)
            ->setEmail($model->email);
    }
}
