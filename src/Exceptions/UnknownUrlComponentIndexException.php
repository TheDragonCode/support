<?php

namespace Helldar\Support\Exceptions;

use LogicException;

class UnknownUrlComponentIndexException extends LogicException
{
    public function __construct(int $component)
    {
        parent::__construct('Unknown URL component index: ' . $component);
    }
}
