<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace DragonCode\Support\Types;

use DragonCode\Support\Facades\Helpers\Arr as ArrHelper;
use DragonCode\Support\Facades\Helpers\Boolean as BooleanHelper;
use DragonCode\Support\Facades\Helpers\Str as StrHelper;
use DragonCode\Support\Facades\Instances\Instance as InstanceHelper;
use DragonCode\Support\Facades\Instances\Reflection as ReflectionHelper;
use Exception;
use ReflectionClass;
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
    public function isEmpty(mixed $value): bool
    {
        if (is_numeric($value) || is_bool($value)) {
            return false;
        }

        return empty($value) || StrHelper::isEmpty($value) || ArrHelper::isEmpty($value);
    }

    /**
     * Determines if the value is doesn't empty.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function doesntEmpty(mixed $value): bool
    {
        return ! $this->isEmpty($value);
    }

    /**
     * Finds whether a variable is an object.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function object(mixed $value): bool
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
    public function string(mixed $value): bool
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
    public function boolean(mixed $value): bool
    {
        $result = BooleanHelper::parse($value);

        return is_bool($result);
    }

    /**
     * Find whether the type of a variable is interface.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function contract(mixed $value): bool
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
     * @param mixed $value
     *
     * @return bool
     */
    public function error(mixed $value): bool
    {
        return InstanceHelper::of($value, [Exception::class, Throwable::class]);
    }

    /**
     * Find whether the type of a variable is ReflectionClass.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function reflectionClass(mixed $value): bool
    {
        return $value instanceof ReflectionClass;
    }
}
