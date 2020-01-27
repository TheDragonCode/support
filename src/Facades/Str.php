<?php

namespace Helldar\Support\Facades;

use Illuminate\Contracts\Support\Htmlable;

class Str
{
    /**
     * Escape HTML special characters in a string.
     *
     * @param Htmlable|string $value
     * @param bool $double_encode
     *
     * @return string
     */
    public static function e($value = null, bool $double_encode = true): ?string
    {
        if (is_null($value)) {
            return null;
        }

        if ($value instanceof Htmlable) {
            return $value->toHtml();
        }

        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', $double_encode);
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
        if (is_null($value)) {
            return null;
        }

        return htmlspecialchars_decode($value, ENT_QUOTES);
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
        return preg_replace('!\s+!', ' ', $value);
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

        if (empty(trim($additional))) {
            return trim($result);
        }

        return implode(' ', [trim($result), trim($additional)]);
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
        $quoted = preg_quote($cap, '/');

        return preg_replace('/(?:' . $quoted . ')+$/u', '', $value) . $cap;
    }

    /**
     * Determine if a given string ends with a given substring.
     *
     * @param string $haystack
     * @param array|string $needles
     *
     * @return bool
     */
    public static function endsWith($haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if (substr($haystack, -strlen($needle)) === (string) $needle) {
                return true;
            }
        }

        return false;
    }

    /**
     * Convert the given string to lower-case.
     *
     * @param string $value
     *
     * @return string
     */
    public static function lower($value)
    {
        return mb_strtolower($value, 'UTF-8');
    }

    /**
     * Convert a value to studly caps case.
     *
     * @param string $value
     *
     * @return string
     */
    public static function studly($value)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return str_replace(' ', '', $value);
    }

    /**
     * Convert a value to camel case.
     *
     * @param string $value
     *
     * @return string
     */
    public static function camel($value)
    {
        return lcfirst(static::studly($value));
    }

    /**
     * Convert a string to snake case.
     *
     * @param string $value
     * @param string $delimiter
     *
     * @return string
     */
    public static function snake($value, $delimiter = '_')
    {
        if (! ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));

            $value = static::lower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value));
        }

        return $value;
    }
}
