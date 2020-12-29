<?php

namespace Helldar\Support\Exceptions;

use Exception;
use Helldar\Support\Facades\Str;
use Helldar\Support\Traits\Deprecation;

class NotValidUrlException extends Exception
{
    use Deprecation;

    public function __construct($url = '')
    {
        static::deprecatedMethodParameters(__FUNCTION__);

        $message = sprintf('The "%s" is not a valid URL.', Str::e($url));

        parent::__construct($message, 412);
    }
}
