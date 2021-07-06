<?php

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\Facade;
use Helldar\Support\Helpers\Boolean as Helper;

/**
 * @method static bool isFalse($value)
 * @method static bool isTrue($value)
 * @method static bool to($value)
 * @method static bool|null parse($value)
 * @method static string convertToString(bool $value)
 */
class Boolean extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
