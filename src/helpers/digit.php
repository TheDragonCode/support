<?php

use Helldar\Support\Facades\Digit;

if (! function_exists('factorial')) {
    /**
     * Calculating the factorial of a number.
     *
     * @param  int  $n
     *
     * @return float|int
     */
    function factorial(int $n = 0)
    {
        return Digit::factorial($n);
    }
}

if (! function_exists('short_number')) {
    /**
     * Converts a number into a short version.
     * eg: 1000 >> 1K.
     *
     * @param  float  $number
     * @param  int  $precision
     *
     * @return string
     */
    function short_number(float $number, int $precision = 1): string
    {
        return Digit::shortNumber($number, $precision);
    }
}
