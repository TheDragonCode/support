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

use DragonCode\Support\Helpers\Arr;
use DragonCode\Support\Types\Is;
use ReflectionClass;

class Instance
{
    /**
     * Checks if the item being checked inherits from other objects and interfaces.
     *
     * @param object|callable|string $haystack
     * @param string|string[] $needles
     *
     * @return bool
     */
    public static function of(mixed $haystack, mixed $needles): bool
    {
        if (! static::exists($haystack)) {
            return false;
        }

        $reflection = static::resolve($haystack);

        foreach (Arr::wrap($needles) as $needle) {
            if (! static::exists($needle)) {
                continue;
            }

            if (static::findTrait($reflection, $needle)) {
                return true;
            }

            if (is_a($haystack, $needle, true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Extract the trailing name component from a file path.
     *
     * @param object|string $class
     *
     * @return string|null
     */
    public static function basename(object|string $class): ?string
    {
        $class = static::classname($class);

        return basename(str_replace('\\', '/', (string) $class)) ?: null;
    }

    /**
     * Gets the class name of the object.
     *
     * @param object|string|null $class
     *
     * @return string|null
     */
    public static function classname(object|string $class = null): ?string
    {
        if (Is::object($class)) {
            return get_class($class);
        }

        return static::exists($class) ? $class : null;
    }

    /**
     * Checks if the object exists.
     *
     * @param object|string $haystack
     *
     * @return bool
     */
    public static function exists(mixed $haystack): bool
    {
        if (Is::object($haystack)) {
            return true;
        }

        if (! Is::string($haystack)) {
            return false;
        }

        return class_exists($haystack)
            || interface_exists($haystack)
            || trait_exists($haystack)
            || enum_exists($haystack);
    }

    /**
     * Creates a ReflectionClass object.
     *
     * @param object|string $class
     *
     * @throws \ReflectionException
     *
     * @return ReflectionClass
     */
    protected static function resolve(object|string $class): ReflectionClass
    {
        return Reflection::resolve($class);
    }

    protected static function findTrait(ReflectionClass $haystack, object|string $needle): bool
    {
        if (in_array($needle, $haystack->getTraitNames(), true)) {
            return true;
        }

        foreach ($haystack->getTraits() as $trait) {
            if (in_array($needle, $trait->getTraitNames(), true)) {
                return true;
            }

            if (static::findTrait($trait, $needle)) {
                return true;
            }
        }

        return false;
    }
}
