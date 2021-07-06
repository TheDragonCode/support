<?php

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\Facade;
use Helldar\Support\Helpers\Is as Helper;

/**
 * @method static bool boolean($value)
 * @method static bool contract($value)
 * @method static bool doesntEmpty($value)
 * @method static bool error($value)
 * @method static bool isEmpty($value)
 * @method static bool object($value)
 * @method static bool reflectionClass($value)
 * @method static bool string($value)
 */
class Is extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
