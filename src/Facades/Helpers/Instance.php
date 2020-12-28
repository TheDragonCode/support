<?php

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Helpers\Instance as Helper;

/**
 * @method static bool exists(string|object $haystack)
 * @method static bool of(string|object $haystack, string|string[] $needles)
 * @method static mixed call(string|object $object, string $method, $default = null)
 * @method static mixed callOf(array $map, $value, $default = null)
 * @method static mixed callsWhenNotEmpty(string|object $object, string|string[] $methods, $default = null)
 * @method static string basename(string|object $class)
 * @method static string|null classname(string|object $class = null)
 */
final class Instance extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
