<?php

use Helldar\Support\Facades\Str;

if (!function_exists('e')) {
    /**
     * Escape HTML special characters in a string.
     *
     * @param string $value
     * @param bool $double_encode
     *
     * @return string
     */
    function e(string $value, bool $double_encode = true): string
    {
        return Str::e($value, $double_encode);
    }
}

if (!function_exists('de')) {
    /**
     * Convert special HTML entities back to characters.
     *
     * @param string $value
     *
     * @return string
     */
    function de(string $value)
    {
        return Str::de($value);
    }
}

if (!function_exists('str_choice')) {
    /**
     * The str_choice function translates the given language line with inflection.
     *
     * @param float $number
     * @param array $choice
     * @param string $additional
     *
     * @return string
     */
    function str_choice(float $number, array $choice = [], string $additional = '')
    {
        return Str::choice($number, $choice, $additional);
    }
}

if (!function_exists('str_replace_spaces')) {
    /**
     * Replacing multiple spaces with a single space.
     *
     * @param string $value
     *
     * @return string|null
     */
    function str_replace_spaces(string $value): ?string
    {
        return Str::replaceSpaces($value);
    }
}

if (!function_exists('str_finish')) {
    /**
     * Cap a string with a single instance of a given value.
     *
     * @param string $value
     * @param string $cap
     *
     * @return string
     */
    function str_finish(string $value, string $cap = '/'): string
    {
        return Str::finish($value, $cap);
    }
}
