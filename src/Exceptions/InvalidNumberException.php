<?php

namespace Helldar\Support\Exceptions;

use Exception;
use Helldar\Support\Facades\Str;

class InvalidNumberException extends Exception
{
    public function __construct($message = '')
    {
        $message = sprintf('The value of "%s" is not a number!', Str::e($message));

        parent::__construct($message, 400);
    }
}
