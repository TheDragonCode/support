<?php

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\Facade;
use Helldar\Support\Helpers\HttpBuilder as Helper;
use Psr\Http\Message\UriInterface;

/**
 * @method static array toArray()
 * @method static Helper fromUriInterface(UriInterface $uri)
 * @method static Helper parse(?string $url, int $component = -1)
 * @method static Helper putQuery(string $key, $value)
 * @method static Helper raw(array $parsed)
 * @method static Helper removeQuery(string $key)
 * @method static Helper same()
 * @method static Helper setFragment(array|string $value)
 * @method static Helper setHost(string $value)
 * @method static Helper setPass(string $value)
 * @method static Helper setPath(string $value)
 * @method static Helper setPort(string $value)
 * @method static Helper setQuery(array|string $value)
 * @method static Helper setScheme(string $value)
 * @method static Helper setUser(string $value)
 * @method static Helper toUriInterface(): UriInterface
 * @method static string compile()
 * @method static string|null getFragment()
 * @method static string|null getHost()
 * @method static string|null getPass()
 * @method static string|null getPath()
 * @method static string|null getPort()
 * @method static string|null getQuery()
 * @method static string|null getScheme()
 * @method static string|null getUser()
 *
 * @deprecated since 4.0: Namespace will be renamed to `Helldar\Support\Facades\Helpers\Http\Builder`.
 * @deprecated since 4.0: The `set` methods will be renamed to `with` for the `Psr\Http\Message\UriInterface` compatibility.
 */
final class HttpBuilder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
