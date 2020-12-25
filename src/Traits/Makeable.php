<?php

namespace Helldar\Support\Traits;

trait Makeable
{
    public static function make(...$parameters)
    {
        return new static(...$parameters);
    }

    public static function init(...$parameters)
    {
        return static::make(...$parameters);
    }
}
