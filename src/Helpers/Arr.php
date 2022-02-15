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

namespace DragonCode\Support\Helpers;

use ArrayAccess;
use ArrayObject;
use Closure;
use DragonCode\Contracts\Support\Arrayable;
use DragonCode\Contracts\Support\Arrayable as DragonCodeArrayable;
use DragonCode\Support\Facades\Callbacks\Empties;
use DragonCode\Support\Facades\Callbacks\Sorter;
use DragonCode\Support\Facades\Helpers\Call as CallHelper;
use DragonCode\Support\Facades\Helpers\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Instance;
use DragonCode\Support\Facades\Helpers\Reflection;
use DragonCode\Support\Facades\Tools\Stub;
use DragonCode\Support\Helpers\Ables\Arrayable as ArrayableHelper;
use DragonCode\Support\Tools\Stub as StubTool;
use Illuminate\Contracts\Support\Arrayable as IlluminateArrayable;

class Arr
{
    /**
     * Get a new arrayable object from the given array.
     *
     * @param array|ArrayAccess|string|null $value
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function of($value = []): Ables\Arrayable
    {
        return new Ables\Arrayable($value);
    }

    /**
     * Renaming array keys.
     * As the second parameter, a callback function is passed, which determines the actions for processing the value.
     * The output of the function must be a string with a name.
     *
     * @param array $array
     * @param callable $callback
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
     * @param array $array
     * @param array $map
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
     * @param array $array
     *
     * @return int
     */
    public function longestStringLength(array $array): int
    {
        return ! empty($array) ? max(array_map('mb_strlen', $array)) : 0;
    }

    /**
     * Push one a unique element onto the end of array.
     *
     * @param array $array
     * @param mixed $values
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

        return $this->unique($array);
    }

    /**
     * Removes duplicate values from an array.
     *
     * Sorting type flags:
     *   SORT_REGULAR       - compare items normally
     *   SORT_NUMERIC       - compare items numerically
     *   SORT_STRING        - compare items as strings
     *   SORT_LOCALE_STRING - compare items as strings, based on the current locale
     *
     * @see https://php.net/manual/en/function.array-unique.php
     *
     * @param array $array
     * @param int $flags
     *
     * @return array
     */
    public function unique(array $array, int $flags = SORT_STRING): array
    {
        return array_unique($array, $flags);
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
     * @param array $array
     * @param array $sorter
     *
     * @return array
     */
    public function sortByKeys(array $array, array $sorter): array
    {
        $sorter = array_intersect($sorter, array_keys($array));

        return array_merge(array_flip($sorter), $array);
    }

    /**
     * Recursively sorting an array by values.
     *
     * @param array $array
     * @param callable|null $callback
     *
     * @return array
     */
    public function sort(array $array, ?callable $callback = null): array
    {
        $callback = $callback ?: Sorter::default();

        usort($array, $callback);

        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = $this->sort($value, $callback);
            }
        }

