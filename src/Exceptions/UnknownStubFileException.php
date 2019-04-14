<?php

namespace Helldar\Support\Exceptions;

class UnknownStubFileException extends \InvalidArgumentException
{
    public function __construct($filename = '')
    {
        $message = \sprintf('Unknown stub file: "%s"', $filename);

        parent::__construct($message, 400);
    }
}
