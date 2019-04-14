<?php

namespace Helldar\Support\Exceptions;

class StubNotExists extends \InvalidArgumentException
{
    public function __construct($message = '')
    {
        $message = \sprintf('The stub "%s" is not exists!', $message);

        parent::__construct($message, 400);
    }
}
