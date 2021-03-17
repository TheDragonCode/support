<?php

namespace Helldar\Support\Tools;

use Helldar\Support\Facades\Helpers\Str;

final class Sorter
{
    protected $special_chars = [
        ' ',
        '*',
        '-',
        '_',
        '=',
        '\\',
        '/',
        '|',
        '~',
        '`',
        '+',
        ':',
        ';',
        '@',
        '#',
        '$',
        '%',
        '^',
        '&',
        '?',
        '!',
        '(',
        ')',
        '{',
        '}',
        '[',
        ']',
        '§',
        '№',
        '<',
        '>',
        '.',
        ',',
    ];

    /**
     * Gets an array of special characters.
     *
     * @return string[]
     */
    public function specialChars(): array
    {
        return $this->special_chars;
    }

    /**
     * Gets a callback function for sorting.
     *
     * @return callable
     */
    public function defaultCallback(): callable
    {
        return function ($current, $next) {
            $current = $this->lower($current);
            $next    = $this->lower($next);

            if ($current === $next) {
                return 0;
            }

            if (is_string($current) && is_numeric($next)) {
                return $this->hasSpecialChar($current) ? -1 : 1;
            }

            if (is_numeric($current) && is_string($next)) {
                return $this->hasSpecialChar($next) ? 1 : -1;
            }

            return $current < $next ? -1 : 1;
        };
    }

    /**
     * Prepares a value for case-insensitive sorting.
     *
     * @param $value
     *
     * @return mixed|string|null
     */
    protected function lower($value)
    {
        return is_string($value) ? Str::lower($value) : $value;
    }

    /**
     * Determine if a value is a special character.
     *
     * @param $value
     *
     * @return bool
     */
    protected function hasSpecialChar($value): bool
    {
        return in_array($value, $this->specialChars());
    }
}
