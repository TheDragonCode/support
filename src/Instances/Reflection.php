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

namespace DragonCode\Support\Instances;

use DragonCode\Support\Types\Is as IsHelper;
use ReflectionClass;
use ReflectionException;

class Reflection
{
    /**
     * Creates a ReflectionClass object.
     *
     * @param object|ReflectionClass|string $class
     *
     * @throws ReflectionException
     *
     * @return ReflectionClass
     */
    public static function resolve(object|string $class): ReflectionClass
    {
        return IsHelper::reflectionClass($class) ? $class : new ReflectionClass($class);
    }

    /**
     * Gets class constants.
     *
     * @param object|string $class
     *
     * @throws ReflectionException
     *
     * @return array
     */
    public static function getConstants(object|string $class): array
    {
        return static::resolve($class)->getConstants();
    }

    public static function isStaticMethod(object|string $class, string $method): bool
    {
        return static::resolve($class)->getMethod($method)->isStatic();
    }

    public static function isPublicMethod(object|string $class, string $method): bool
    {
        return static::resolve($class)->getMethod($method)->isPublic();
    }

    public static function isProtectedMethod(object|string $class, string $method): bool
    {
        return static::resolve($class)->getMethod($method)->isProtected();
    }

    public static function isPrivateMethod(object|string $class, string $method): bool
    {
        return static::resolve($class)->getMethod($method)->isPrivate();
    }
}
