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

use DragonCode\Support\Facades\Helpers\Is as IsHelper;
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
    public function resolve($class): ReflectionClass
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
    public function getConstants($class): array
    {
        return $this->resolve($class)->getConstants();
    }

    public function isStaticMethod($class, string $method): bool
    {
        return $this->resolve($class)->getMethod($method)->isStatic();
    }
}
