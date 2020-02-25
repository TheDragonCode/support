<?php

namespace Helldar\Support\Exceptions;

use Exception;

class MethodNotFoundException extends Exception
{
    public function __construct(string $class, string $method)
    {
        $message = "Method $method in the $class not found.";

        parent::__construct($message, 500);
    }
}
