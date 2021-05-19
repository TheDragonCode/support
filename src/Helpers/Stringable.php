<?php

namespace Helldar\Support\Helpers;

use Helldar\Support\Concerns\Deprecation;

/** @deprecated Use \Helldar\Support\Helpers\Ables\Stringable::class instead. */
class Stringable extends Ables\Stringable
{
    use Deprecation;

    public function __construct(?string $value = null)
    {
        static::deprecatedClass(Ables\Stringable::class);

        parent::__construct($value);
    }
}
