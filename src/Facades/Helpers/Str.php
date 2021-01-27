<?php

namespace Helldar\Support\Facades\Helpers;

use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Helpers\Str as Helper;

/**
 * @method static bool endsWith(string $haystack, string|string[] $needles)
 * @method static bool startsWith(string $haystack, string|string[] $needles)
 * @method static int length(?string $value, string $encoding = null)
 * @method static string camel(?string $value)
 * @method static string choice(float $number, array $choice = [], string $extra = null)
 * @method static string finish(string $value, string $cap = '/')
 * @method static string lower(?string $value)
 * @method static string snake(?string $value, string $delimiter = '_')
 * @method static string start(?string $value, string $prefix)
 * @method static string studly(?string $value)
 * @method static string|null after(string $subject, string $search)
 * @method static string|null before(string $subject, string $search)
 * @method static string|null de(?string $value)
 * @method static string|null e(?string $value, bool $double = true)
 * @method static string|null removeSpaces(?string $value)
 * @method static string|null substr(string $string, int $start, int $length = null)
 * @method static string|null upper(?string $value)
 */
final class Str extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
