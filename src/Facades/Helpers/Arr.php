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

namespace DragonCode\Support\Facades\Helpers;

use ArrayAccess;
use DragonCode\Support\Facades\Facade;
use DragonCode\Support\Helpers\Arr as Helper;

/**
 * @method static array addUnique(array $array, $values)
 * @method static array combine(...$arrays)
 * @method static array except(array $array, array|callable|string $keys)
 * @method static array filter($array, callable $callback = null, int $mode = 0)
 * @method static array flatten(array $array, bool $ignore_keys = true)
 * @method static array flattenKeys($array, string $delimiter = '.')
 * @method static array flip($array)
 * @method static array keys($array)
 * @method static array ksort(array $array, callable $callback = null)
 * @method static array map(array|ArrayAccess $array, callable $callback, bool $recursive = false)
 * @method static array merge(...$arrays)
 * @method static array only(array|ArrayAccess $array, array|callable|string $keys)
 * @method static array push(array|ArrayAccess $array, mixed ...$values)
 * @method static array remove(array|ArrayAccess $array, mixed $key)
 * @method static array renameKeys(array $array, callable $callback)
 * @method static array renameKeysMap(array $array, array $map)
 * @method static array reverse(array $array, bool $preserve_keys = false)
 * @method static array set(array|ArrayAccess $array, array|mixed $key, mixed $value = null)
 * @method static array sort(array $array, callable $callback = null)
 * @method static array sortByKeys(array $array, array $sorter)
 * @method static array tap(array|ArrayAccess $array, callable $callback)
 * @method static array toArray($value = null)
 * @method static array unique(array $array, int $flags = SORT_STRING)
 * @method static array values($array)
 * @method static array wrap($value = null)
 * @method static bool doesntEmpty($value)
 * @method static bool exists(array|ArrayAccess $array, $key)
 * @method static bool existsWithoutDot(array|ArrayAccess $array, $key)
 * @method static bool isArrayable($value = null)
 * @method static bool isEmpty($value)
 * @method static int longestStringLength(array $array)
 * @method static mixed get(array|ArrayAccess $array, $key, $default = null)
 * @method static mixed getKey(array|ArrayAccess $array, $key, $default = null)
 * @method static void store(array|ArrayAccess $array, string $path, bool $is_json = false, bool $sort_keys = false, int $json_flags = 0)
 * @method static void storeAsArray(string $path, array|ArrayAccess $array, bool $sort_keys = false)
 * @method static void storeAsJson(string $path, array|ArrayAccess $array, bool $sort_keys = false, int $flags = 0)
 */
class Arr extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Helper::class;
    }
}
