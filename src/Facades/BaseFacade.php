<?php

namespace Helldar\Support\Facades;

use RuntimeException;

abstract class BaseFacade
{
    protected static $resolved_instance = [];

    public static function __callStatic($method, $args)
    {
        if ($instance = self::getFacadeRoot()) {
            return $instance->$method(...$args);
        }

        throw new RuntimeException('A facade root has not been set.');
    }

    public static function getFacadeRoot()
    {
        return self::resolveFacadeInstance(static::getFacadeAccessor());
    }

    /**
     * Clear all of the resolved instances.
     */
    public static function clearResolvedInstances()
    {
        self::$resolved_instance = [];
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

        if (isset(self::$resolved_instance[$class])) {
            return self::$resolved_instance[$class];
        }

        return self::$resolved_instance[$class] = is_object($facade) ? $facade : new $facade();
    }
}
