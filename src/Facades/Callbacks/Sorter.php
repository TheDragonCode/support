<?php

namespace Helldar\Support\Facades\Callbacks;

use Helldar\Support\Callbacks\Sorter as Callback;
use Helldar\Support\Facades\Facade;

/**
 * @method static array specialChars()
 * @method static callable default()
 */
class Sorter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Callback::class;
    }
}
