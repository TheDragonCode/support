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

namespace DragonCode\Support\Facades;

use DragonCode\Support\Concerns\Resolvable;
use RuntimeException;

abstract class Facade
{
    use Resolvable;

    public static function __callStatic($method, $args)
    {
        if ($instance = self::getFacadeRoot()) {
            return $instance->{$method}(...$args);
        }

        throw new RuntimeException('A facade root has not been set.');
    }

    public static function getFacadeRoot(): object
    {
        return self::resolveInstance(static::getFacadeAccessor());
    }

    public static function clearResolvedInstances()
    {
        self::$resolved = [];
    }

    /**
     * @return object|string
     */
    protected static function getFacadeAccessor()
    {
        throw new RuntimeException('Facade does not implement getFacadeAccessor method.');
    }
}
