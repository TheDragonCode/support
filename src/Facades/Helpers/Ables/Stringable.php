<?php
/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace DragonCode\Support\Facades\Helpers\Ables;

use DragonCode\Support\Concerns\Deprecation;
use DragonCode\Support\Facades\Facade;
use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Helpers\Ables\Stringable as Helper;

/**
 * @method static Helper after(string $search)
 * @method static Helper ascii(string $language = 'en')
 * @method static Helper before(string $search)
 * @method static Helper camel()
 * @method static Helper dump()
 * @method static Helper end(string $suffix)
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
 * @method static void dd()
 */
class Stringable extends Facade
{
    use Deprecation;

    public static function __callStatic($method, $args)
    {
        static::deprecatedClass(Str::class);

        return parent::__callStatic($method, $args);
    }

    protected static function getFacadeAccessor(): string
    {
        return Helper::class;
    }
}
