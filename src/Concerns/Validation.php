<?php

namespace Helldar\Support\Concerns;

use Helldar\Support\Exceptions\ForbiddenVariableTypeException;
use Helldar\Support\Facades\Helpers\Ables\Arrayable;
use Helldar\Support\Facades\Helpers\Str;

trait Validation
{
    /**
     * @param  mixed  $haystack
     * @param  array|string  $needles
     */
    protected function validateType($haystack, $needles): void
    {
        $type    = $this->validateGetType($haystack);
        $needles = $this->validateNeedles($needles);

        if (! Str::contains($type, $needles)) {
            throw new ForbiddenVariableTypeException($type, $needles);
        }
    }

    protected function validateNeedles($values): array
    {
        return Arrayable::of($values)
            ->map(static function ($value) {
                return Str::lower($value);
            })->get();
    }

    protected function validateGetType($haystack): string
    {
        return Str::lower(gettype($haystack));
    }
}
