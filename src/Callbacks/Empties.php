<?php

namespace Helldar\Support\Callbacks;

final class Empties
{
    public function filter(): callable
    {
        return static function ($value) {
            return ! empty($value);
        };
    }

    public function filterBoth(): callable
    {
        return static function ($value, $key) {
            return ! empty($value) && ! empty($key);
        };
    }
}
