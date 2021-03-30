<?php

namespace Helldar\Support\Facades\Tools;

use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Tools\Replace as Tool;

/**
 * @method static string toFormat(string $value, string $format = null)
 * @method static string toFormatArray(array $values, string $format = null)
 */
final class Replace extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Tool::class;
    }
}
