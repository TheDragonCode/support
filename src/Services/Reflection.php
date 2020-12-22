<?php

namespace Helldar\Support\Services;

use Helldar\Support\Facades\Is;
use ReflectionClass;

final class Reflection
{
    public static function resolve($class): ReflectionClass
    {
        return Is::reflectionClass($class) ? $class : new ReflectionClass($class);
    }
}
