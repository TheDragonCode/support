<?php

namespace Helldar\Support\Facades\Helpers\Ables;

use ArrayAccess;
use Helldar\Support\Facades\Facade;
use Helldar\Support\Helpers\Ables\Arrayable as Helper;

/**
 * @method static array get()
 * @method static Helper addUnique($values)
 * @method static Helper dump()
 * @method static Helper except(array|callable|string $keys)
 * @method static Helper filter(callable $callback, int $mode = 0)
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
 * @method static Helper set($key, $value = null)
 * @method static Helper sort(callable $callback = null)
 * @method static Helper sortByKeys(array $sorter)
 * @method static Helper toArray()
 * @method static Helper values()
 * @method static void dd()
 */
final class Arrayable extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
