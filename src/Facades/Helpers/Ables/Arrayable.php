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

use ArrayAccess;
use DragonCode\Support\Concerns\Deprecation;
use DragonCode\Support\Facades\Facade;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Helpers\Ables\Arrayable as Helper;

/**
 * @method static array get()
 * @method static Helper addUnique($values)
 * @method static Helper combine(...$arrays)
 * @method static Helper dump()
 * @method static Helper except(array|callable|string $keys)
 * @method static Helper filter(callable $callback = null, int $mode = 0)
 * @method static Helper flatten(bool $ignore_keys = true)
 * @method static Helper flip()
 * @method static Helper keys()
 * @method static Helper ksort(callable $callback = null)
 * @method static Helper map(callable $callback, bool $recursive = false)
 * @method static Helper merge(...$arrays)
 * @method static Helper of(array|ArrayAccess|object|string|null $value = [])
 * @method static Helper only(array|callable|string $keys)
 * @method static Helper push(...$values)
 * @method static Helper remove($key)
 * @method static Helper renameKeys(callable $callback)
 * @method static Helper renameKeysMap(array $map)
 * @method static Helper reverse(bool $preserve_keys = false)
 * @method static Helper set($key, $value = null)
 * @method static Helper sort(callable $callback = null)
 * @method static Helper sortByKeys(array $sorter)
 * @method static Helper tap(callable $callback)
 * @method static Helper toArray()
 * @method static Helper unique(int $flags = SORT_STRING)
 * @method static Helper values()
 * @method static void dd()
 */
class Arrayable extends Facade
{
    use Deprecation;

    public static function __callStatic($method, $args)
    {
        static::deprecatedClass(Arr::class);

        return parent::__callStatic($method, $args);
    }

    protected static function getFacadeAccessor(): string
    {
        return Helper::class;
    }
}
