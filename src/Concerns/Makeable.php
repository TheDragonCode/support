<?php

namespace Helldar\Support\Concerns;

trait Makeable
{
    public static function make(...$parameters)
    {
        return new static(...$parameters);
    }
}
