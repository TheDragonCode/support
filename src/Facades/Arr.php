<?php

namespace Helldar\Support\Facades;

use ArrayAccess;
use Helldar\Support\Tools\Stub;
use Helldar\Support\Traits\Deprecation;

/**
 * @deprecated 2.0: The namespace will be changed.
 */
class Arr
{
    use Deprecation;

    /**
     * Renaming array keys.
     * As the second parameter, a callback function is passed, which determines the actions for processing the value.
     * The output of the function must be a string with a name.
     *
     * @deprecated 2.0: The namespace will be changed.
     *
     * @param  array  $array
     * @param $callback
     *
     * @return array
     */
    public static function renameKeys(array $array, $callback): array
    {
        static::deprecationNamespace('The typing of the `$callback` variable will be set to `callable` in %s.', __FUNCTION__);

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
     * @deprecated 2.0: The namespace will be changed.
     *
     * @param  array  $array
     * @param  array  $map
     *
     * @return array
     */
    public static function renameKeysMap(array $array, array $map): array
    {
        static::deprecationNamespace();

        return self::renameKeys($array, static function ($key) use ($map) {
            return $map[$key] ?? $key;
        });
    }

    /**
     * Get the size of the longest text element of the array.
     *
     * @deprecated 2.0: The namespace will be changed. The method will be renamed.
     *
     * @param  array  $array
     *
     * @return int
     */
    public static function sizeOfMaxValue(array $array): int
    {
        static::deprecationNamespace('The %s method will be renamed to `longestStringLength()`.', __FUNCTION__);

        return count($array)
            ? max(array_map('mb_strlen', $array))
            : 0;
    }

    /**
     * Push one a unique element onto the end of array.
     *
     * @deprecated 2.0: The namespace will be changed.
     *
     * @param  array  $array
     * @param  array|mixed  $values
     *
     * @return array
     */
    public static function addUnique(array $array, $values): array
    {
        static::deprecationNamespace();

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
     * @deprecated 2.0: The namespace will be changed. Method will be renamed to `sortByKeys()`.
     *
     * @param  array  $array
     * @param  array  $sorter
     *
     * @return array
     */
    public static function sortByKeysArray(array $array, array $sorter)
    {
        static::deprecationNamespace('Method %s will be renamed to `sortByKeys()`.', __FUNCTION__);

        $sorter = array_intersect($sorter, array_keys($array));
        $array  = array_merge(array_flip($sorter), $array);

        return $array;
    }

    /**
     * Merge one or more arrays recursively.
     * Don't forget that numeric keys NOT will be renumbered!
     *
     * @deprecated 2.0: The namespace will be changed.
     *
     * @param  mixed  ...$arrays
     *
     * @return array
     */
    public static function merge(...$arrays): array
    {
        static::deprecationNamespace();

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

    /**
     * @deprecated 2.0: The namespace will be changed.
     *
     * @param  array  $array
     * @param  string  $path
     * @param  bool  $is_json
     * @param  bool  $sort_array_keys
     */
    public static function store(array $array, string $path, bool $is_json = false, bool $sort_array_keys = false)
    {
        static::deprecationNamespace(
            'The typing of the `array $array` parameter will change to just `$array` and the $sort_array_keys parameter will be renamed to $sort_keys.'
        );

        if ($is_json) {
            static::storeAsJson($array, $path, $sort_array_keys);
        } else {
            static::storeAsArray($array, $path, $sort_array_keys);
        }
    }

    /**
     * @deprecated 2.0: The namespace will be changed.
     *
     * @param  array  $array
     * @param  string  $path
     * @param  bool  $sort_array_keys
     */
    public static function storeAsArray(array $array, string $path, bool $sort_array_keys = false)
    {
        static::deprecationNamespace(
            'The typing of the `array $array` parameter will change to just `$array` and the $sort_array_keys parameter will be renamed to $sort_keys.'
        );

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

    /**
     * @deprecated 2.0: The namespace will be changed.
     *
     * @param  array  $array
     * @param  string  $path
     * @param  bool  $sort_array_keys
     */
    public static function storeAsJson(array $array, string $path, bool $sort_array_keys = false)
    {
        static::deprecationNamespace(
            'The typing of the `array $array` parameter will change to just `$array` and the $sort_array_keys parameter will be renamed to $sort_keys.'
        );

        if ($sort_array_keys) {
            ksort($array);
        }

        $replace = [
            '{{slot}}' => json_encode($array),
        ];

        $content = Stub::replace(Stub::LANG_JSON, $replace);

        File::store($path, $content);
    }

    /**
     * @deprecated 2.0: The namespace will be changed.
     *
     * @param  null  $array
     *
     * @return array|null[]
     */
    public static function wrap($array = null): array
    {
        static::deprecationNamespace('the $array parameter will be renamed to $value.');

        return is_array($array) ? $array : [$array];
    }

    /**
     * @deprecated 2.0: The namespace will be changed.
     *
     * @param  null  $array
     *
     * @return null[]
     */
    public static function toArray($array = null): array
    {
        static::deprecationNamespace('the $array parameter will be renamed to $value.');

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

    /**
     * @deprecated 2.0: The namespace will be changed.
     *
     * @param  array|ArrayAccess  $array
     * @param  int|string  $key
     *
     * @return bool
     */
    public static function exists(array $array, $key): bool
    {
        static::deprecationNamespace(
            'The typing of the `array $array` parameter will change to just `$array`.'
        );

        return $array instanceof ArrayAccess
            ? $array->offsetExists($key)
            : isset($array[$key]);
    }

    /**
     * @deprecated 2.0: The namespace will be changed.
     *
     * @param  array  $array
     * @param $key
     * @param  null  $default
     *
     * @return mixed|null
     */
    public static function get(array $array, $key, $default = null)
    {
        static::deprecationNamespace(
            'The typing of the `array $array` parameter will change to just `$array`.'
        );

        return static::exists($array, $key)
            ? $array[$key]
            : $default;
    }

    /**
     * @deprecated 2.0: The namespace will be changed.
     *
     * @param  array  $array
     * @param $keys
     *
     * @return array
     */
    public static function except(array $array, $keys): array
    {
        static::deprecationNamespace();

        $keys = (array) $keys;

        if (count($keys) === 0) {
            return $array;
        }

        return array_filter($array, function ($key) use ($keys) {
            return ! in_array($key, $keys);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Get a subset of the items from the given array.
     *
     * @deprecated 2.0: The namespace will be changed.
     *
     * @param  array  $array
     * @param  array  $keys
     *
     * @return array
     */
    public static function only(array $array, array $keys): array
    {
        static::deprecationNamespace(
            'The typing of the `array $array` parameter will change to just `$array`.'
        );

        return array_intersect_key($array, array_flip($keys));
    }

    /**
     * @deprecated 2.0: The namespace will be changed.
     *
     * @param  array  $array
     * @param  callable  $callback
     *
     * @return array
     */
    public static function map(array $array, callable $callback): array
    {
        static::deprecationNamespace(
            'The typing of the `array $array` parameter will change to just `$array`.'
        );

        return array_map($callback, $array);
    }
}
