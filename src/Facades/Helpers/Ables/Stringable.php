<?php

namespace Helldar\Support\Facades\Helpers\Ables;

use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Helpers\Ables\Stringable as Helper;

/**
 * @method static Helper after(string $search)
 * @method static Helper ascii(string $language = 'en')
 * @method static Helper before(string $search)
 * @method static Helper camel()
 * @method static Helper finish(string $cap = '/')
 * @method static Helper lower()
 * @method static Helper of(?string $value)
 * @method static Helper pregReplace(string $pattern, string $replacement)
 * @method static Helper removeSpaces()
 * @method static Helper replace(array $values, string $key_format = null)
 * @method static Helper slug(string $separator = '-', ?string $language = 'en')
 * @method static Helper snake(string $delimiter = '_')
 * @method static Helper start(string $prefix)
 * @method static Helper studly()
 * @method static Helper substr(int $start, int $length = null)
 * @method static Helper title()
 * @method static Helper trim(string $characters = " \t\n\r\0\x0B")
 * @method static Helper upper()
 */
final class Stringable extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
