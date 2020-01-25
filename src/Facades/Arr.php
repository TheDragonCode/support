<?php

namespace Helldar\Support\Facades;

use ArrayAccess;
use Helldar\Support\Tools\Stub;

class Arr
{
    /**
     * Renaming array keys.
     * As the first parameter, a callback function is passed, which determines the actions for processing the value.
     * The output of the function must be a string with a name.
     *
     * @param array $array
     * @param $callback
     *
     * @return array
     */
    public static function renameKeys(array $array, $callback): array
    {
        $result = [];

        array_map(function ($value, $key) use (&$result, $callback) {
            $new          = $callback($key);
            $result[$new] = $value;
        }, array_values($array), array_keys($array));

        return $result;
    }

    /**
     * Get the size of the longest text element of the array.
     *
     * @param array $array
     *
     * @return int
     */
    public static function sizeOfMaxValue(array $array): int
    {
        return max(array_map('mb_strlen', $array));
    }

    /**
     * Push one a unique element onto the end of array.
     *
     * @param array $array
     * @param array|mixed $values
     *
     * @return array
     */
    public static function addUnique(array $array, $values): array
    {
        if (is_array($values) || is_object($values)) {
            array_map(function ($value) use (&$array) {
                $array = static::addUnique($array, $value);
            }, $values);
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
     * print_r($arr);
     * /*
     *   Array
     *   (
     *     [q] => 1
     *     [w] => 123
     *     [r] => 2
     *     [s] => 5
     *   )
     *
     * @see https://gist.github.com/Ellrion/a3145621f936aa9416f4c04987533d8d#file-helper-php Original Source
     *
     * @param array $array
     * @param array $sorter
     *
     * @return array
     */
    public static function sortByKeysArray(array $array, array $sorter)
    {
        $sorter = array_intersect($sorter, array_keys($array));
        $array  = array_merge(array_flip($sorter), $array);

        return $array;
    }

    /**
     * Merge one or more arrays recursively.
     * Don't forget that numeric keys NOT will be renumbered!
     *
     * @param mixed ...$arrays
     *
     * @return array
     */
    public static function merge(...$arrays): array
    {
        $result = [];

        array_map(function ($array) use (&$result) {
            array_map(function ($key, $value) use (&$result) {
                if (is_array($value)) {
                    $value = static::merge($result[$key] ?? [], $value);
                }

                $result[$key] = $value;
            }, array_keys($array), array_values($array));
        }, $arrays);

        return $result;
    }

    public static function store(array $array, string $path, bool $is_json = false, bool $sort_array_keys = false)
    {
        if ($is_json) {
            static::storeAsJson($array, $path, $sort_array_keys);
        } else {
            static::storeAsArray($array, $path, $sort_array_keys);
        }
    }

    public static function storeAsArray(array $array, string $path, bool $sort_array_keys = false)
    {
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
        return is_array($array) ? $array : [$array];
    }

    public static function toArray($array = null): array
    {
        return is_object($array)
            ? get_object_vars($array)
            : static::wrap($array);
    }

    /**
     * @param array|ArrayAccess $array
     * @param int|string $key
     *
     * @return bool
     */
    public static function exists(array $array, $key): bool
    {
        return $array instanceof ArrayAccess
            ? $array->offsetExists($key)
            : array_key_exists($key, $array);
    }

    public static function get(array $array, $key, $default = null)
    {
        return static::exists($array, $key)
            ? $array[$key]
            : $default;
    }

    public static function except(array $array, $keys): array
    {
        $keys = (array) $keys;

        if (count($keys) === 0) {
            return $array;
        }

        return array_filter($array, function ($key) use ($keys) {
            return ! in_array($key, $keys);
        }, ARRAY_FILTER_USE_KEY);
    }
}
