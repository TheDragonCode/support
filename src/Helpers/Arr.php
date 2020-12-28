<?php

namespace Helldar\Support\Helpers;

use ArrayAccess;
use Helldar\Support\Helpers\Filesystem\File;

class Arr
{
    /**
     * Renaming array keys.
     * As the second parameter, a callback function is passed, which determines the actions for processing the value.
     * The output of the function must be a string with a name.
     *
     * @param  array  $array
     * @param  callable  $callback
     *
     * @return array
     */
    public function renameKeys(array $array, callable $callback): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $new = $callback($key, $value);

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
    public function renameKeysMap(array $array, array $map): array
    {
        return $this->renameKeys($array, static function ($key) use ($map) {
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
    public function longestStringLength(array $array): int
    {
        return ! empty($array)
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
    public function addUnique(array $array, $values): array
    {
        if ($this->isArrayable($values)) {
            foreach ($values as $value) {
                $array = $this->addUnique($array, $value);
            }
        } else {
            array_push($array, $values);
        }

        return array_values(array_unique($array));
    }

    /**
     * Sort an associative array in the order specified by an array of keys.
     *
     * Example:
     *
     *  $arr = ['q' => 1, 'r' => 2, 's' => 5, 'w' => 123];
     *
     *  Arr::sortByKeys($arr, ['q', 'w', 'e']);
     *
     * print_r($arr);
     *
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
    public function sortByKeys(array $array, array $sorter): array
    {
        $sorter = array_intersect($sorter, array_keys($array));
        $array  = array_merge(array_flip($sorter), $array);

        return $array;
    }

    /**
     * Merge one or more arrays recursively.
     * Don't forget that numeric keys NOT will be renumbered!
     *
     * @param  array[]  ...$arrays
     *
     * @return array
     */
    public function merge(...$arrays): array
    {
        $result = [];

        foreach ($arrays as $array) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $value = $this->merge($result[$key] ?? [], $value);
                }

                $result[$key] = $value;
            }
        }

        return $result;
    }

    public function wrap($value = null): array
    {
        return is_array($value) ? $value : [$value];
    }

    public function toArray($value = null): array
    {
        if (is_object($value)) {
            $value = method_exists($value, 'toArray') ? $value->toArray() : get_object_vars($value);
        }

        $array = $this->wrap($value);

        foreach ($array as &$item) {
            $item = $this->isArrayable($item) ? $this->toArray($item) : $item;
        }

        return $array;
    }

    public function exists(array $array, $key): bool
    {
        return $array instanceof ArrayAccess
            ? $array->offsetExists($key)
            : isset($array[$key]);
    }

    public function get(array $array, $key, $default = null)
    {
        // TODO: $array[$key] ?? $default;
        return $this->exists($array, $key) ? $array[$key] : $default;
    }

    public function except(array $array, $keys): array
    {
        $keys = (array) $keys;

        return array_filter($array, static function ($key) use ($keys) {
            return ! empty($keys) && ! in_array($key, $keys);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Get a subset of the items from the given array.
     *
     * @param  array  $array
     * @param  array|string  $keys
     *
     * @return array
     */
    public function only(array $array, $keys): array
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }

    public function map(array $array, callable $callback): array
    {
        return array_map($callback, $array);
    }

    public function isArrayable($value = null): bool
    {
        return is_array($value) || is_object($value) || $value instanceof ArrayAccess;
    }

    public function store(array $array, string $path, bool $is_json = false, bool $sort_keys = false): void
    {
        $is_json
            ? $this->storeAsJson($path, $array, $sort_keys)
            : $this->storeAsArray($path, $array, $sort_keys);
    }

    public function storeAsJson(string $path, array $array, bool $sort_keys = false): void
    {
        $this->prepareToStore($path, Stub::CONFIG_FILE, $array, static function (array $array) {
            return json_encode($array);
        }, $sort_keys);
    }

    public function storeAsArray(string $path, array $array, bool $sort_keys = false): void
    {
        $this->prepareToStore($path, Stub::CONFIG_FILE, $array, static function (array $array) {
            return var_export($array, true);
        }, $sort_keys);
    }

    protected function prepareToStore(string $path, string $stub, array $array, callable $replace, bool $sort_keys = false): void
    {
        if ($sort_keys) {
            ksort($array);
        }

        $content = Stub::replace($stub, [
            '{{slot}}' => $replace($array),
        ]);

        File::store($path, $content);
    }
}
