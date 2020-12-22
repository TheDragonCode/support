<?php

namespace Helldar\Support\Traits;

final class Makeable
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
