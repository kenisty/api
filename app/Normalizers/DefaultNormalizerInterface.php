<?php declare(strict_types=1);

namespace App\Normalizers;

/**
 * @template T
 */
interface DefaultNormalizerInterface
{
    /**
     * @return array<string, mixed>
     */
    public static function normalize(mixed $model): array;
}
