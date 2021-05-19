<?php

namespace Helldar\Support\Helpers;

use Helldar\Support\Concerns\Deprecation;

class Stringable extends Ables\Stringable
{
    use Deprecation;

    public function __construct(?string $value = null)
    {
        static::deprecatedClass(Ables\Stringable::class);

        parent::__construct($value);
    }
}