        return $array;
    }

    /**
     * Recursively sorting an array by keys.
     *
     * @param array $array
     * @param callable|null $callback
     *
     * @return array
     */
    public function ksort(array $array, ?callable $callback = null): array
    {
        $callback = $callback ?: Sorter::default();

        uksort($array, $callback);

        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = $this->ksort($value, $callback);
            }
        }

        return $array;
    }

    /**
     * Merge one or more arrays recursively.
     * Don't forget that numeric keys NOT will be renumbered!
     *
     * @param array[] ...$arrays
     *
     * @return array
     */
    public function merge(...$arrays): array
    {
        $result = [];

        foreach ($arrays as $array) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $prev_value = $result[$key] ?? [];

                    if (gettype($prev_value) !== 'array') {
                        $prev_value = [];
                    }

                    $value = $this->merge($prev_value, $value);
                }

                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Combining arrays without preserving keys.
     *
     * @param ...$arrays
     *
     * @return array
     */
    public function combine(...$arrays): array
    {
        $result = [];

        foreach ($arrays as $array) {
            foreach ($array as $key => $value) {
                if (is_array($value) && (! is_numeric($key) || ! isset($result[$key]))) {
                    $prev_value = $result[$key] ?? [];

                    if (gettype($prev_value) !== 'array') {
                        $prev_value = [];
                    }

                    $result[$key] = $this->combine($prev_value, $value);

                    continue;
                }

                if (is_array($value)) {
                    $value = $this->combine($value);
                }

                array_push($result, $value);
            }
        }

        return $result;
    }

    /**
     * If the given value is not an array and not null, wrap it in one.
     *
     * @param mixed $value
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
     * @param mixed $value
     *
     * @return array
     */
    public function toArray($value = null): array
    {
        if (Instance::of($value, [ArrayObject::class, ArrayableHelper::class])) {
            $value = CallHelper::runMethods($value, ['getArrayCopy', 'get']);
        }

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
     * @param array|ArrayAccess $array
     * @param mixed $key
     *
     * @return bool
     */
    public function exists($array, $key): bool
    {
        if ($this->existsWithoutDot($array, $key)) {
            return true;
        }

        if (strpos($key, '.') === false) {
            return $this->existsWithoutDot($array, $key);
        }

        foreach (explode('.', $key) as $segment) {
            if ($this->isArrayable($array) && $this->exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine if the given key exists in the provided array without dot divider.
     *
     * @param array|ArrayAccess $array
     * @param mixed $key
     *
     * @return bool
     */
    public function existsWithoutDot($array, $key): bool
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }

        return array_key_exists($key, $array);
    }

    /**
     * Get an item from an array.
     *
     * @see https://github.com/illuminate/collections/blob/master/Arr.php
     *
     * @param array|ArrayAccess $array
     * @param mixed $key
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function get($array, $key, $default = null)
    {
        if (! $this->isArrayable($array)) {
            return $default;
        }

        if (is_null($key)) {
            return $array;
        }

        if ($this->existsWithoutDot($array, $key)) {
            return $array[$key];
        }

        if (strpos($key, '.') === false) {
            return $array[$key] ?? $default;
        }

        foreach (explode('.', $key) as $segment) {
            if ($this->isArrayable($array) && $this->existsWithoutDot($array, $segment)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }

        return $array;
    }

    /**
     * If the element key exists, then return the name of the key, otherwise the default value.
     *
     * @param array|ArrayAccess $array
     * @param mixed $key
     * @param mixed $default
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
     * @param array|ArrayAccess $array
     * @param array|callable|string $keys
     *
     * @return array
     */
    public function except($array, $keys): array
    {
        $callback = is_callable($keys)
            ? $keys
            : static function ($key) use ($keys) {
                return empty($keys) || ! in_array($key, (array) $keys);
            };

        return $this->filter((array) $array, $callback, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Get a subset of the items from the given array.
     *
     * @param array|ArrayAccess $array
     * @param array|callable|string $keys
     *
     * @return array
     */
    public function only($array, $keys): array
    {
        if (is_callable($keys)) {
            return $this->filter($array, $keys, ARRAY_FILTER_USE_KEY);
        }

        $result = [];

        foreach ((array) $keys as $index => $key) {
            if (is_array($key) && isset($array[$index])) {
                $result[$index] = $this->only($array[$index], $key);
            } elseif (is_array($key) && ! isset($array[$index])) {
                continue;
            } elseif (isset($array[$key])) {
                $result[$key] = $array[$key];
            }
        }

        return $result;
    }

    /**
     * Iterates over each value in the <b>array</b> passing them to the <b>callback</b> function.
     * If the <b>callback</b> function returns true, the current value from <b>array</b> is returned into
     * the result array. Array keys are preserved.
     *
     * @see https://php.net/manual/en/function.array-filter.php
     *
     * @param array|ArrayAccess $array
     * @param callable|null $callback
     * @param int $mode
     *
     * @return array
     */
    public function filter($array, ?callable $callback = null, int $mode = 0): array
    {
        if (empty($callback)) {
            $callback = $mode === ARRAY_FILTER_USE_BOTH
                ? Empties::notEmptyBoth()
                : Empties::notEmpty();
        }

        return array_filter($array, $callback, $mode);
    }

    /**
     * Return all the keys or a subset of the keys of an array.
     *
     * @see https://php.net/manual/en/function.array-keys.php
     *
     * @param mixed $array
     *
     * @return array
     */
    public function keys($array): array
    {
        return array_keys($this->toArray($array));
    }

    /**
     * Return all the values of an array.
     *
     * @see  https://php.net/manual/en/function.array-values.php
     *
     * @param mixed $array
     *
     * @return array
     */
    public function values($array): array
    {
        return array_values($this->toArray($array));
    }

    /**
     * Exchanges all keys with their associated values in an array.
     *
     * @see  https://php.net/manual/en/function.array-flip.php
     *
     * @param mixed $array
     *
     * @return array
     */
    public function flip($array): array
    {
        return array_flip($this->toArray($array));
    }

    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * @param array $array
     * @param bool $ignore_keys
     *
     * @return array
     */
    public function flatten(array $array, bool $ignore_keys = true): array
    {
        $result = [];

        foreach ($array as $key => $item) {
            if (! $this->isArrayable($item)) {
                $result = $ignore_keys
                    ? $this->push($result, $item)
                    : $this->set($result, $key, $item);

                continue;
            }

            $flatten = $this->flatten($item, $ignore_keys);

            $values = $ignore_keys ? array_values($flatten) : $flatten;

            $result = array_merge($result, $values);
        }

        return $ignore_keys ? array_values($result) : $result;
    }

    public function flattenKeys(array $array, string $delimiter = '.', ?string $prefix = null): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $values = $this->flattenKeys($value, $delimiter, $key);

                $result = array_merge($result, $values);

                continue;
            }

            $new_key = ! empty($prefix) ? $prefix . $delimiter . $key : $key;

            $result[$new_key] = $value;
        }

        return $result;
    }

    /**
     * Applies the callback to the elements of the given arrays.
     *
     * @param array|ArrayAccess $array
     * @param callable $callback
     * @param bool $recursive
     *
     * @return array
     */
    public function map($array, callable $callback, bool $recursive = false): array
    {
        foreach ($array as $key => &$value) {
            if ($recursive && is_array($value)) {
                $value = $this->map($value, $callback, $recursive);
            } else {
                $value = is_array($value) ? $value : $callback($value, $key);
            }
        }

        return $array;
    }

    /**
     * Push elements onto the end of array.
     *
     * @see  https://php.net/manual/en/function.array-push.php
     *
     * @param array|ArrayAccess $array
     * @param mixed ...$values
     *
     * @return array
     */
    public function push($array, ...$values): array
    {
        foreach ($values as $value) {
            array_push($array, $value);
        }

        return $array;
    }

    /**
     * Assigns a value to an array key.
     *
     * @param array|ArrayAccess $array
     * @param mixed $key
     * @param mixed $value
     *
     * @return array
     */
    public function set($array, $key, $value = null): array
    {
        if ($this->isArrayable($key)) {
            $array = $this->merge($array, $key);
        } else {
            $array[$key] = $value;
        }

        return $array;
    }

    /**
     * Removes an array key.
     *
     * @param array|ArrayAccess $array
     * @param mixed $key
     *
     * @return array
     */
    public function remove($array, $key): array
    {
        unset($array[$key]);

        return $array;
    }

    /**
     * Call the given Closure with the given value then return the value.
     *
     * @param array|ArrayAccess $array
     * @param callable $callback
     *
     * @return array
     */
    public function tap($array, callable $callback): array
    {
        foreach ($array as $key => &$value) {
            $callback($value, $key);
        }

        return $array;
    }

    /**
     * Check if the item is an array.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function isArrayable($value = null): bool
    {
        if (is_array($value) || is_object($value)) {
            return true;
        }

        if (
            is_string($value)
            && method_exists($value, 'toArray')
            && ! Reflection::isStaticMethod($value, 'toArray')
        ) {
            return false;
        }

        if (
            Instance::of($value, [
                DragonCodeArrayable::class,
                IlluminateArrayable::class,
                ArrayableHelper::class,
                ArrayObject::class,
                ArrayAccess::class,
                Arrayable::class,
            ])
        ) {
            return true;
        }

        return (bool) (Instance::of($value, Closure::class) && method_exists($value, 'toArray'));
    }

    /**
     * Determines if the array or arrayable object is empty.
     *
     * @param mixed $value
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
     * Determines if the value is doesn't empty.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function doesntEmpty($value): bool
    {
        return ! $this->isEmpty($value);
    }

    /**
     * Return an array with elements in reverse order.
     *
     * @param array $array
     * @param bool $preserve_keys
     *
     * @return array
     */
    public function reverse(array $array, bool $preserve_keys = false): array
    {
        return array_reverse($array, $preserve_keys);
    }

    /**
     * Save array to php or json file.
     *
     * @param array|ArrayAccess $array
     * @param string $path
     * @param bool $is_json
     * @param bool $sort_keys
     * @param int $json_flags
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
     * @param string $path
     * @param array|ArrayAccess $array
     * @param bool $sort_keys
     * @param int $flags
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
     * @param string $path
     * @param array|ArrayAccess $array
     * @param bool $sort_keys
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
     * @param string $path
     * @param string $stub
     * @param array|ArrayAccess $array
     * @param callable $replace
     * @param bool $sort_keys
     */
    protected function prepareToStore(string $path, string $stub, array $array, callable $replace, bool $sort_keys = false): void
    {
        $array = (array) $array;

        if ($sort_keys) {
            $this->ksort($array);
        }

        $content = Stub::replace($stub, [
            '{{slot}}' => $replace($array),
        ]);

        File::store($path, $content);
    }
}
