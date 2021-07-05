<?php

namespace Helldar\Support\Facades\Tools;

use Helldar\Support\Facades\Facade;
use Helldar\Support\Tools\Replace as Tool;

/**
 * @method static string toFormat(string $value, string $format = null)
 * @method static string toFormatArray(array $values, string $format = null)
 */
class Replace extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Tool::class;
    }
}
