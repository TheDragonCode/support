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

namespace DragonCode\Support\Concerns;

trait Resolvable
{
    protected static $resolved = [];

    protected static function resolveInstance($instance, ...$parameters)
    {
        $class = is_object($instance) ? get_class($instance) : $instance;

        if (isset(self::$resolved[$class])) {
            return self::$resolved[$class];
        }

        return self::$resolved[$class] = is_object($instance) ? $instance : new $instance(...$parameters);
    }

    protected static function resolveCallback(string $value, callable $callback)
    {
        $class = static::getSameClass();

        if (isset(static::$resolved[$class][$value])) {
            return static::$resolved[$class][$value];
        }

        return static::$resolved[$class][$value] = $callback($value);
    }

    protected static function getSameClass(): string
    {
        return static::class;
    }
}
