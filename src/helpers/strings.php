<?php

use Helldar\Support\Facades\Str;

if (! function_exists('de')) {
    /**
     * Convert special HTML entities back to characters.
     *
     * @deprecated 2.0: Using "de" is deprecated.
     *
     * @param  string  $value
     *
     * @return string
     */
    function de(string $value)
    {
        trigger_deprecation('andrey-helldar/support', '2.0', 'Using "de" is deprecated.');

        return Str::de($value);
    }
}

if (! function_exists('str_choice')) {
    /**
     * The str_choice function translates the given language line with inflection.
     *
     * @deprecated 2.0: Using "str_choice" is deprecated.
     *
     * @param  float  $number
     * @param  array  $choice
     * @param  string  $additional
     *
     * @return string
     */
    function str_choice(float $number, array $choice = [], string $additional = '')
    {
        trigger_deprecation('andrey-helldar/support', '2.0', 'Using "str_choice" is deprecated.');

        return Str::choice($number, $choice, $additional);
    }
}

if (! function_exists('str_replace_spaces')) {
    /**
     * Replacing multiple spaces with a single space.
     *
     * @deprecated 2.0: Using "str_replace_spaces" is deprecated.
     *
     * @param  string  $value
     *
     * @return string|null
     */
    function str_replace_spaces(string $value): ?string
    {
        trigger_deprecation('andrey-helldar/support', '2.0', 'Using "str_replace_spaces" is deprecated.');

        return Str::replaceSpaces($value);
    }
}

if (! function_exists('str_finish')) {
    /**
     * Cap a string with a single instance of a given value.
     *
     * @deprecated 2.0: Using "str_finish" is deprecated.
     *
     * @param  string  $value
     * @param  string  $cap
     *
     * @return string
     */
    function str_finish(string $value, string $cap = '/'): string
    {
        trigger_deprecation('andrey-helldar/support', '2.0', 'Using "str_finish" is deprecated.');

        return Str::finish($value, $cap);
    }
}

if (! function_exists('str_ends_with')) {
    /**
     * Determine if a given string ends with a given substring.
     *
     * @deprecated 2.0: Using "str_ends_with" is deprecated.
     *
     * @param  string  $haystack
     * @param  array|string  $needles
     *
     * @return bool
     */
    function str_ends_with($haystack, $needles): bool
    {
        trigger_deprecation('andrey-helldar/support', '2.0', 'Using "str_ends_with" is deprecated.');

        return Str::endsWith($haystack, $needles);
    }
}
