<?php

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Helpers\Stringable as Helper;

/**
 * @method static Helper of(?string $value)
 * @method static string ascii(string $language = 'en')
 * @method static string replace(array $values, string $key_format = null)
 * @method static string slug(string $separator = '-', ?string $language = 'en')
 * @method static string|null after(string $search)
 * @method static string|null before(string $search)
 * @method static string|null camel()
 * @method static string|null finish(string $cap = '/')
 * @method static string|null lower()
 * @method static string|null removeSpaces()
 * @method static string|null snake(string $delimiter = '_')
 * @method static string|null start(string $prefix)
 * @method static string|null studly()
 * @method static string|null substr(int $start, int $length = null)
 * @method static string|null title()
 * @method static string|null upper()
 */
class Stringable extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
