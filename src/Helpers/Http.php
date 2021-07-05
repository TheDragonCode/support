<?php

namespace Helldar\Support\Helpers;

use Helldar\Support\Concerns\Deprecation;
use Helldar\Support\Helpers\Http\Uri;

/** @deprecated since 4.0: Use `Helldar\Support\Helpers\Http\Uri` instead */
class Http extends Uri
{
    use Deprecation;

    public function __construct()
    {
        self::deprecatedClass(Uri::class);
    }
}
