<?php

/*
 * This file is part of the "dragon-code/support" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 *
 * @copyright 2023 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/TheDragonCode/support
 */

namespace DragonCode\Support\Callbacks;

use DragonCode\Support\Helpers\Str;

class Sorter
{
    /**
     * Gets an array of special characters.
     *
     * @return string[]
     */
    public static function specialChars(): array
    {
        return [
            ' ',
            '*',
            '-',
            '_',
            '—',
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
    }

    /**
     * Gets a callback function for sorting.
     *
     * @return callable
     */
    public static function default(): callable
    {
        return function (mixed $current, mixed $next) {
            $current = static::lower($current);
            $next    = static::lower($next);

            if ($current === $next) {
                return 0;
            }

            if (is_string($current) && is_numeric($next)) {
                return static::hasSpecialChar($current) ? -1 : 1;
            }

            if (is_numeric($current) && is_string($next)) {
                return static::hasSpecialChar($next) ? 1 : -1;
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
    protected static function lower(mixed $value): mixed
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
    protected static function hasSpecialChar(mixed $value): bool
    {
        return in_array($value, static::specialChars());
    }
}
