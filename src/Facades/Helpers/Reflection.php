<?php

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\Facade;
use Helldar\Support\Helpers\Reflection as Helper;
use ReflectionClass;

/**
 * @method static ReflectionClass resolve(object|ReflectionClass|string $class)
 */
final class Reflection extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
