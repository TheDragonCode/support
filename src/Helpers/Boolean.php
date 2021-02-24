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
        return $this->to($value) === true;
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
        return $this->to($value) === false;
    }

    /**
     * Converts a value to a boolean type.
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    public function to($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}
