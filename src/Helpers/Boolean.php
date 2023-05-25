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

namespace DragonCode\Support\Helpers;

use JetBrains\PhpStorm\Pure;

class Boolean
{
    /**
     * Determines if the value is `true`, otherwise it will return `false`.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function isTrue(mixed $value): bool
    {
        return static::to($value) === true;
    }

    /**
     * Determines if the value is `false`, otherwise it will return `true`.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public static function isFalse(mixed $value): bool
    {
        return static::to($value) === false;
    }

    /**
     * Converts a value to a boolean type.
     *
     * @param mixed $value
     *
     * @return bool
     */
    #[Pure]
    public static function to(mixed $value): bool
    {
        return (bool) static::parse($value);
    }

    /**
     * Getting a filtered value in a boolean view.
     *
     * @param mixed $value
     *
     * @return bool|null
     */
    public static function parse(mixed $value): ?bool
    {
        if (is_null($value)) {
            return null;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }

    /**
     * Converts a boolean value to a string.
     *
     * @param bool $value
     *
     * @return string
     */
    public static function toString(bool $value): string
    {
        return $value ? 'true' : 'false';
    }
}
