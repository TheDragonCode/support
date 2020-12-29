<?php

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Helpers\Is as Helper;

/**
 * @method static bool object($value)
 * @method static bool string($value)
 * @method static bool contract($value)
 * @method static bool error($value)
 * @method static bool reflectionClass($value)
 */
final class Is extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
