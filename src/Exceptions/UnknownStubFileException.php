<?php

namespace Helldar\Support\Exceptions;

use Exception;
use Helldar\Support\Facades\Str;
use Helldar\Support\Traits\Deprecation;

class UnknownStubFileException extends Exception
{
    use Deprecation;

    public function __construct($filename = '')
    {
        static::deprecatedMethodParameters(__FUNCTION__);

        $message = sprintf('Unknown stub file: "%s"', Str::e($filename));

        parent::__construct($message, 400);
    }
}
