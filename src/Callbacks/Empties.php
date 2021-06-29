<?php

namespace Helldar\Support\Callbacks;

final class Empties
{
    public function notEmpty(): callable
    {
        return static function ($value) {
            return ! empty($value);
        };
    }

    public function notEmptyBoth(): callable
    {
        return static function ($value, $key) {
            return ! empty($value) && ! empty($key);
        };
    }
}
