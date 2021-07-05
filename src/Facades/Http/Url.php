<?php

namespace Helldar\Support\Facades\Http;

use Helldar\Support\Facades\Facade;
use Helldar\Support\Helpers\Http\Url as Helper;
use Psr\Http\Message\UriInterface;

/**
 * @method static \Helldar\Support\Helpers\Http\Builder parse(string|UriInterface|null $url)
 * @method static bool exists(string|UriInterface|null $url)
 * @method static bool is(string|UriInterface|null $url)
 * @method static string validated(string|UriInterface|null $url)
 * @method static string|null default(string|UriInterface|null $url, string|UriInterface|null $default)
 * @method static void validate(string|UriInterface|null $url)
 */
class Url extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
