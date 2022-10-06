<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2022 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace DragonCode\Support\Helpers\Ables;

use ArrayObject;
use DragonCode\Contracts\Support\Arrayable as ArrayableContract;
use DragonCode\Support\Concerns\Dumpable;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Instances\Call;
use DragonCode\Support\Facades\Instances\Instance;
use JetBrains\PhpStorm\Pure;

class Arrayable implements ArrayableContract
{
    use Dumpable;

    protected Arrayable|ArrayObject|array|null $value = [];

    public function __construct(Arrayable|ArrayObject|array|null $value = [])
    {
        $this->of($value);
    }

    public function of(Arrayable|ArrayObject|array|null $value = []): self
    {
        $this->value = Instance::of($value, Arrayable::class) ? $value->toArray() : (array) $value;

        return $this;
    }

    /**
     * Performing an action on a condition.
     *
     * @param mixed $condition
     * @param callable $callback
     * @param mixed|null $default
     *
     * @return $this
     */
    public function when(mixed $condition, callable $callback, mixed $default = null): self
    {
        if (Call::value($condition, $this)) {
            $value = Call::value($callback, $this);

            return new self($value);
        }

        return ! is_null($default) ? $this->when(true, $default) : $this;
    }

    /**
     * Join array elements with a string.
     *
     * @param string $separator
     *
     * @return \DragonCode\Support\Helpers\Ables\Stringable
     */
    #[Pure]
    public function implode(string $separator): Stringable
    {
        return new Stringable(implode($separator, $this->value));
    }

