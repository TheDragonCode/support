<?php

namespace Helldar\Support\Helpers;

use Helldar\Support\Facades\Helpers\Arr;
use Helldar\Support\Facades\Helpers\Is;
use Helldar\Support\Facades\Helpers\Reflection;
use ReflectionClass;

final class Instance
{
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

        foreach (Arr::wrap($needles) as $needle) {
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
        if (Is::object($class)) {
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
        if (Is::object($haystack)) {
            return true;
        }

        if (Is::string($haystack)) {
            return class_exists($haystack) || interface_exists($haystack);
        }

        return false;
    }

    /**
     * Calls a method on an object.
     *
     * @param  object  $object
     * @param  string  $method
     * @param  null  $default
     *
     * @return false|mixed|null
     */
    public function call($object, string $method, $default = null)
    {
        if (Is::object($object) && method_exists($object, $method)) {
            return call_user_func([$object, $method]);
        }

        return $default;
    }

    /**
     * Calls the object's methods one by one and returns the first non-empty value.
     *
     * @param  object  $object
     * @param  string|string[]  $methods
     * @param  null  $default
     *
     * @return false|mixed|null
     */
    public function callWhen($object, $methods, $default = null)
    {
        foreach (Arr::wrap($methods) as $method) {
            if ($value = $this->call($object, $method)) {
                return $value;
            }
        }

        return $default;
    }

    /**
     * Calls a method of an object that matches a class.
     *
     * @param  array  $map
     * @param  object  $value
     * @param  null  $default
     *
     * @return false|mixed|null
     */
    public function callOf(array $map, $value, $default = null)
    {
        foreach ($map as $class => $method) {
            if (Is::object($value) && $this->of($value, $class)) {
                return $this->call($value, $method, $default);
            }
        }

        return $default;
    }

    /**
     * Creates a ReflectionClass object.
     *
     * @param  ReflectionClass|object  $class
     *
     * @return \ReflectionClass
     */
    protected function resolve($class): ReflectionClass
    {
        return Reflection::resolve($class);
    }
}
