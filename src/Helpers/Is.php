<?php

namespace Helldar\Support\Helpers;

use Exception;
use Helldar\Support\Facades\Helpers\Arr as ArrHelper;
use Helldar\Support\Facades\Helpers\Boolean as BooleanHelper;
use Helldar\Support\Facades\Helpers\Instance as InstanceHelper;
use Helldar\Support\Facades\Helpers\Reflection as ReflectionHelper;
use Helldar\Support\Facades\Helpers\Str as StrHelper;
use ReflectionClass;
use Throwable;

final class Is
{
    /**
     * Determines if the value is empty.
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    public function isEmpty($value): bool
    {
        if (is_numeric($value) || is_bool($value)) {
            return false;
        }

        return empty($value) || StrHelper::isEmpty($value) || ArrHelper::isEmpty($value);
    }

    /**
     * Determines if the value is doesn't empty.
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    public function doesntEmpty($value): bool
    {
        return ! $this->isEmpty($value);
    }

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
     * Determines if a value is boolean.
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    public function boolean($value): bool
    {
        $result = BooleanHelper::parse($value);

        return is_bool($result);
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
            $class = InstanceHelper::classname($value);

            return ! empty($class) && interface_exists($class);
        }

        return ReflectionHelper::resolve($value)->isInterface();
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
        return InstanceHelper::of($value, [Exception::class, Throwable::class]);
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
