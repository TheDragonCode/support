<?php

namespace Helldar\Support\Facades;

use RuntimeException;

abstract class BaseFacade
{
    protected static $resolved_instance = [];

    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();

        if (! $instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        return $instance->$method(...$args);
    }

    public static function getFacadeRoot()
    {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }

    /**
     * Clear all of the resolved instances.
     *
     * @return void
     */
    public static function clearResolvedInstances()
    {
        static::$resolved_instance = [];
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
        if (is_object($facade)) {
            return $facade;
        }
        if (isset(static::$resolved_instance[$facade])) {
            return static::$resolved_instance[$facade];
        }

        return static::$resolved_instance[$facade] = new $facade();
    }
}
