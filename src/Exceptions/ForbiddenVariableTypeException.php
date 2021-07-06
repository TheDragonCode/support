<?php

namespace Helldar\Support\Exceptions;

use LogicException;

class ForbiddenVariableTypeException extends LogicException
{
    public function __construct(string $haystack, $needles)
    {
        $needles = $this->needles($needles);

        $message = $this->message($haystack, $needles);

        parent::__construct($message);
    }

    protected function needles($needles): string
    {
        return is_string($needles) ? $needles : implode(', ', $needles);
    }

    protected function message(string $haystack, string $needles): string
    {
        return "Forbidden variable type: $needles needles, $haystack given.";
    }
}
