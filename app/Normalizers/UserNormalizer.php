<?php declare(strict_types=1);

namespace App\Normalizers;

use App\Models\User\User;

/**
 * @implements DefaultNormalizerInterface<UserNormalizer>
 */
class UserNormalizer implements DefaultNormalizerInterface
{
    /**
     * @param User $model
     *
     * @return array<string, mixed>
     */
    public static function normalize(mixed $model): array
    {
        return [];
    }
}
