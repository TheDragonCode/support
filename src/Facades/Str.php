<?php

namespace Helldar\Support\Facades;

class Str
{
    /**
     * Escape HTML special characters in a string.
     *
     * @param string $value
     * @param bool $double_encode
     *
     * @return string
     */
    public static function e(string $value, bool $double_encode = true): string
    {
        return \htmlspecialchars($value, ENT_QUOTES, 'UTF-8', $double_encode);
    }

    /**
     * Convert special HTML entities back to characters.
     *
     * @param string|null $value
     *
     * @return string|null
     */
    public static function de(string $value = null): ?string
    {
        if (\is_null($value)) {
            return null;
        }

        return \htmlspecialchars_decode($value, ENT_QUOTES);
    }

    /**
     * Replacing multiple spaces with a single space.
     *
     * @param string $value
     *
     * @return string|null
     */
    public static function replaceSpaces(string $value): ?string
    {
        return \preg_replace('!\s+!', ' ', $value);
    }

    /**
     * The str_choice function translates the given language line with inflection.
     *
     * @param float $number
     * @param array $choice
     * @param string $additional
     *
     * @return string
     */
    public static function choice(float $number, array $choice = [], string $additional = '')
    {
        $result = $choice[0] ?? '';
        $number = (int) $number;
        $mod    = $number % 10;

        if ($mod == 0 || ($mod >= 5 && $mod <= 9) || ($number % 100 >= 11 && $number % 100 <= 20)) {
            $result = $choice[2] ?? '';
        } elseif ($mod >= 2 && $mod <= 4) {
            $result = $choice[1] ?? '';
        }

        if (empty(\trim($additional))) {
            return \trim($result);
        }

        return \implode(' ', [\trim($result), \trim($additional)]);
    }

    /**
     * Cap a string with a single instance of a given value.
     *
     * @param string $value
     * @param string $cap
     *
     * @return string
     */
    public static function finish(string $value, string $cap = '/'): string
    {
        $quoted = \preg_quote($cap, '/');

        return \preg_replace('/(?:' . $quoted . ')+$/u', '', $value) . $cap;
    }
}
