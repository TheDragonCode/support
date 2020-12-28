<?php

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Helpers\HttpBuilder as Helper;

/**
 * @method static Helper parse(string $url, int $component = -1)
 * @method static Helper same()
 * @method static string compile()
 * @method static string|null getFragment()
 * @method static string|null getHost()
 * @method static string|null getPassword()
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
