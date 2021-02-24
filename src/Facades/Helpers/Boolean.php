<?php

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Helpers\Boolean as Helper;

/**
 * @method static bool isTrue($value)
 * @method static bool isFalse($value)
 * @method static bool to($value)
 */
final class Boolean extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
