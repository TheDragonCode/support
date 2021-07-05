<?php

namespace Helldar\Support\Concerns;

use Helldar\Support\Exceptions\ForbiddenVariableTypeException;
use Helldar\Support\Facades\Helpers\Str;

trait Validation
{
    /**
     * @param  mixed  $haystack
     * @param  array|string  $needles
     */
    protected function validateType($haystack, $needles): void
    {
        $type = gettype($haystack);

        if (! Str::contains($type, $needles)) {
            $needles = is_array($needles) ? implode(', ', $needles) : $needles;

            throw new ForbiddenVariableTypeException($type, $needles);
        }
    }
}
