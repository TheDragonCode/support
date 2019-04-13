<?php

namespace Helldar\Support\Helpers;

class Arr
{
    /**
     * Returns the number of characters of the longest element in the array.
     *
     * @param array $array
     *
     * @return int
     */
    public static function itemValueMaxLength(array $array): int
    {
        $max = 0;

        \array_map(function ($value) use (&$max) {
            $value = \strlen((string) $value);

            if ($value > $max) {
                $max = $value;
            }
        }, $array);

        return $max;
    }
}
