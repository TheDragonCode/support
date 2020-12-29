<?php

namespace Helldar\Support\Exceptions;

use Exception;

final class DirectoryNotFoundException extends Exception
{
    public function __construct(?string $path)
    {
        $message = 'Directory "' . $path . '" does not exist.';

        parent::__construct($message);
    }
}
