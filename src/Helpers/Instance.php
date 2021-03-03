<?php

namespace Helldar\Support\Helpers;

use Helldar\Support\Concerns\Deprecation;
use Helldar\Support\Facades\Helpers\Arr as ArrHelper;
use Helldar\Support\Facades\Helpers\Call as CallHelper;
use Helldar\Support\Facades\Helpers\Is as IsHelper;
use Helldar\Support\Facades\Helpers\Reflection as ReflectionHelper;
use ReflectionClass;

final class Instance
{
    use Deprecation;

    /**
     * Checks if the item being checked inherits from other objects and interfaces.
     *
     * @param  object|string  $haystack
     * @param  string|string[]  $needles
     *
     * @return bool
     */
    public function of($haystack, $needles): bool
    {
        if (! $this->exists($haystack)) {
            return false;
        }

        $reflection = $this->resolve($haystack);
        $classname  = $this->classname($haystack);

        foreach (ArrHelper::wrap($needles) as $needle) {
            if (! $this->exists($needle)) {
                continue;
            }

            if (
                $haystack instanceof $needle ||
                $classname === $this->classname($needle) ||
                $reflection->isSubclassOf($needle) ||
                ($reflection->isInterface() && $reflection->implementsInterface($needle))
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Extract the trailing name component from a file path.
     *
     * @param  object|string  $class
     *
     * @return string|null
     */
    public function basename($class): ?string
    {
        $class = $this->classname($class);

        return basename(str_replace('\\', '/', $class)) ?: null;
    }

    /**
     * Gets the class name of the object.
     *
     * @param  object|string|null  $class
     *
     * @return string|null
     */
    public function classname($class = null): ?string
    {
        if (IsHelper::object($class)) {
            return get_class($class);
        }

        return class_exists($class) || interface_exists($class) ? $class : null;
    }

    /**
     * Checks if the object exists.
     *
     * @param  object|string  $haystack
     *
     * @return bool
     */
    public function exists($haystack): bool
    {
        if (IsHelper::object($haystack)) {
            return true;
        }

        return IsHelper::string($haystack) ? class_exists($haystack) || interface_exists($haystack) : false;
    }

    /**
     * Calls a method on an object.
     *
     * @deprecated The method is deprecated and will be removed in version 3.0. Use "Helldar\Support\Facades\Helpers\Call::runExists()" instead.
     *
     * @param  object|string  $object
     * @param  string  $method
     * @param  null  $default
     *
     * @return false|mixed|null
     */
    public function call($object, string $method, $default = null)
    {
        self::deprecatedMethod(__FUNCTION__, CallHelper::class, 'runExists');

        return CallHelper::runExists($object, $method) ?: $default;
    }

    /**
     * Calls the object's methods one by one and returns the first non-empty value.
     *
     * @deprecated The method is deprecated and will be removed in version 3.0. Use "Helldar\Support\Facades\Helpers\Call::runMethods()" instead.
     *
     * @param  object  $object
     * @param  string|string[]  $methods
     * @param  null  $default
     *
     * @return false|mixed|null
     */
    public function callWhen($object, $methods, $default = null)
    {
        self::deprecatedMethod(__FUNCTION__, CallHelper::class, 'runMethods');

        return CallHelper::runMethods($object, $methods) ?: $default;
    }

    /**
     * Calls a method of an object that matches a class.
     *
     * @deprecated The method is deprecated and will be removed in version 3.0. Use "Helldar\Support\Facades\Helpers\Call::runOf()" instead.
     *
     * @param  array  $map
     * @param  object  $value
     * @param  null  $default
     *
     * @return false|mixed|null
     */
    public function callOf(array $map, $value, $default = null)
    {
        self::deprecatedMethod(__FUNCTION__, CallHelper::class, 'runOf');

        return CallHelper::runOf($map, $value) ?: $default;
    }

    /**
     * Creates a ReflectionClass object.
     *
     * @param  object|ReflectionClass|string  $class
     *
     * @return \ReflectionClass
     */
    protected function resolve($class): ReflectionClass
    {
        return ReflectionHelper::resolve($class);
    }
}
