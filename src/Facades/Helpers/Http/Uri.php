<?php

namespace Helldar\Support\Facades\Helpers\Http;

use Helldar\Support\Facades\Facade;
use Helldar\Support\Helpers\Http\Uri as Helper;
use Psr\Http\Message\UriInterface;

/**
 * @method static bool exists(UriInterface|string|null $url)
 * @method static bool isUrl(UriInterface|string|null $url)
 * @method static string domain(UriInterface|string|null $url)
 * @method static string host(UriInterface|string|null $url)
 * @method static string scheme(UriInterface|string|null $url)
 * @method static string validatedUrl(UriInterface|string|null $url)
 * @method static string|null image(UriInterface|string|null $url, string $default = null)
 * @method static string|null subdomain(UriInterface|string|null $url)
 * @method static void validateUrl(UriInterface|string|null $url)
 */
class Uri extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
