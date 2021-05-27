<?php

namespace Helldar\Support\Facades;

use Helldar\Support\Concerns\Deprecation;

/** @deprecated since 4.0: Use \Helldar\Support\Facades\Facade instead */
abstract class BaseFacade extends Facade
{
    use Deprecation;

    public static function __callStatic($method, $args)
    {
        static::deprecatedClass(Facade::class, self::class);

        return parent::__callStatic($method, $args);
    }
}
