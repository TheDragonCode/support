<?php

namespace Helldar\Support\Exceptions;

use Exception;

class FileNotFoundException extends Exception
{
    public function __construct(?string $path)
    {
        $message = 'File "' . $path . '" does not exist.';

        parent::__construct($message);
    }
}
