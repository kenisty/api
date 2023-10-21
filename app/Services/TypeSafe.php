<?php declare(strict_types=1);

namespace App\Services;

class TypeSafe
{
    public static function getInt(mixed $value): ?int
    {
        if (!is_int($value)) {
            return null;
        }

        return $value;
    }

    public static function getString(mixed $value): ?string
    {
        if (!is_string($value)) {
            return null;
        }

        return $value;
    }
}
