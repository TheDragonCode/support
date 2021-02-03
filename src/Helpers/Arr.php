<?php

namespace Helldar\Support\Helpers;

use ArrayAccess;
use Helldar\Support\Facades\Helpers\Filesystem\File;
use Helldar\Support\Facades\Tools\Stub;
use Helldar\Support\Tools\Stub as StubTool;

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

        ksort($result);

        return $result;
    }

    /**
     * If the given value is not an array and not null, wrap it in one.
     *
     * @param  null  $value
     *
     * @return array
     */
    public function wrap($value = null): array
    {
        if (is_array($value)) {
            return $value;
        }

        return ! empty($value) ? [$value] : [];
    }

    /**
     * Get the instance as an array.
     *
     * @param  mixed  $value
     *
     * @return array
     */
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

    /**
     * Determine if the given key exists in the provided array.
     *
     * @param  array|\ArrayAccess  $array
     * @param  mixed  $key
     *
     * @return bool
     */
    public function exists($array, $key): bool
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }

        return isset($array[$key]);
    }

    /**
     * Get an item from an array.
     *
     * @param  array|ArrayAccess  $array
     * @param  mixed  $key
     * @param  mixed|null  $default
     *
     * @return mixed|null
     */
    public function get($array, $key, $default = null)
    {
        return $array[$key] ?? $default;
    }

    /**
     * If the element key exists, then return the name of the key, otherwise the default value.
     *
     * @param  array|ArrayAccess  $array
     * @param  mixed  $key
     * @param  null  $default
     *
     * @return mixed|null
     */
    public function getKey($array, $key, $default = null)
    {
        return $this->exists($array, $key) ? $key : $default;
    }

    /**
     * Get all of the given array except for a specified array of keys.
     *
     * @param  array|ArrayAccess  $array
     * @param $keys
     *
     * @return array
     */
    public function except($array, $keys): array
    {
        $keys = (array) $keys;

        return array_filter($array, static function ($key) use ($keys) {
            return empty($keys) || ! in_array($key, $keys);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Get a subset of the items from the given array.
     *
     * @param  array|ArrayAccess  $array
     * @param  array|string  $keys
     *
     * @return array
     */
    public function only($array, $keys): array
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }

    /**
     * Applies the callback to the elements of the given arrays.
     *
     * @param  array|ArrayAccess  $array
     * @param  callable  $callback
     *
     * @return array
     */
    public function map($array, callable $callback): array
    {
        foreach ($array as $key => &$value) {
            $value = $callback($value, $key);
        }

        return $array;
    }

    /**
     * Check if the item is an array.
     *
     * @param  null  $value
     *
     * @return bool
     */
    public function isArrayable($value = null): bool
    {
        return is_array($value) || is_object($value) || $value instanceof ArrayAccess;
    }

    /**
     * Determines if the array or arrayable object is empty.
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    public function isEmpty($value): bool
    {
        $value = is_object($value) && method_exists($value, 'toArray') ? $value->toArray() : $value;
        $value = is_object($value) ? (array) $value : $value;

        return is_array($value) && empty($value);
    }

    /**
     * Save array to php or json file.
     *
     * @param  array|ArrayAccess  $array
     * @param  string  $path
     * @param  bool  $is_json
     * @param  bool  $sort_keys
     * @param  int  $json_flags
     */
    public function store($array, string $path, bool $is_json = false, bool $sort_keys = false, int $json_flags = 0): void
    {
        $is_json
            ? $this->storeAsJson($path, $array, $sort_keys, $json_flags)
            : $this->storeAsArray($path, $array, $sort_keys);
    }

    /**
     * Save array to json file.
     *
     * @param  string  $path
     * @param  array|ArrayAccess  $array
     * @param  bool  $sort_keys
     * @param  int  $flags
     */
    public function storeAsJson(string $path, $array, bool $sort_keys = false, int $flags = 0): void
    {
        $this->prepareToStore($path, StubTool::JSON, $array, static function (array $array) use ($flags) {
            return json_encode($array, $flags);
        }, $sort_keys);
    }

    /**
     * Save array to php file.
     *
     * @param  string  $path
     * @param  array|ArrayAccess  $array
     * @param  bool  $sort_keys
     */
    public function storeAsArray(string $path, $array, bool $sort_keys = false): void
    {
        $this->prepareToStore($path, StubTool::PHP_ARRAY, $array, static function (array $array) {
            return var_export($array, true);
        }, $sort_keys);
    }

    /**
     * Prepare an array for writing to a file.
     *
     * @param  string  $path
     * @param  string  $stub
     * @param  array  $array
     * @param  callable  $replace
     * @param  bool  $sort_keys
     */
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
