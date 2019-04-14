<?php

namespace Helldar\Support\Helpers;

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

        \array_map(function ($value, $key) use (&$result, $callback) {
            $new          = $callback($key);
            $result[$new] = $value;
        }, \array_values($array), \array_keys($array));

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
        return \mb_strlen(\max($array), 'UTF-8');
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
        if (\is_array($values) || \is_object($values)) {
            \array_map(function ($value) use (&$array) {
                $array = self::addUnique($array, $value);
            }, $values);
        } else {
            \array_push($array, $values);
        }

        return \array_unique($array);
    }

    /**
     * Sort an associative array in the order specified by an array of keys.
     *
     * Example:
     *
     *  $arr = ['q' => 1, 'r' => 2, 's' => 5, 'w' => 123];
     *
     *  Arr::sortByKeysArray($arr, ['q', 'w', 'e']);
     *
     * print_r($arr);
     *
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
        $sorter = \array_intersect($sorter, \array_keys($array));
        $array  = \array_merge(\array_flip($sorter), $array);

        return $array;
    }

    public static function store(array $array, string $path)
    {
        $value = \var_export($array, true);

        $replace = [
            '{{slot}}' => $value,
        ];

        $content = Stub::replace(Stub::ARRAY_STUB, $replace);

        Files::store($path, $content);
    }
}
