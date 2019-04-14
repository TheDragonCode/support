<?php

namespace Helldar\Support\Exceptions;

class StubNotExists extends \InvalidArgumentException
{
    public function __construct($message = '')
    {
        $message = \sprintf('Unknown stub file: "%s"', $message);

        parent::__construct($message, 400);
    }
}
