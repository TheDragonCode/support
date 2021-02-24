<?php

namespace Helldar\Support\Helpers;

final class Boolean
{
    /**
     * Determines if the value is `true`, otherwise it will return `false`.
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    public function isTrue($value): bool
    {
        return $value === true || $value === 1 || $value === '1' || $value === 'on' || $value === 'true';
    }

    /**
     * Determines if the value is `false`, otherwise it will return `true`.
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    public function isFalse($value): bool
    {
        return $value === false || $value === 0 || $value === '0' || $value === 'off' || $value === 'false';
    }

    /**
     * Converts a value to a boolean type
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    public function to($value): bool
    {
        if ($this->isTrue($value)) {
            return true;
        }

        if ($this->isFalse($value)) {
            return false;
        }

        return (bool) $value;
    }
}
