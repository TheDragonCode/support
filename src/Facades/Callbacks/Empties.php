<?php

namespace Helldar\Support\Facades\Callbacks;

use Helldar\Support\Callbacks\Empties as Callbacks;
use Helldar\Support\Facades\Facade;

/**
 * @method static callable notEmpty()
 * @method static callable notEmptyBoth()
 */
class Empties extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Callbacks::class;
    }
}
