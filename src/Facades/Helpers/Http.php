<?php

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Helpers\Http as Helper;

/**
 * @method static bool exists(?string $url)
 * @method static bool isUrl(?string $url)
 * @method static string domain(?string $url)
 * @method static string host(?string $url)
 * @method static string scheme(?string $url)
 * @method static string validatedUrl(?string $url)
 * @method static string|null image(string $url, string $default = null)
 * @method static string|null subdomain(?string $url)
 * @method static void validateUrl(?string $url)
 */
final class Http extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
