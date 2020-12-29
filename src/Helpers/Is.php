<?php

namespace Helldar\Support\Helpers;

use Exception;
use Helldar\Support\Facades\Helpers\Instance;
use Helldar\Support\Facades\Helpers\Reflection;
use ReflectionClass;
use Throwable;

final class Is
{
    /**
     * Finds whether a variable is an object.
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    public function object($value): bool
    {
        return is_object($value);
    }

    /**
     * Find whether the type of a variable is string.
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    public function string($value): bool
    {
        return is_string($value);
    }

    /**
     * Find whether the type of a variable is interface.
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    public function contract($value): bool
    {
        if (is_string($value)) {
            $class = Instance::classname($value);

            return ! empty($class) && interface_exists($class);
        }

        return Reflection::resolve($value)->isInterface();
    }

    /**
     * Find whether the type of a variable is exception.
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    public function error($value): bool
    {
        return Instance::of($value, [Exception::class, Throwable::class]);
    }

    /**
     * Find whether the type of a variable is ReflectionClass.
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    public function reflectionClass($value): bool
    {
        return $value instanceof ReflectionClass;
    }
}
