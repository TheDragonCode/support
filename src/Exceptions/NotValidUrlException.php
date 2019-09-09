<?php

namespace Helldar\Support\Exceptions;

use Helldar\Support\Facades\Str;

class NotValidUrlException extends \InvalidArgumentException
{
    public function __construct($url = '')
    {
        $message = \sprintf('The "%s" is not a valid URL.', Str::e($url));

        parent::__construct($message, 412);
    }
}
