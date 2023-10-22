<?php declare(strict_types=1);

namespace App\Services;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;

class AttributeReader
{
    /**
     * @param class-string $classname
     * @throws ReflectionException
     * @return array<ReflectionAttribute<object>>
     */
    public static function readAttributes(string $classname): array
    {
        $classReflection = new ReflectionClass($classname);

        return $classReflection->getAttributes();
    }
}