    /**
     * Returns the final array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->value ?: [];
    }

    /**
     * Renaming array keys.
     * As the second parameter, a callback function is passed, which determines the actions for processing the value.
     * The output of the function must be a string with a name.
     *
     * @param callable $callback
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function renameKeys(callable $callback): self
    {
        return new self(Arr::renameKeys($this->value, $callback));
    }

    /**
     * Renaming array keys with map.
     *
     * @param array $map
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function renameKeysMap(array $map): self
    {
        return new self(Arr::renameKeysMap($this->value, $map));
    }

    /**
     * Push one a unique element onto the end of array.
     *
     * @param mixed $values
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function addUnique(mixed $values): self
    {
        return new self(Arr::addUnique($this->value, $values));
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
     * @param int $flags
     *
     * @return $this
     */
    public function unique(int $flags = SORT_STRING): self
    {
        return new self(Arr::unique($this->value, $flags));
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
     * @param array $sorter
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function sortByKeys(array $sorter): self
    {
        return new self(Arr::sortByKeys($this->value, $sorter));
    }

    /**
     * Recursively sorting an array by values.
     *
     * @param callable|null $callback
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function sort(?callable $callback = null): self
    {
        return new self(Arr::sort($this->value, $callback));
    }

    /**
     * Recursively sorting an array by keys.
     *
     * @param callable|null $callback
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function ksort(?callable $callback = null): self
    {
        return new self(Arr::ksort($this->value, $callback));
    }

    /**
     * Merge one or more arrays recursively.
     * Don't forget that numeric keys NOT will be renumbered!
     *
     * @param array ...$arrays
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function merge(array ...$arrays): self
    {
        return new self(Arr::merge($this->value, ...$arrays));
    }

    /**
     * Combining arrays without preserving keys.
     *
     * @param ...$arrays
     *
     * @return $this
     */
    public function combine(array ...$arrays): self
    {
        return new self(Arr::combine($this->value, ...$arrays));
    }

    /**
     * Make the instance as an array recursively.
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function resolve(): self
    {
        return new self(Arr::resolve($this->value));
    }

    /**
     * Get an item from an array.
     *
     * @param mixed $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function get(mixed $key, mixed $default = null): mixed
    {
        return Arr::get($this->value, $key, $default);
    }

    /**
     * If the element key exists, then return the name of the key, otherwise the default value.
     *
     * @param mixed $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function getKey(mixed $key, mixed $default = null): mixed
    {
        return Arr::getKey($this->value, $key, $default);
    }

    /**
     * Get all of the given array except for a specified array of keys.
     *
     * @param array|callable|string $keys
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function except(array|callable|string $keys): self
    {
        return new self(Arr::except($this->value, $keys));
    }

    /**
     * Get a subset of the items from the given array.
     *
     * @param array|callable|string $keys
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function only(array|callable|string $keys): self
    {
        return new self(Arr::only($this->value, $keys));
    }

    /**
     * Iterates over each value in the <b>array</b> passing them to the <b>callback</b> function.
     * If the <b>callback</b> function returns true, the current value from <b>array</b> is returned into
     * the result array. Array keys are preserved.
     *
     * @see https://php.net/manual/en/function.array-filter.php
     *
     * @param callable|null $callback
     * @param int $mode
     *
     * @return $this
     */
    public function filter(?callable $callback = null, int $mode = 0): self
    {
        return new self(Arr::filter($this->value, $callback, $mode));
    }

    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * @param bool $ignore_keys
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function flatten(bool $ignore_keys = true): self
    {
        return new self(Arr::flatten($this->value, $ignore_keys));
    }

    public function flattenKeys(string $delimiter = '.', ?string $prefix = null): self
    {
        return new self(Arr::flattenKeys($this->value, $delimiter, $prefix));
    }

    /**
     * Applies the callback to the elements of the given arrays.
     *
     * @param callable $callback
     * @param bool $recursive
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function map(callable $callback, bool $recursive = false): self
    {
        return new self(Arr::map($this->value, $callback, $recursive));
    }

    /**
     * Creating a new instance of the given class by passing the value into the constructor.
     *
     * @param string $class
     *
     * @return $this
     */
    public function mapInto(string $class): self
    {
        return new self(Arr::mapInto($this->value, $class));
    }

    /**
     * Exchanges all keys with their associated values in an array.
     *
     * @see  https://php.net/manual/en/function.array-flip.php
     *
     * @return $this
     */
    public function flip(): self
    {
        return new self(Arr::flip($this->value));
    }

    /**
     * Return all the keys or a subset of the keys of an array.
     *
     * @see https://php.net/manual/en/function.array-keys.php
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function keys(): self
    {
        return new self(Arr::keys($this->value));
    }

    /**
     * Return all the values of an array.
     *
     * @see  https://php.net/manual/en/function.array-values.php
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function values(): self
    {
        return new self(Arr::values($this->value));
    }

    /**
     * Push elements onto the end of array.
     *
     * @see  https://php.net/manual/en/function.array-push.php
     *
     * @param mixed ...$values
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function push(mixed ...$values): self
    {
        return new self(Arr::push($this->value, ...$values));
    }

    /**
     * Assigns a value to an array key.
     *
     * @param string|int|float $key
     * @param mixed $value
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function set(string|int|float $key, mixed $value = null): self
    {
        return new self(Arr::set($this->value, $key, $value));
    }

    /**
     * Removes an array key.
     *
     * @param mixed $key
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function remove(string|int|float $key): self
    {
        return new self(Arr::remove($this->value, $key));
    }

    /**
     * Call the given Closure with the given value then return the value.
     *
     * @param callable $callback
     *
     * @return $this
     */
    public function tap(callable $callback): self
    {
        return new self(Arr::tap($this->value, $callback));
    }

    /**
     * Return an array with elements in reverse order.
     *
     * @param bool $preserve
     *
     * @return \DragonCode\Support\Helpers\Ables\Arrayable
     */
    public function reverse(bool $preserve = false): self
    {
        return new self(Arr::reverse($this->value, $preserve));
    }

    /**
     * Remove a portion of the array and replace it with something else.
     *
     * @see https://php.net/manual/en/function.array-splice.php
     *
     * @param int $offset
     * @param int|null $length
     * @param mixed $replacement
     *
     * @return $this
     */
    public function splice(int $offset, ?int $length = null, mixed $replacement = null): self
    {
        return new self(Arr::splice($this->value, $offset, $length, $replacement));
    }

    /**
     * Get the size of the longest text element of the array.
     *
     * @return int
     */
    public function longestStringLength(): int
    {
        return Arr::longestStringLength($this->value);
    }

    /**
     * Determine if the given key exists in the provided array.
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function exists(mixed $key): bool
    {
        return Arr::exists($this->value, $key);
    }

    /**
     * Determine if the given key doesn't exist in the provided array.
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function doesntExist(mixed $key): bool
    {
        return Arr::doesntExist($this->value, $key);
    }

    /**
     * Determine if the given key exists in the provided array without dot divider.
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function existsWithoutDot(mixed $key): bool
    {
        return Arr::existsWithoutDot($this->value, $key);
    }

    /**
     * Determine if the given key doesn't exist in the provided array without dot divider.
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function doesntExistWithoutDot(mixed $key): bool
    {
        return Arr::doesntExistWithoutDot($this->value, $key);
    }

    /**
     * Determines if the array or arrayable object is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return Arr::isEmpty($this->value);
    }

    /**
     * Determines if the value is doesn't empty.
     *
     * @return bool
     */
    public function doesntEmpty(): bool
    {
        return Arr::doesntEmpty($this->value);
    }

    /**
     * Return the first element in an array passing a given truth test.
     *
     * @param callable|null $callback
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function first(?callable $callback = null, mixed $default = null): mixed
    {
        return Arr::first($this->value, $callback, $default);
    }

    /**
     * Return the last element in an array passing a given truth test.
     *
     * @param callable|null $callback
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function last(?callable $callback = null, mixed $default = null): mixed
    {
        return Arr::last($this->value, $callback, $default);
    }

    /**
     * Returns the number of array elements.
     *
     * @return int
     */
    public function count(): int
    {
        return Arr::count($this->value);
    }

    /**
     * Returns an object filled with the value of the array.
     *
     * @param string $instance
     *
     * @return mixed
     */
    public function toInstance(string $instance): mixed
    {
        if (method_exists($instance, '__invoke')) {
            $instance = new $instance();

            call_user_func([$instance, '__invoke'], $this->value);

            return $instance;
        }

        return new $instance($this->value);
    }
}
