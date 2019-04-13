<?php

namespace Helldar\Support\Exceptions;

class InvalidNumberException extends \InvalidArgumentException
{
    public function __construct($message = "")
    {
        $message = \sprintf('The value of "%s" is not a number!', $message);

        parent::__construct($message, 400);
    }
}
