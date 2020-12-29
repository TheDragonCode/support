<?php

use Helldar\Support\Facades\Digit;

if (! function_exists('factorial')) {
    /**
     * Calculating the factorial of a number.
     *
     * @deprecated 2.0: Using "factorial" is deprecated.
     *
     * @param  int  $n
     *
     * @return float|int
     */
    function factorial(int $n = 0)
    {
        trigger_deprecation('andrey-helldar/support', '2.0', 'Using "factorial" is deprecated.');

        return Digit::factorial($n);
    }
}

if (! function_exists('short_number')) {
    /**
     * Converts a number into a short version.
     * eg: 1000 >> 1K.
     *
     * @deprecated 2.0: Using "short_number" is deprecated.
     *
     * @param  float  $number
     * @param  int  $precision
     *
     * @throws \Helldar\Support\Exceptions\InvalidNumberException
     *
     * @return string
     */
    function short_number(float $number, int $precision = 1): string
    {
        trigger_deprecation('andrey-helldar/support', '2.0', 'Using "short_number" is deprecated.');

        return Digit::shortNumber($number, $precision);
    }
}
