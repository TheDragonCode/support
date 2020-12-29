<?php

namespace Helldar\Support\Facades;

use ArrayAccess;
use Helldar\Support\Tools\Stub;
use Helldar\Support\Traits\Deprecation;

/**
 * @deprecated 2.0: Namespace "Helldar\Support\Facades\Arr" is deprecated, use "Helldar\Support\Facades\Helpers\Arr" instead.
 */
class Arr
{
    use Deprecation;

    /**
     * Renaming array keys.
     * As the second parameter, a callback function is passed, which determines the actions for processing the value.
     * The output of the function must be a string with a name.
     *
     * @param  array  $array
     * @param $callback
     *
     * @return array
     */
    public static function renameKeys(array $array, $callback): array
    {
        static::deprecatedNamespace();
        static::deprecatedMethodParameters(__FUNCTION__);

        $result = [];

        foreach ($array as $key => $value) {
            $new          = $callback($key);
            $result[$new] = $value;
        }

        return $result;
    }

    /**
     * Renaming array keys with map.
     *
     * @param  array  $array
     * @param  array  $map
     *
     * @return array
     */
    public static function renameKeysMap(array $array, array $map): array
    {
        static::deprecatedNamespace();

        return self::renameKeys($array, static function ($key) use ($map) {
            return $map[$key] ?? $key;
        });
    }

    /**
     * Get the size of the longest text element of the array.
     *
     * @param  array  $array
     *
     * @return int
     */
    public static function sizeOfMaxValue(array $array): int
    {
        static::deprecatedNamespace();
        static::deprecatedRenameMethod(__FUNCTION__, 'longestStringLength');

        return count($array)
            ? max(array_map('mb_strlen', $array))
            : 0;
    }

    /**
     * Push one a unique element onto the end of array.
     *
     * @param  array  $array
     * @param  array|mixed  $values
     *
     * @return array
     */
    public static function addUnique(array $array, $values): array
    {
        static::deprecatedNamespace();

        if (is_array($values) || is_object($values)) {
            foreach ($values as $value) {
                $array = static::addUnique($array, $value);
            }
        } else {
            array_push($array, $values);
        }

        return array_unique(array_values($array));
    }

    /**
     * Sort an associative array in the order specified by an array of keys.
     * Example:
     *  $arr = ['q' => 1, 'r' => 2, 's' => 5, 'w' => 123];
     *  Arr::sortByKeysArray($arr, ['q', 'w', 'e']);
     * print_r($arr);.
     * /*
     *   Array
     *   (
     *     [q] => 1
     *     [w] => 123
     *     [r] => 2
     *     [s] => 5
     *   )
     *
     * @see https://gist.github.com/Ellrion/a3145621f936aa9416f4c04987533d8d#file-helper-php
     *
     * @param  array  $array
     * @param  array  $sorter
     *
     * @return array
     */
    public static function sortByKeysArray(array $array, array $sorter)
    {
        static::deprecatedNamespace();
        static::deprecatedRenameMethod(__FUNCTION__, 'sortByKeys');

        $sorter = array_intersect($sorter, array_keys($array));
        $array  = array_merge(array_flip($sorter), $array);

        return $array;
    }

    /**
     * Merge one or more arrays recursively.
     * Don't forget that numeric keys NOT will be renumbered!
     *
     * @param  mixed  ...$arrays
     *
     * @return array
     */
    public static function merge(...$arrays): array
    {
        static::deprecatedNamespace();

        $result = [];

        foreach ($arrays as $array) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $value = static::merge($result[$key] ?? [], $value);
                }

                $result[$key] = $value;
            }
        }

        return $result;
    }

    public static function store(array $array, string $path, bool $is_json = false, bool $sort_array_keys = false)
    {
        static::deprecatedNamespace();
        static::deprecatedMethodParameters(__FUNCTION__);

        if ($is_json) {
            static::storeAsJson($array, $path, $sort_array_keys);
        } else {
            static::storeAsArray($array, $path, $sort_array_keys);
        }
    }

    public static function storeAsArray(array $array, string $path, bool $sort_array_keys = false)
    {
        static::deprecatedNamespace();
        static::deprecatedMethodParameters(__FUNCTION__);

        if ($sort_array_keys) {
            ksort($array);
        }

        $value = var_export($array, true);

        $replace = [
            '{{slot}}' => $value,
        ];

        $content = Stub::replace(Stub::CONFIG_FILE, $replace);

        File::store($path, $content);
    }

    public static function storeAsJson(array $array, string $path, bool $sort_array_keys = false)
    {
        static::deprecatedNamespace();
        static::deprecatedMethodParameters(__FUNCTION__);

        if ($sort_array_keys) {
            ksort($array);
        }

        $replace = [
            '{{slot}}' => json_encode($array),
        ];

        $content = Stub::replace(Stub::LANG_JSON, $replace);

        File::store($path, $content);
    }

    public static function wrap($array = null): array
    {
        static::deprecatedNamespace();
        static::deprecatedMethodParameters(__FUNCTION__);

        return is_array($array) ? $array : [$array];
    }

    public static function toArray($array = null): array
    {
        static::deprecatedNamespace();
        static::deprecatedMethodParameters(__FUNCTION__);

        if (is_object($array)) {
            $array = method_exists($array, 'toArray') ? $array->toArray() : get_object_vars($array);
        }

        $array = self::wrap($array);

        foreach ($array as &$item) {
            $item = is_array($item) || is_object($item)
                ? self::toArray($item)
                : $item;
        }

        return $array;
    }

    public static function exists(array $array, $key): bool
    {
        static::deprecatedNamespace();
        static::deprecatedMethodParameters(__FUNCTION__);

        return $array instanceof ArrayAccess
            ? $array->offsetExists($key)
            : isset($array[$key]);
    }

    public static function get(array $array, $key, $default = null)
    {
        static::deprecatedNamespace();
        static::deprecatedMethodParameters(__FUNCTION__);

        return static::exists($array, $key)
            ? $array[$key]
            : $default;
    }

    public static function except(array $array, $keys): array
    {
        static::deprecatedNamespace();

        $keys = (array) $keys;

        if (count($keys) === 0) {
            return $array;
        }

        return array_filter($array, function ($key) use ($keys) {
            return ! in_array($key, $keys);
        }, ARRAY_FILTER_USE_KEY);
    }

    public static function only(array $array, array $keys): array
    {
        static::deprecatedNamespace();
        static::deprecatedMethodParameters(__FUNCTION__);

        return array_intersect_key($array, array_flip($keys));
    }

    public static function map(array $array, callable $callback): array
    {
        static::deprecatedNamespace();
        static::deprecatedMethodParameters(__FUNCTION__);

        return array_map($callback, $array);
    }
}
