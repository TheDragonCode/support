<?php

namespace Helldar\Support\Facades\Http;

use Helldar\Support\Facades\Facade;
use Helldar\Support\Helpers\Http\Url as Helper;
use Psr\Http\Message\UriInterface;

/**
 * @method static \Helldar\Support\Helpers\Http\Builder parse(UriInterface|string|null $url)
 * @method static bool exists(UriInterface|string|null $url)
 * @method static bool is(UriInterface|string|null $url)
 * @method static string validated(UriInterface|string|null $url)
 * @method static string|null default(UriInterface|string|null $url, UriInterface|string|null $default)
 * @method static void validate(UriInterface|string|null $url)
 */
class Url extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
