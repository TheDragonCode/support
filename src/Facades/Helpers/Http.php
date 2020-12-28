<?php

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Helpers\Http as Helper;

/**
 * @method static bool exists(string $url)
 * @method static bool isUrl(string $url = null)
 * @method static string|null domain(string $url = null, string $default = null)
 * @method static string|null host(string $url = null)
 * @method static string|null image(string $url = null, string $default = null)
 * @method static string|null scheme(string $url = null)
 * @method static string|null subdomain(string $url = null, string $default = null)
 * @method static void validateUrl(string $url = null)
 */
final class Http extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
