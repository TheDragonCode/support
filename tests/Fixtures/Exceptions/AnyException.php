<?php

namespace Tests\Fixtures\Exceptions;

use Exception;

class AnyException extends Exception
{
    public function __construct()
    {
        parent::__construct('Foo Bar', 501);
    }
}
