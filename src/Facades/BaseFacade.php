<?php

namespace Helldar\Support\Facades;

use RuntimeException;

abstract class BaseFacade
{
    protected static $resolvedInstance = [];

    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();

        if (! $instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        return $instance->$method(...$args);
    }

    protected static function getFacadeRoot()
    {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
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
        if (isset(static::$resolvedInstance[$facade])) {
            return static::$resolvedInstance[$facade];
        }

        return static::$resolvedInstance[$facade] = new $facade();
    }
}
