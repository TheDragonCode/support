<?php

namespace Helldar\Support\Helpers;

use Helldar\Support\Facades\Helpers\Call as CallHelper;
use Illuminate\Contracts\Support\DeferringDisplayableValue;
use Illuminate\Contracts\Support\Htmlable;

final class Str
{
    /**
     * The cache of snake-cased words.
     *
     * @var array
     */
    protected static $snakeCache = [];

    /**
     * The cache of camel-cased words.
     *
     * @var array
     */
    protected static $camelCache = [];

    /**
     * The cache of studly-cased words.
     *
     * @var array
     */
    protected static $studlyCache = [];

    protected $escaping_methods = [
        DeferringDisplayableValue::class => 'resolveDisplayableValue',
        Htmlable::class                  => 'toHtml',
    ];

    /**
     * Escape HTML special characters in a string.
     *
     * @param  string|null  $value
     * @param  bool  $double
     *
     * @return string|null
     */
    public function e(?string $value, bool $double = true): ?string
    {
        if ($escaped = CallHelper::runOf($this->escaping_methods, $value)) {
            return $escaped;
        }

        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', $double);
    }

    /**
     * Convert special HTML entities back to characters.
     *
     * @param  string|null  $value
     *
     * @return string|null
     */
    public function de(?string $value): ?string
    {
        return htmlspecialchars_decode($value, ENT_QUOTES);
    }

    /**
     * Replacing multiple spaces with a single space.
     *
     * @param  string|null  $value
     *
     * @return string|null
     */
    public function removeSpaces(?string $value): ?string
    {
        return preg_replace('!\s+!', ' ', $value);
    }

    /**
     * Get a string according to an integer value.
     *
     * @param  float  $number
     * @param  array  $choice
     * @param  string|null  $extra
     *
     * @return string
     */
    public function choice(float $number, array $choice = [], string $extra = null): string
    {
        $number = (int) $number;
        $mod    = $number % 10;

        switch (true) {
            case $mod === 0:
            case $mod >= 5 && $mod <= 9:
            case ($number % 100 >= 11) && ($number % 100 <= 20):
                $result = $choice[2] ?? '';
                break;

            case $mod >= 2 && $mod <= 4:
                $result = $choice[1] ?? '';
                break;

            default:
                $result = $choice[0] ?? '';
        }

        if (empty($extra)) {
            return trim($result);
        }

        return implode(' ', [trim($result), trim($extra)]);
    }

    /**
     * Begin a string with a single instance of a given value.
     *
     * @see https://github.com/illuminate/support/blob/master/Str.php
     *
     * @param  string|null  $value
     * @param  string  $prefix
     *
     * @return string
     */
    public function start(?string $value, string $prefix): string
    {
        $quoted = preg_quote($prefix, '/');

        return $prefix . preg_replace('/^(?:' . $quoted . ')+/u', '', $value);
    }

    /**
     * Cap a string with a single instance of a given value.
     *
     * @see https://github.com/illuminate/support/blob/master/Str.php
     *
     * @param  string  $value
     * @param  string  $cap
     *
     * @return string
     */
    public function finish(string $value, string $cap = '/'): string
    {
        $quoted = preg_quote($cap, '/');

        return preg_replace('/(?:' . $quoted . ')+$/u', '', $value) . $cap;
    }

    /**
     *  Determine if a given string starts with a given substring.
     *
     * @see https://github.com/illuminate/support/blob/master/Str.php
     *
     * @param  string  $haystack
     * @param  string|string[]  $needles
     *
     * @return bool
     */
    public function startsWith(string $haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ((string) $needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a given string ends with a given substring.
     *
     * @see https://github.com/illuminate/support/blob/master/Str.php
     *
     * @param  string  $haystack
     * @param  string|string[]  $needles
     *
     * @return bool
     */
    public function endsWith(string $haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && substr($haystack, -strlen($needle)) === (string) $needle) {
                return true;
            }
        }

        return false;
    }

    /**
     * Convert the given string to lower-case.
     *
     * @see https://github.com/illuminate/support/blob/master/Str.php
     *
     * @param  string|null  $value
     *
     * @return string
     */
    public function lower(?string $value): string
    {
        return mb_strtolower($value, 'UTF-8');
    }

