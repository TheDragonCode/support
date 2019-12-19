<?php

namespace Helldar\Support\Exceptions;

use Helldar\Support\Facades\Str;

class UnknownStubFileException extends \Exception
{
    public function __construct($filename = '')
    {
        $message = \sprintf('Unknown stub file: "%s"', Str::e($filename));

        parent::__construct($message, 400);
    }
}
