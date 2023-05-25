<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2023 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace DragonCode\Support\Types;

use DragonCode\Support\Helpers\Arr;
use DragonCode\Support\Helpers\Boolean;
use DragonCode\Support\Helpers\Str;
use DragonCode\Support\Instances\Instance;
use Exception;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use Throwable;

class Is
{
    /**
     * Determines if the value is empty.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function isEmpty(mixed $value): bool
    {
        if (is_numeric($value) || is_bool($value)) {
            return false;
        }

        return empty($value) || Str::isEmpty($value) || Arr::isEmpty($value);
    }

    /**
     * Determines if the value is doesn't empty.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function doesntEmpty(mixed $value): bool
    {
        return ! static::isEmpty($value);
    }

    /**
     * Finds whether a variable is an object.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function object(mixed $value): bool
    {
        return is_object($value);
    }

    /**
     * Find whether the type of a variable is string.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function string(mixed $value): bool
    {
        return is_string($value);
    }

    /**
     * Determines if a value is boolean.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function boolean(mixed $value): bool
    {
        $result = Boolean::parse($value);

        return is_bool($result);
    }

    /**
     * Find whether the type of a variable is interface.
     *
     * @param mixed $value
     *
     * @throws \ReflectionException
     *
     * @return bool
     */
    public static function contract(mixed $value): bool
    {
        return ! empty($value) && interface_exists($value);
    }

    /**
     * Find whether the type of a variable is enum.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function enum(mixed $value): bool
    {
        return ! empty($value) && enum_exists($value);
    }

    /**
     * Find whether the type of a variable is trait.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function trait(mixed $value): bool
    {
        return ! empty($class) && trait_exists($value);
    }

    /**
     * Find whether the type of a variable is exception.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function exception(mixed $value): bool
    {
        return Instance::of($value, [Exception::class, Throwable::class]);
    }

    /**
     * Find whether the type of a variable is ReflectionClass.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function reflectionClass(mixed $value): bool
    {
        return $value instanceof ReflectionClass;
    }

    /**
     * Find whether the type of a variable is ReflectionMethod.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function reflectionMethod(mixed $value): bool
    {
        return $value instanceof ReflectionMethod;
    }

    /**
     * Find whether the type of a variable is ReflectionAttribute.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function reflectionAttribute(mixed $value): bool
    {
        return $value instanceof ReflectionAttribute;
    }

    /**
     * Find whether the type of a variable is ReflectionProperty.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function reflectionProperty(mixed $value): bool
    {
        return $value instanceof ReflectionProperty;
    }
}
