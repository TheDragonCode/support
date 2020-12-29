<?php

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Helpers\HttpBuilder as Helper;

/**
 * @method static Helper parse(string $url, int $component = -1)
 * @method static Helper raw(array $parsed)
 * @method static Helper same()
 * @method static Helper setFragment(array|string $value)
 * @method static Helper setHost(string $value)
 * @method static Helper setPass(string $value)
 * @method static Helper setPath(string $value)
 * @method static Helper setPort(string $value)
 * @method static Helper setQuery(array|string $value)
 * @method static Helper setScheme(string $value)
 * @method static Helper setUser(string $value)
 * @method static string compile()
 * @method static string|null getFragment()
 * @method static string|null getHost()
 * @method static string|null getPass()
 * @method static string|null getPath()
 * @method static string|null getPort()
 * @method static string|null getQuery()
 * @method static string|null getScheme()
 * @method static string|null getUser()
 */
final class HttpBuilder extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
