<?php

namespace Helldar\Support\Exceptions;

use Exception;

class NotValidUrlException extends Exception
{
    public function __construct(?string $url)
    {
        $message = 'The "' . $url . '" is not a valid URL.';

        parent::__construct($message, 412);
    }
}
