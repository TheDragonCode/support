<?php
/******************************************************************************
 * This file is part of the "andrey-helldar/support" project.                 *
 *                                                                            *
 * @author Andrey Helldar <helldar@ai-rus.com>                                *
 *                                                                            *
 * @copyright 2021 Andrey Helldar                                             *
 *                                                                            *
 * @license MIT                                                               *
 *                                                                            *
 * @see https://github.com/andrey-helldar/support                             *
 *                                                                            *
 * For the full copyright and license information, please view the LICENSE    *
 * file that was distributed with this source code.                           *
 ******************************************************************************/

namespace Helldar\Support\Facades;

use RuntimeException;

abstract class Facade
{
    protected static $resolved = [];

    public static function __callStatic($method, $args)
    {
        if ($instance = self::getFacadeRoot()) {
            return $instance->$method(...$args);
        }

        throw new RuntimeException('A facade root has not been set.');
    }

    public static function getFacadeRoot(): object
    {
        return self::resolveFacadeInstance(static::getFacadeAccessor());
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

    /**
     * @param  object|string  $facade
     *
     * @return object
     */
    protected static function resolveFacadeInstance($facade): object
    {
        $class = is_object($facade) ? get_class($facade) : $facade;

        if (isset(self::$resolved[$class])) {
            return self::$resolved[$class];
        }

        return self::$resolved[$class] = is_object($facade) ? $facade : new $facade();
    }
}
