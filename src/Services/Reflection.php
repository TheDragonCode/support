<?php

namespace Helldar\Support\Services;

use Helldar\Support\Facades\Is;
use Helldar\Support\Traits\Deprecation;
use ReflectionClass;

final class Reflection
{
    use Deprecation;

    public static function resolve($class): ReflectionClass
    {
        static::deprecatedNamespace();

        return Is::reflectionClass($class) ? $class : new ReflectionClass($class);
    }
}
