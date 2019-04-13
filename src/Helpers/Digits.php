<?php

namespace Helldar\Support\Helpers;

use Helldar\Support\Exceptions\InvalidNumberException;

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

    /**
     * Converts a number into a short version.
     * eg: 1000 >> 1K
     *
     * @param float $digit
     * @param int $precision
     *
     * @return string
     */
    public static function shortNumber(float $digit, int $precision = 1): string
    {
        if (!\is_numeric($digit)) {
            throw new InvalidNumberException($digit);
        }

        $length = \strlen((string) ((int) $digit));
        $length = \ceil($length / 3) * 3 + 1;

        $suffix = self::suffix($length);
        $value  = self::numberFormat($digit, $length, $precision);

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
    public static function numberFormat(float $digit, int $length = 4, int $precision = 1): float
    {
        $divider = (double) \bcpow(10, ($length - 4), 2);

        return \round($digit / $divider, $precision);
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

        \ksort($suffixes);

        return $suffixes[$length] ?? \end($suffixes);
    }
}
