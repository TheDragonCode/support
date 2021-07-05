<?php

namespace Helldar\Support\Facades\Helpers\Http;

use Helldar\Support\Facades\Facade;
use Helldar\Support\Helpers\Http\Uri as Helper;
use Psr\Http\Message\UriInterface;

/**
 * @method static bool exists(string|UriInterface|null $url)
 * @method static bool isUrl(string|UriInterface|null $url)
 * @method static string domain(string|UriInterface|null $url)
 * @method static string host(string|UriInterface|null $url)
 * @method static string scheme(string|UriInterface|null $url)
 * @method static string validatedUrl(string|UriInterface|null $url)
 * @method static string|null image(string|UriInterface|null $url, string $default = null)
 * @method static string|null subdomain(string|UriInterface|null $url)
 * @method static void validateUrl(string|UriInterface|null $url)
 */
class Uri extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
