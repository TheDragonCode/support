<?php

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Helpers\OS as Helper;

/**
 * @method static bool isBSD()
 * @method static bool isDarwin()
 * @method static bool isLinux()
 * @method static bool isSolaris()
 * @method static bool isUnix()
 * @method static bool isUnknown()
 * @method static bool isWindows()
 * @method static string family(bool $lower = true)
 */
final class OS extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
