<?php

namespace Helldar\Support\Helpers;

class Digits
{
    /**
     * Calculating the factorial of a number.
     *
     * @param int $n
     *
     * @return float|int
     */
    public static function factorial($n = 0)
    {
        if ($n == 0) {
            return 1;
        }

        return $n * self::factorial($n - 1);
    }
}
