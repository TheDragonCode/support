<?php

namespace Helldar\Support\Facades\Helpers;

use ArrayAccess;
use Helldar\Support\Facades\BaseFacade;
use Helldar\Support\Helpers\Arr as Helper;

/**
 * @method static array addUnique(array $array, $values)
 * @method static array except(array $array, array|callable|string $keys)
 * @method static array ksort(array $array, callable $callback = null)
 * @method static array map(array|ArrayAccess $array, callable $callback, bool $recursive = false)
 * @method static array merge(...$arrays)
 * @method static array only(array|ArrayAccess $array, array|callable|string $keys)
 * @method static array renameKeys(array $array, callable $callback)
 * @method static array renameKeysMap(array $array, array $map)
 * @method static array sort(array $array, callable $callback = null)
 * @method static array sortByKeys(array $array, array $sorter)
 * @method static array toArray($value = null)
 * @method static array wrap($value = null)
 * @method static bool doesntEmpty($value)
 * @method static bool exists(array|ArrayAccess $array, $key)
 * @method static bool isArrayable($value = null)
 * @method static bool isEmpty($value)
 * @method static int longestStringLength(array $array)
 * @method static mixed get(array|ArrayAccess $array, $key, $default = null)
 * @method static mixed getKey(array|ArrayAccess $array, $key, $default = null)
 * @method static void store(array|ArrayAccess $array, string $path, bool $is_json = false, bool $sort_keys = false, int $json_flags = 0)
 * @method static void storeAsArray(string $path, array|ArrayAccess $array, bool $sort_keys = false)
 * @method static void storeAsJson(string $path, array|ArrayAccess $array, bool $sort_keys = false, int $flags = 0)
 */
final class Arr extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return Helper::class;
    }
}
