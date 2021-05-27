<?php

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\Facade;
use Helldar\Support\Helpers\Instance as Helper;

/**
 * @method static bool exists(object|string $haystack)
 * @method static bool of(object|string $haystack, string|string[] $needles)
 * @method static string|null basename(object|string $class)
 * @method static string|null classname(object|string $class = null)
 */
final class Instance extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
