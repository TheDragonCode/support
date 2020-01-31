<?php

namespace Helldar\Support\Facades;

use function bcpow;

use function ceil;
use function end;
use Helldar\Support\Exceptions\InvalidNumberException;
use function is_numeric;
use function ksort;
use function round;
use function strlen;
use function substr;

class Digit
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

        return $n * static::factorial($n - 1);
    }

    /**
     * Converts a number into a short version.
     * eg: 1000 >> 1K
     *
     * @param float $number
     * @param int $precision
     *
     * @throws InvalidNumberException
     *
     * @return string
     */
    public static function shortNumber(float $number, int $precision = 1): string
    {
        if (! is_numeric($number)) {
            throw new InvalidNumberException($number);
        }

        $length = strlen((string) ((int) $number));
        $length = ceil($length / 3) * 3 + 1;

        $suffix = static::suffix($length);
        $value  = static::roundedBcPow($number, $length, $precision);

        return $value . $suffix;
    }

    /**
     * Format a number with grouped with divider.
     *
     * @param float $digit
     * @param int $length
     * @param int $precision
     *
     * @return float
     */
    public static function roundedBcPow(float $digit, int $length = 4, int $precision = 1): float
    {
        $divider = (double) bcpow(10, ($length - 4), 2);

        return round($digit / $divider, $precision);
    }

    /**
     * Create short unique identifier from number.
     * Actually using in short URL.
     *
     * @param int $number
     * @param string $chars
     *
     * @return string
     */
    public static function shortString(int $number, string $chars = 'abcdefghijklmnopqrstuvwxyz'): string
    {
        $length = strlen($chars);
        $mod    = $number % $length;

        if ($number - $mod == 0) {
            return substr($chars, $number, 1);
        }

        $result = '';

        while ($mod > 0 || $number > 0) {
            $result = substr($chars, $mod, 1) . $result;
            $number = ($number - $mod) / $length;
            $mod    = $number % $length;
        }

        return $result;
    }

    /**
     * Getting the suffix for abbreviated numbers.
     *
     * @param int $length
     *
     * @return string
     */
    private static function suffix(int $length = 0): string
    {
        $suffixes = [
            4  => '',
            7  => 'K',
            10 => 'M',
            13 => 'B',
            16 => 'T+',
        ];

        ksort($suffixes);

        return $suffixes[$length] ?? end($suffixes);
    }
}
