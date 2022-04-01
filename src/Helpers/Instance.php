<?php
/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace DragonCode\Support\Helpers;

use DragonCode\Support\Facades\Helpers\Arr as ArrHelper;
use DragonCode\Support\Facades\Helpers\Is as IsHelper;
use DragonCode\Support\Facades\Helpers\Reflection as ReflectionHelper;
use ReflectionClass;

class Instance
{
    /**
     * Checks if the item being checked inherits from other objects and interfaces.
     *
     * @param object|string $haystack
     * @param string|string[] $needles
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

            $needle_reflection = $this->resolve($needle);

            if ($haystack === $needle) {
                return true;
            }

            if ($haystack instanceof $needle) {
                return true;
            }

            if (! is_null($classname) && $classname === $this->classname($needle)) {
                return true;
            }

            if ($reflection->isSubclassOf($needle)) {
                return true;
            }

            if ($reflection->isInterface() && $needle_reflection->isInterface() && $reflection->implementsInterface($needle)) {
                return true;
            }

            if (in_array($needle, $reflection->getTraitNames(), true)) {
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
    public function basename($class): ?string
    {
        $class = $this->classname($class);

        return basename(str_replace('\\', '/', (string) $class)) ?: null;
    }

    /**
     * Gets the class name of the object.
     *
     * @param object|string|null $class
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
     * @param object|string $haystack
     *
     * @return bool
     */
    public function exists($haystack): bool
    {
        if (IsHelper::object($haystack)) {
            return true;
        }

        return IsHelper::string($haystack) && (class_exists($haystack) || interface_exists($haystack) || trait_exists($haystack));
    }

    /**
     * Creates a ReflectionClass object.
     *
     * @param object|ReflectionClass|string $class
     *
     * @return ReflectionClass
     */
    protected function resolve($class): ReflectionClass
    {
        return ReflectionHelper::resolve($class);
    }
}