    /**
     * Convert the given string to upper-case.
     *
     * @see https://github.com/illuminate/support/blob/master/Str.php
     *
     * @param  string|null  $value
     *
     * @return string
     */
    public function upper(?string $value): ?string
    {
        return mb_strtoupper($value, 'UTF-8');
    }

    /**
     * Convert a value to studly caps case.
     *
     * @see https://github.com/illuminate/support/blob/master/Str.php
     *
     * @param  string|null  $value
     *
     * @return string|null
     */
    public function studly(?string $value): ?string
    {
        $key = $value;

        if (isset(self::$studlyCache[$key])) {
            return self::$studlyCache[$key];
        }

        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return self::$studlyCache[$key] = str_replace(' ', '', $value);
    }

    /**
     * Convert a value to camel case.
     *
     * @see https://github.com/illuminate/support/blob/master/Str.php
     *
     * @param  string|null  $value
     *
     * @return string|null
     */
    public function camel(?string $value): ?string
    {
        if (isset(self::$camelCache[$value])) {
            return self::$camelCache[$value];
        }

        return self::$camelCache[$value] = lcfirst($this->studly($value));
    }

    /**
     * Convert a string to snake case.
     *
     * @see https://github.com/illuminate/support/blob/master/Str.php
     *
     * @param  string|null  $value
     * @param  string  $delimiter
     *
     * @return string|null
     */
    public function snake(?string $value, string $delimiter = '_'): ?string
    {
        $key = $value;

        if (isset(self::$snakeCache[$key][$delimiter])) {
            return self::$snakeCache[$key][$delimiter];
        }

        if (! ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));

            $value = $this->lower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value));
        }

        return self::$snakeCache[$key][$delimiter] = $value;
    }

    /**
     * Convert the given string to title case.
     *
     * @see https://github.com/illuminate/support/blob/master/Str.php
     *
     * @param  string|null  $value
     *
     * @return string|null
     */
    public function title(?string $value): ?string
    {
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Return the length of the given string.
     *
     * @see https://github.com/illuminate/support/blob/master/Str.php
     *
     * @param  string|null  $value
     * @param  string|null  $encoding
     *
     * @return int
     */
    public function length(?string $value, string $encoding = null): int
    {
        return $encoding
            ? mb_strlen($value, $encoding)
            : mb_strlen($value);
    }

    /**
     * Returns the portion of string specified by the start and length parameters.
     *
     * @see https://github.com/illuminate/support/blob/master/Str.php
     *
     * @param  string  $string
     * @param  int  $start
     * @param  int|null  $length
     *
     * @return string|null
     */
    public function substr(string $string, int $start, int $length = null): ?string
    {
        return mb_substr($string, $start, $length, 'UTF-8');
    }

    /**
     * Get the portion of a string before the first occurrence of a given value.
     *
     * @see https://github.com/illuminate/support/blob/master/Str.php
     *
     * @param  string  $subject
     * @param  string  $search
     *
     * @return string
     */
    public function before(string $subject, string $search): ?string
    {
        return ! empty($search) ? explode($search, $subject)[0] : null;
    }

    /**
     * Return the remainder of a string after the first occurrence of a given value.
     *
     * @see https://github.com/illuminate/support/blob/master/Str.php
     *
     * @param  string  $subject
     * @param  string  $search
     *
     * @return string
     */
    public function after(string $subject, string $search): ?string
    {
        return ! empty($search) ? array_reverse(explode($search, $subject, 2))[0] : null;
    }

    /**
     * Determine if a given string contains a given substring.
     *
     * @see https://github.com/illuminate/support/blob/master/Str.php
     *
     * @param  string  $haystack
     * @param  string|string[]  $needles
     *
     * @return bool
     */
    public function contains(string $haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if (! empty($needle) && mb_strpos($haystack, $needle) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determines if the value is empty.
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    public function isEmpty($value): bool
    {
        $value = is_string($value) ? trim($value) : $value;

        return empty($value) && ! is_numeric($value) && (is_string($value) || is_null($value));
    }

    /**
     * Determines if the value is doesn't empty.
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    public function doesntEmpty($value): bool
    {
        return ! $this->isEmpty($value);
    }
}
