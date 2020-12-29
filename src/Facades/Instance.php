<?php

namespace Helldar\Support\Facades;

use Helldar\Support\Services\Reflection;
use Helldar\Support\Traits\Deprecation;
use ReflectionClass;

/**
 * @deprecated 2.0: Namespace "Helldar\Support\Facades\Instance" is deprecated, use "Helldar\Support\Facades\Helpers\Instance" instead.
 */
final class Instance
{
    use Deprecation;

    public static function of($haystack, $needles): bool
    {
        static::deprecatedNamespace();

        if (! self::exists($haystack)) {
            return false;
        }

        $reflection = self::resolve($haystack);
        $classname  = self::classname($haystack);

        foreach (Arr::wrap($needles) as $needle) {
            if (! self::exists($needle)) {
                continue;
            }

            if (
                $haystack instanceof $needle ||
                $classname === self::classname($needle) ||
                $reflection->isSubclassOf($needle) ||
                is_subclass_of($haystack, $needle) ||
                (Is::contract($reflection) && $reflection->implementsInterface($needle))
            ) {
                return true;
            }
        }

        return false;
    }

    public static function basename($class): string
    {
        static::deprecatedNamespace();

        $class = self::classname($class);

        return basename(str_replace('\\', '/', $class));
    }

    public static function classname($class = null): ?string
    {
        static::deprecatedNamespace();

        return Is::object($class) ? get_class($class) : $class;
    }

    public static function exists($haystack): bool
    {
        static::deprecatedNamespace();

        if (Is::object($haystack)) {
            return true;
        }

        if (Is::string($haystack)) {
            return class_exists($haystack) || interface_exists($haystack);
        }

        return false;
    }

    public static function call($object, string $method, $default = null)
    {
        static::deprecatedNamespace();

        if (Is::object($object) && method_exists($object, $method)) {
            return call_user_func([$object, $method]);
        }

        return $default;
    }

    public static function callsWhenNotEmpty($object, $methods, $default = null)
    {
        static::deprecatedNamespace();
        static::deprecatedRenameMethod(__FUNCTION__, 'callWhen');

        foreach (Arr::wrap($methods) as $method) {
            if ($value = self::call($object, $method)) {
                return $value;
            }
        }

        return $default;
    }

    protected static function resolve($class): ReflectionClass
    {
        static::deprecatedNamespace();

        return Reflection::resolve($class);
    }
}
