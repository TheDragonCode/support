<?php

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Helpers\Boolean as Helper;

/**
 * @method static bool isFalse($value)
 * @method static bool isTrue($value)
 * @method static bool to($value)
 * @method static bool|null parse($value)
 * @method static string convertToString(bool $value)
 */
final class Boolean extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
