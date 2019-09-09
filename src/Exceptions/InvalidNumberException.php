<?php

namespace Helldar\Support\Exceptions;

use Helldar\Support\Facades\Str;

class InvalidNumberException extends \InvalidArgumentException
{
    public function __construct($message = '')
    {
        $message = \sprintf('The value of "%s" is not a number!', Str::e($message));

        parent::__construct($message, 400);
    }
}
