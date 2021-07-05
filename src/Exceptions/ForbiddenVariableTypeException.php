<?php

namespace Helldar\Support\Exceptions;

use LogicException;

class ForbiddenVariableTypeException extends LogicException
{
    public function __construct(string $haystack, string $needle)
    {
        $message = "Forbidden variable type: $needle needle, $haystack given.";

        parent::__construct($message);
    }
}
