<?php

namespace Helldar\Support\Exceptions;

use Exception;

final class UnknownStubFileException extends Exception
{
    public function __construct(?string $filename)
    {
        $message = 'Unknown stub file: "' . $filename . '"';

        parent::__construct($message, 400);
    }
}
