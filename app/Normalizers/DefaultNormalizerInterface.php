<?php declare(strict_types=1);

namespace App\Normalizers;

use App\DTOs\DefaultDtoInterface;

/**
 * @template T
 */
interface DefaultNormalizerInterface
{
    /**
     * @param T $model
     */
    public static function normalize(mixed $model): DefaultDtoInterface;
}
