<?php

namespace Helldar\Support\Exceptions;

class NotValidUrlException extends \InvalidArgumentException
{
    public function __construct($url = '')
    {
        $message = \sprintf('The "%s" is not a valid URL.', $url);

        parent::__construct($message, 400);
    }
}
