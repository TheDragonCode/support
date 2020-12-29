<?php

namespace Helldar\Support\Facades;

use Exception;
use Helldar\Support\Services\Reflection;
use Helldar\Support\Traits\Deprecation;
use ReflectionClass;
use Throwable;

/**
 * @deprecated 2.0: Namespace "Helldar\Support\Facades\Is" is deprecated, use "Helldar\Support\Facades\Helpers\Is" instead.
 */
final class Is
{
    use Deprecation;

    public static function object($value): bool
    {
        static::deprecatedNamespace();

        return is_object($value);
    }

    public static function string($value): bool
    {
        static::deprecatedNamespace();

        return is_string($value);
    }

    public static function contract($value): bool
    {
        static::deprecatedNamespace();

        $class = Instance::classname($value);

        return Reflection::resolve($value)->isInterface() || interface_exists($class);
    }

    public static function error($value): bool
    {
        static::deprecatedNamespace();

        return Instance::of($value, [Exception::class, Throwable::class]);
    }

    public static function reflectionClass($class): bool
    {
        static::deprecatedNamespace();

        return $class instanceof ReflectionClass;
    }
}
