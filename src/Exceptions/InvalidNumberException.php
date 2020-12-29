<?php

namespace Helldar\Support\Exceptions;

use Exception;
use Helldar\Support\Facades\Str;
use Helldar\Support\Traits\Deprecation;

/**
 * @deprecated Will be removed from version 2.0.
 */
class InvalidNumberException extends Exception
{
    use Deprecation;

    public function __construct($message = '')
    {
        static::deprecatedClass();

        $message = sprintf('The value of "%s" is not a number!', Str::e($message));

        parent::__construct($message, 400);
    }
}
