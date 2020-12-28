<?php

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Helpers\Instance as Helper;

/**
 * @method static bool exists(object|string $haystack)
 * @method static bool of(object|string $haystack, string|string[] $needles)
 * @method static mixed call(object|string $object, string $method, $default = null)
 * @method static mixed callOf(array $map, $value, $default = null)
 * @method static mixed callsWhenNotEmpty(object|string $object, string|string[] $methods, $default = null)
 * @method static string basename(object|string $class)
 * @method static string|null classname(object|string $class = null)
 */
final class Instance extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
