<?php

namespace Helldar\Support\Facades\Tools;

use Helldar\Support\Facades\Facade;
use Helldar\Support\Tools\Sorter as Tool;

/**
 * @method static array specialChars()
 * @method static callable defaultCallback()
 */
final class Sorter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Tool::class;
    }
}
